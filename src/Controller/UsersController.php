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
    private $information = '来週末、新弾発売記念大会を催します。乞うご期待。';// TODO
    private $conditions = ['競技','ショップ大会','フリー対戦','調整','連戦','一本勝負','Skype初心者','BSMH杯'];

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
        if(in_array($action,['index','activate','deactivate','settings','requestMatch','view'])){
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

    public function tos(){

    }
    private function convStr2Conds($keywords){
        $conds = null;
        foreach(explode("|", $keywords) as $keyword){
            $conds[] = ['keyword LIKE'=>'%'.$keyword.'%'];
        }
        return $conds;
    }

    private function unpackKeywords($search_keywords){
        $keywords = $this->conditions;
        $count = count($keywords);
        $buf = null;
        for($i=0; $i<$count; ++$i){
            if(strpos($search_keywords, $keywords[$i])!==false){
                $buf['keyword'.$i] =  '1';
            }else{
                $buf['keyword'.$i] =  '0';
            }
        }

        $buf['search_keyword'] = "";
        foreach(explode("|", $search_keywords) as $keyword){
            if($keyword!=""){
                if(!in_array($keyword, $keywords)){
                    $buf['search_keyword'].='|'.$keyword;
                }
            }
        }
        return $buf;
    }

    private function packKeyword($data){
        $keywords = $this->conditions;
        $count = count($keywords);
        $buf = $data['search_keyword'];
        for($i=0;$i<$count;++$i){
            if($data['keyword'.$i]){
                $keyword = $keywords[$i];
                if(strpos($buf, $keyword)==false){
                    $buf .= '|'.$keyword;
                }
            }
        }
        return $buf;
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
            $user['search_keyword'] = $this->packKeyword($this->request->getData());
            $this->Users->save($user);
        }
        $conds = array_merge($conds, $this->convStr2Conds($user['search_keyword']));

        $query = $this->Users
            ->find('all',[
                'fields'=>['Users.id','Blacks.id','handlename','start_time','end_time','comment'],
                'conditions'=>['and'=>[$conds]]])
            ->leftJoinWith('Blacks')
            ->group('Users.id')
            ->having(['COUNT(Blacks.id)'=>'0']);

        $users = $this->paginate($query);

        $this->set('information', $this->getUserInfo('BSMatchingHub')->description);
        $this->set('conditions', $this->conditions);
        $data = $this->unpackKeywords($user['search_keyword']);
        $this->set(compact('user', 'users','data'));
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
        $targetid = $this->Auth->user()['id'];
        
        $user = $this->Users->get($id, [
            'contain' => ['Blacks','Friends'],
        ]);

        $hide = $user['use_friends']!='FREE' && (!in_array($targetid, array_column($user->friends,'user_id')));

        if($hide){
            $user['username'] = '***';
            $user['skype_account'] = '***';
            $user['twitter_account'] = '***';
            $user['twitter_handle_name'] = '***';
        }

        $this->pagenate = [
            'contain' => ['Blacks','Friends'],
        ];

        $this->set(compact('user', 'hide'));
    }

    private function createTwitterOAuth(){
        $consumerKey       = TW_CONSUMER_KEY;
        $consumerSecret    = TW_CONSUMER_SECRET_KEY;
        $accessToken       = TW_ACCESS_TOKEN;
        $accessTokenSecret = TW_ACCESS_SECRET_TOKEN;
        
        return new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
    }

    private function getUserInfo($account){
        $twitter = $this->createTwitterOAuth();
        return $twitter->get('users/show',['screen_name'=>$account]);
    }

    private function sendDM($dmto, $message){

        $twitter = $this->createTwitterOAuth();
        $userinfo = $twitter->get('users/show',['screen_name'=>$dmto]);

        $params = [
            'event' => [
                'type' => 'message_create',
                'message_create' => [
                    'target' => [
                        'recipient_id' => $userinfo->id
                    ],
                    'message_data' => [
                        "text" => $message
                    ]
                ]
            ]
        ];
        $response = $twitter->post('direct_messages/events/new', $params, true);
        //$this->log($response);
    }

    private function postTweet($message){
        $response = $this->createTwitterOAuth()->post("statuses/update", ["status" => $message]);
        //$this->log($response);
    }

    private function sendMatchRequest($sender, $target){

        $message = $sender['handlename']."(@".$sender['twitter_account'].")さんから対戦のオファーがあります。\r\n";
        $message = $message . "「". mb_substr($sender['comment'],0,64). "」\r\n";
        $message = $message . "Skype ID:". $sender['skype_account']."\r\n";
        $message = $message . "http://plumbline.xsrv.jp/bsmh/users";

        $this->sendDM($target->twitter_account, $message);
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

    public function requestMatch($id = null)
    {
        $target = $this->Users->get($id,['contain' => ['Friends']]);
        $user = $this->Auth->user();
        $this->log($target);
        $this->log($user);
        if($target['use_friends']!='CLOSE' || (in_array($user['id'], array_column($target->friends,'user_id')))){
            $this->sendMatchRequest($this->Auth->user(), $this->Users->get($id));
        }
        else{
            $this->Flash->error(__($target['handlename'].'さんのフレンドに登録されていません。'));
        }
        return $this->redirect($this->request->referer());
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
