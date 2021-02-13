<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Eventers Controller
 *
 * @property \App\Model\Table\EventersTable $Eventers
 *
 * @method \App\Model\Entity\Eventer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EventersController extends AppController
{
    public function initialize()
    {
        $this->loadModel('Queues');
        parent::initialize();
    }

    public function isAuthorized($user = null)
    {
        return true;
    }

    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Queues'],
        ];
        $eventers = $this->paginate($this->Eventers);
        $user = $this->Auth->user();
        $isadmin = $user['role']=='admin';
        $exists = $this->Eventers->find('all',['conditions'=>['user_id'=>$user['id']]])->first()!=null;
        $caninitiate = $isadmin || ( $user['twicas_url']!='' && !$exists );
        $candelete = $isadmin || $exists;

        $this->set(compact('eventers','isadmin', 'caninitiate', 'candelete'));
    }

    public function view($id = null)
    {
        $eventer = $this->Eventers->get($id, [
            'contain' => ['Users', 'Queues'=>['Users']],
        ]);

        $user = $this->Auth->user();
        $isadmin = $user['role']=='admin';
        $userid = $user['id'];
        $exists = in_array($user['id'], array_column($eventer->queues, 'user_id'));
        $canentry = $isadmin  || ( $user['id']!=$eventer['user_id'] &&  !$exists);

        $this->set(compact('eventer', 'isadmin', 'canentry', 'exists','userid'));
    }

    public function add()
    {
        $eventer = $this->Eventers->newEntity();
        $eventer['user_id'] = $this->Auth->user()['id'];
        if ($this->Eventers->save($eventer)) {
            $this->Flash->success(__('The eventer has been saved.'));
        }else{
            $this->Flash->error(__('The eventer could not be saved. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function deleteEventerSelf(){
        $userid = $this->Auth->user()['id'];
        $id = $this->Eventers->find('all',['conditions'=>['user_id'=>$userid]])->first()['id'];
        $this->delete($id);
    }

    public function delete($id = null)
    {
        $eventer = $this->Eventers->get($id);
        if ($this->Eventers->delete($eventer)) {
            $this->Flash->success(__('The eventer has been deleted.'));
        } else {
            $this->Flash->error(__('The eventer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function entry($eventerid=null)
    {
        $queue = $this->Queues->newEntity();
        $queue['eventer_id'] = $eventerid;
        $queue['user_id']=$this->Auth->user()['id'];
        if (!$this->Queues->save($queue)) {
            $this->Flash->error(__('The eventer could not be saved. Please, try again.'));
        }
        return $this->redirect(['action' => 'view', $eventerid]);
    }

    public function deleteQueueSelf($eventerid=null){
        $userid = $this->Auth->user()['id'];
        $id = $this->Queues->find('all',['conditions'=>['eventer_id'=>$eventerid, 'user_id'=>$userid]])->first()['id'];
        $this->deleteQueue($eventerid, $id);
    }

    public function deleteQueue($eventerid=null, $id=null)
    {
        $queue = $this->Queues->get($id);
        if ($this->Queues->delete($queue)) {
            $this->Flash->success(__('The queue has been deleted.'));
        } else {
            $this->Flash->error(__('The queue could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'view', $eventerid]);
    }

    public function changeStatus($eventerid=null, $id=null)
    {
        $queue = $this->Queues->get($id);
        switch($queue['status']){
        case 'WAITING':
            $queue['status'] = 'ONSTAGE';
            break;
        case 'ONSTAGE':
            $queue['status'] = 'WIN';
            break;
        case 'WIN':
            $queue['status'] = 'LOSE';
            break;
        case 'LOSE':
            $queue['status'] = 'CANCEL';
            break;
        case 'CANCEL':
            $queue['status'] = 'WAITING';
            break;
        }
        if (!$this->Queues->save($queue)) {
            $this->Flash->error(__('The queue could not be saved. Please, try again.'));
        }
        return $this->redirect(['action' => 'view', $eventerid]);
    }

    private function getSelfQueueId($eventerid){
        $userid = $this->Auth->user()['id'];
        return $this->Queues->find('all',['conditions'=>['eventer_id'=>$eventerid, 'user_id'=>$userid]])->first()['id'];
    }

    public function switchSelf($status=null, $eventerid=null){
        $userid = $this->Auth->user()['id'];
        $id = $this->Queues->find('all',['conditions'=>['eventer_id'=>$eventerid, 'user_id'=>$userid]])->first()['id'];
        $this->switch($status, $eventerid, $this->getSelfQueueId($eventerid));
    }

    public function switch($status=null, $eventerid=null, $id=null)
    {
        $queue = $this->Queues->get($id);
        $queue['status'] = $status;
        if (!$this->Queues->save($queue)) {
            $this->Flash->error(__('The queue could not be saved. Please, try again.'));
        }
        return $this->redirect(['action' => 'view', $eventerid]);
    }
}
