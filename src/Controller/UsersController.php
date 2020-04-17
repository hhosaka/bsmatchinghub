<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $validator = $this->Users->getValidator('default');
        $validator->add('confirm', 'no-misspelling', [
            'rule' => ['compareWith', 'password'],
            'message' => '確認用のパスワードが一致しません',
        ]);
        $validator->add('confirm_email', 'no-misspelling', [
            'rule' => ['compareWith', 'email1'],
            'message' => '確認用のメールアドレスが一致しません',
        ]);
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['entry', 'tos','logout']);
    }

    public function isAuthorized($user = null)
    {
        $action = $this->request->getParam('action');
        if(in_array($action,['index','activate','deactivate','settings','chat','view'])){
                return true;
        }
        return parent::isAuthorized($user);
    }

    public function login()
    {
        if ($this->request->isPost()) {
            $user = $this->Auth->identify();

            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            else{
                $this->Flash->error(__('ユーザー名かパスワードが違います。(ERROR002)'));
            }
        }
        $redirectUrl = $this->Auth->redirectUrl();
        $this->set('redirectUrl', $redirectUrl);
    }

    public function logout()
    {
        $this->request->getSession()->destroy();
        return $this->redirect($this->Auth->logout());
    }

    public function entry(){
        $user = $this->Users->newEntity();
        $redirectUrl = $this->request->getQuery('redirectUrl');
        echo $redirectUrl;
        if ($this->request->is('post')) {
            if($this->request->getData()['accept']){
                $user = $this->Users->patchEntity($user, $this->request->getData());
                $user['role'] = 'guest';
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('登録完了しました。'));
                    $this->Auth->setUser($user);
                    
                    return $this->redirect($redirectUrl);
                }
                else{
                    $this->Flash->error(__('登録に失敗しました。'));
                }
            }else{
                $this->Flash->error(__('登録の為には利用規約への同意が必要です。'));
            }

            $this->Flash->error(__('登録できませんでした。'));
        }
        $this->set(compact('user'));
    }

    public function getStatus($user){
        return $user['status'];
    }

    public function tos(){

    }
    private function convStr2Conds($keywords){
        $conds = null;
        foreach(explode("|", $keywords) as $keyword){
            $conds[] = ['keyword LIKE'=>'%'.$keyword.'%'];
        }
        return $conds;
    }

    private function convFlags2Conds($flags){
        $conds = null;
        if($flags['keyword00']) $conds[]=['keyword LIKE'=>'%競技志向%'];
        if($flags['keyword01']) $conds[]=['keyword LIKE'=>'%ショップ大会%'];
        if($flags['keyword02']) $conds[]=['keyword LIKE'=>'%フリー対戦%'];
        if($flags['keyword03']) $conds[]=['keyword LIKE'=>'%調整%'];
        if($flags['keyword06']) $conds[]=['keyword LIKE'=>'%連戦%'];
        if($flags['keyword07']) $conds[]=['keyword LIKE'=>'%一本勝負%'];
        return $conds;
    }

    private function convFlags2Keyword($flags){
        $keyword = "";
        if($flags['keyword00']) $keyword=$keyword.'競技志向';
        if($flags['keyword01']) $keyword=$keyword.'ショップ大会';
        if($flags['keyword02']) $keyword=$keyword.'フリー対戦';
        if($flags['keyword03']) $keyword=$keyword.'調整';
        if($flags['keyword06']) $keyword=$keyword.'連戦';
        if($flags['keyword07']) $keyword=$keyword.'一本勝負';
        return $keyword;
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $user = $this->Users->findById($this->Auth->user()['id'])->first();

        $conds[]=['Users.id !='=>$user['id']];// 本人は除く
        $conds[]=['status'=>'active']; // アクティブのみ
        $conds[]=['start_time <'=> date("Y/m/d H:i:s",strtotime('+60 minute'))];// 開始一時間前まで
        $conds[]=['end_time >='=> date("Y/m/d H:i:s")];//　終了したものは除く
        if($this->request->is('post')){
            $keywords = $this->request->getData()['search_keyword'];// 画面で設定された検索ワード
            $user['search_keyword'] = $keywords;
        }else{
            $keywords = $user['keyword'];// 定義された検索ワード
        }
        $conds = array_merge($conds, $this->convStr2Conds($keywords));

        $query = $this->Users
            ->find('all',[
                'fields'=>['Users.id','Blacks.id','handlename','start_time','end_time','comment'],
                'conditions'=>['and'=>[$conds]]])
            ->leftJoinWith('Blacks')
            ->group('Users.id')
            ->having(['COUNT(Blacks.id)'=>'0']);

        $users = $this->paginate($query);

        $this->set(compact('user', 'users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Blacks','Friends'],
        ]);

        $this->pagenate = [
            'contain' => ['Blacks','Friends'],
        ];
        $this->set('user', $user);
    }

    private function postTweet($message){
        $consumerKey       = TW_CONSUMER_KEY;
        $consumerSecret    = TW_CONSUMER_SECRET_KEY;
        $accessToken       = TW_ACCESS_TOKEN;
        $accessTokenSecret = TW_ACCESS_SECRET_TOKEN;
        
        $twitter = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

        $result = $twitter->post("statuses/update", ["status" => $message]);
    }

    public function chat($id = null)
    {
        // TODO
    }

    private function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Friends'=>['Users']],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }
    
    public function settings()
    {
        $this->edit($this->Auth->user()['id']);
    }

    private function postActivateMessage($user){
        $message = $user['handlename'];
        $message = $message . "さんが対戦希望しています。\r\n";
        $message = $message . "開始時間". $user['start_time'] . "\r\n";
        $message = $message . "終了時間". $user['end_time'] . "\r\n";
        $message = $message . "「". mb_substr($user['comment'],0,64). "」\r\n";
        $message = $message . "http://plumbline.xsrv.jp/bsmh/users";

        $this->postTweet($message);
    }

    public function activate()
    {
        $user = $this->Users->get($this->Auth->user()['id']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user['status'] = 'ACTIVE';
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Activated.'));
                $this->postActivateMessage($user);
                return $this->redirect(['action' => 'index']);
            }
            else{
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
    }

    public function deactivate()
    {
        $user = $this->Users->get($this->Auth->user()['id']);
        $user['status'] = 'INACTIVE';
        $this->Users->save($user);
        $this->Flash->success(__('Deactivated.'));
        return $this->redirect(['action' => 'index']);
    }
    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id)
    {
        $user = $this->Auth->user();
        if($user['role']=='admin'){
            $this->request->allowMethod(['post', 'delete']);
            $user = $this->Users->get($id);
            if ($this->Users->delete($user)) {
                $this->Flash->success(__('The user has been deleted.'));
            } else {
                $this->Flash->error(__('The user could not be deleted. Please, try again.'));
            }
        }else{
            $this->Flash->error(__('This action is not allowed.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
