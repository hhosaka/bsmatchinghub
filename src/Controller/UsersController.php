<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;
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
    private $keywordlist = ['競技','ショップ大会','フリー対戦','調整','連戦','一本勝負','Skype初心者','バトスピ初心者','初心者歓迎','イベント'];
    private $informationfile = "information.txt";

    // public function initialize()
    // {
    //     parent::initialize();
    //     $validator = $this->Users->getValidator('default');
    //     $validator->add('confirm', 'no-misspelling', [
    //         'rule' => ['compareWith', 'password'],
    //         'message' => '確認用のパスワードが一致しません',
    //     ]);
    // }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['entry','logout']);
    }

    public function isAuthorized($user = null)
    {
        $action = $this->request->getParam('action');
        if(in_array($action,['index','activate','deactivateSelf','settings','requestMatch','view','accept','reject','deleteSelf','senddm','settingsFromEventers'])){
                return true;
        }
        return parent::isAuthorized($user);
    }

    public function login()
    {
        $redirectUrl = $this->Auth->redirectUrl();
        if ($this->request->isPost()) {
            $user = $this->Auth->identify();

            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($redirectUrl);
            }
            else{
                $this->Flash->error(__('ユーザー名かパスワードが違います。新規の方は新規登録をお願いします。(ERROR002)'));
            }
        }
        $this->set(compact('redirectUrl'));
    }

    public function logout()
    {
        $this->request->getSession()->destroy();
        return $this->redirect(['controller'=>'Eventers', 'action'=>'index']);
    }

    public function entry(){
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if(!$data['accept']){
                $this->Flash->error(__('登録の為には利用規約への同意が必要です。'));
            }
            else{
                $info = $this->getUSerInfo($data['twitter_account']);
                if($info==null){
                    $this->Flash->error(__('TwitterのIDの存在が確認できませんでした。'));
                }
                else{
                    $user = $this->Users->patchEntity($user, $data);
                    $user['role'] = 'guest';
                    $user['handlename'] = $info->name;
                    $user['twitterid'] = $info->id;
                    if ($this->Users->save($user)) {
                        $this->Flash->success(__($user['handlename'].'さんのアカウントを登録しました。'));
                        $this->Auth->setUser($user);
                        return $this->redirect($this->request->getQuery('redirectUrl'));
                    }
                    $this->Flash->error(__('アカウントは登録できませんでした。'));
                }
            }
        }
        $this->set(compact('user'));
    }

    private function convKeywords2Conds($data){
        $list = explode(";", $data);
        $keywords = $list[0];
        $conds = null;
        foreach(explode("|", $keywords) as $keyword){
            $conds[] = ['keyword LIKE'=>'%'.$keyword.'%'];
        }
        return $conds;
    }

    private function unpackKeywords($data){
        $keywordlist = $this->keywordlist;
        $list = explode(";", $data);
        $keywords = $list[0];
        if(count($list)<2){
            $buf['leadtime'] = '+60 minute';
        }else{
            $buf['leadtime'] = $list[1];
        }
        for($i=0; $i < count($keywordlist); ++$i){
            $buf['keyword'.$i] = strpos($keywords, $keywordlist[$i]);
        }

        $buf['others'] = "";
        foreach(explode("|", $keywords) as $keyword){
            if($keyword!=""){
                if(!in_array($keyword, $keywordlist)){
                    $buf['others'].='|'.$keyword;
                }
            }
        }
        return $buf;
    }

    private function packKeyword($data){
        $keywordlist = $this->keywordlist;
        $buf = $data['others'];
        for($i=0; $i < count($keywordlist); ++$i){
            if($data['keyword'.$i]){
                $keyword = $keywordlist[$i];
                if(strpos($buf, $keyword)==false){
                    $buf .= '|'.$keyword;
                }
            }
        }
        if(array_key_exists('leadtime', $data)){
            $buf.= ';'.$data['leadtime'];
        }
        return $buf;
    }

    public function index()
    {
        $user = $this->Users->get($this->Auth->user()['id']);

        if($this->request->is('post')){
            $data = $this->request->getData();
            $user['search_keyword'] = $this->packKeyword($data);
            $this->Users->save($user);
            return $this->redirect(['?'=>['page'=>'1']]);
        }
        $data = $this->unpackKeywords($user['search_keyword']);
        $conds = $this->convKeywords2Conds($user['search_keyword']);
        if($data['leadtime']!='all'){
            $this->log('step2');
            $conds[]=['Users.id !='=>$user['id']];// 本人は除く
            $conds[]=['status'=>'active']; // アクティブのみ
            $conds[]=['end_time >='=> date("Y/m/d H:i:s")];//　終了したものは除く
            $conds[]=['start_time <'=> date("Y/m/d H:i:s",strtotime($data['leadtime']))];
        }

        $query = $this->Users
            ->find('all',[
                'fields'=>['Users.id','Blacks.id','handlename','start_time','end_time','comment','skype_account','twitter_account'],
                'conditions'=>['and'=>[$conds]]])
            ->leftJoinWith('Blacks')
            ->group('Users.id')
            ->having(['COUNT(Blacks.id)'=>'0']);

        $users = $this->paginate($query);

        $this->set('information', file_get_contents($this->informationfile));
        $this->set('keywordlist', $this->keywordlist);
        $this->set(compact('user', 'users','data'));
    }

    public function admin($id=1)
    {
        $this->index();

        if($this->request->is('post')){
            $data = $this->request->getData();
            file_put_contents($this->informationfile, $data['information']);
        }

        $information = file_get_contents($this->informationfile);
        $this->set('player',$this->Users->get($id));
    }

    public function updateid(){
        $this->log('updateid');
        foreach($this->Users->find('all') as $user){
            $info = $this->getUserInfo($user->twitter_account);
            $this->log($user->handlename);
            if($info!=null){
                $this->log($info->name);
                $user['handlename']=$info->name;
                $user['twitterid'] = $info->id;
                $this->Users->save($user);
            }
        }
        $this->redirect(['action'=>'index']);
    }

    public function makeMatch($senderid, $recieverid)
    {
        if($senderid != $recieverid){
            $sender = $this->Users->get($senderid);
            $reciever = $this->Users->get($recieverid);
            $this->offer($sender, $reciever);
            $this->offer($reciever, $sender);
            $this->Flash->success("Sent DM both players");
        }
        return $this->redirect($this->request->referer());
    }

    public function view($id = null)
    {
        $owner = $this->Auth->user();
        $user = $this->Users->get($id, [
            'contain' => ['Blacks','Friends'],
        ]);

        $hide = $user['use_friends']!='FREE' && (!in_array($owner['id'], array_column($user->friends,'user_id')));

        if($owner['role']!='admin' && $hide){
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
        $info = $twitter->get('users/show',['screen_name'=>$account]);
        if($twitter->getLastHttpcode()==200){
            // $this->log($info);
            return $info;
        }
        else{
            return null;
        }
    }

    private function senddirectmessage($twitterid, $message, $ctas=null){
        $params = [
            'event' => [
                'type' => 'message_create',
                'message_create' => [
                    'target' => [
                        'recipient_id' => $twitterid
                    ],
                    'message_data' => [
                        "text" => $message,
                        "ctas" => $ctas,
                    ]
                ]
            ]
        ];

        $this->log($ctas);

        if(TWITTER_SUPPORT=='ENABLE'){
            $response = $this->createTwitterOAuth()->post('direct_messages/events/new', $params, true);
            $this->log($response);
        }
    }

    private function postTweet($message){
        if(TWITTER_SUPPORT=='ENABLE'){
            $response = $this->createTwitterOAuth()->post("statuses/update", ["status" => $message]);
            $this->log($response);
        }
    }

    private function offer($sender, $reciever){

        $message = $sender['handlename']."(@".$sender['twitter_account'].")さんから対戦のお誘いがあります。\r\n";
        $message .= "「". mb_substr($sender['comment'],0,64). "」\r\n";
        $message .=  "Skype ID:". $sender['skype_account']."\r\n";

        $ctas = [
            [
                "type" => "web_url",
                "label" => "対戦します",
                "url" => CORE_PATH_FOR_DM."/users/accept/".$sender['id']
            ], [
                "type" => "web_url",
                "label" => "お断りします",
                "url" => CORE_PATH_FOR_DM."/users/reject/".$sender['id']
            ]
        ];

        $this->senddirectmessage($reciever->twitterid, $message, $ctas);
    }

    public function accept($senderid){
        $sender = $this->Users->get($senderid);
        $reciever = $this->Users->get($this->Auth->user()['id']);

        $sender->status = 'INACTIVE';
        $this->Users->save($sender);
        $reciever->status = 'INACTIVE';
        $this->Users->save($reciever);
        $result = true;

        $this->postTweet($sender['handlename'].'さんと'.$reciever['handlename'].'さんの対戦が始まりました。');

        $this->set(compact('sender', 'result'));
    }

    public function senddm($id=null){
        $sender = $this->Users->get($this->Auth->user()['id']);
        $reciever = $this->Users->get($id);
        if($this->request->is('post')){
            $data = $this->request->getData();
    
            $message = $sender['handlename']."さんより、メッセージがあります。\r\n「".$data['message']."」";

            $this->senddirectmessage($reciever->twitterid, $message);
            $this->Flash->success('Sent message');

            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('reciever'));
    }

    public function reject($senderid){
        $sender = $this->Users->get($senderid);
        $reciever = $this->Users->get($this->Auth->user()['id']);

        $message = $reciever['handlename']."さんより、対戦辞退される旨連絡が入りました。";

        $this->senddirectmessage($sender->twitterid, $message);
    }

    private function postActivateMessage($user){
        $message = $user['handlename'];
        $message = $message . "さんが対戦希望しています。\r\n";
        $message = $message . "開始時間". $user['start_time'] . "\r\n";
        $message = $message . "終了時間". $user['end_time'] . "\r\n";
        $message = $message . "キーワード：". mb_substr($user['keyword'],0,64). "\r\n";
        $message = $message . "「". mb_substr($user['comment'],0,64). "」\r\n";
        $message = $message . "http://plumbline.xsrv.jp/bsmh/users";

        $this->postTweet($message);
    }

    private function canAccess($sender, $reciever){
        if($reciever['use_friends']!='CLOSE' || (in_array($sender['id'], array_column($reciever->friends,'user_id')))){
            return true;
        }else{
            $this->Flash->error(__($reciever['handlename'].'さんはCLOSE設定になっています。'));
            return false;
        }

    }

    public function requestMatch($id = null)
    {
        $sender = $this->Auth->user();
        $reciever = $this->Users->get($id,['contain' => ['Friends']]);
        //$this->log("DM:".$sender['handlename']." to ".$target['handlename']);
        if($this->canAccess($sender, $reciever)){
            $this->offer($sender, $reciever);
            $this->Flash->success("Sent DM to ".__($reciever['handlename']));
        }
        return $this->redirect($this->request->referer());
    }

    public function settings()
    {
        $id = $this->Auth->user()['id'];
        $user = $this->Users->get($id, [
            'contain' => ['Friends'=>['Users']],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $user = $this->Users->patchEntity($user, $data);
//            $user['keyword'] = $this->packKeyword($data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                $this->Auth->setUser($user);
                return $this->redirect(['controller'=>'Eventers', 'action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }

//        $this->set('keywords', $this->keywordlist);
//        $this->set('data',$this->unpackKeywords($user['keyword']));
        $this->set(compact('user'));
    }

    public function activate()
    {
        $user = $this->Users->get($this->Auth->user()['id']);
        $user->start_time = date("Y/m/d H:i:s");
        $end_time = date("Y/m/d H:i:s",strtotime('+60 minute'));
        if($user->end_time < $end_time){// デバッグのため強制上書きはしない
            $user->end_time = $end_time;
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $user = $this->Users->patchEntity($user, $data);
            $user['keyword'] = $this->packKeyword($data);
            $user['end_time'] = new Time($user['start_time']." ".$data['time']);
            $user['status'] = 'ACTIVE';
            if ($this->Users->save($user)) {
                if(!$data['close']){
                    $this->postActivateMessage($user);
                }
                $this->Flash->success(__('Activated.'));
                return $this->redirect(['action' => 'index']);
            }
            else{
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set('keywords', $this->keywordlist);
        $this->set('data',$this->unpackKeywords($user['keyword']));
        $this->set(compact('user'));
    }

    public function deactivate($id){
        $user = $this->Users->get($id);
        $user['status'] = 'INACTIVE';
        $this->Users->save($user);
        $this->Flash->success(__($user->handlename.' is Deactivated.'));
        return $this->redirect($this->request->referer());
    }

    public function deactivateSelf()
    {
        $this->deactivate($this->Auth->user()['id']);
    }

    public function deleteSelf(){
        $this->delete($this->Auth->user()['id']);
    }

    public function delete($id)
    {
        //$this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
            $this->logout();
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->request->referer());
    }
}
