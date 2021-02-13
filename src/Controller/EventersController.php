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
    public function isAuthorized($user = null)
    {
        $action = $this->request->getParam('action');
        if(in_array($action,['index','view','add','delete','deleteQueue','changeStatus','entry'])){
                return true;
        }
        return parent::isAuthorized($user);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Queues'],
        ];
        $eventers = $this->paginate($this->Eventers);
        $user = $this->Auth->user();
        $caninitiate = $user['twicas_url']!='' && $this->Eventers->find('all',['conditions'=>['user_id'=>$user['id']]])->first()==null;

        $this->set(compact('eventers','caninitiate'));
    }

    public function view($id = null)
    {
        $eventer = $this->Eventers->get($id, [
            'contain' => ['Users', 'Queues'=>['Users']],
        ]);

        $user = $this->Auth->user();
        $canentry = true;
//        $canentry = $user['id']!=$eventer['user_id'] && !in_array($user['id'], array_column($eventer->queues, 'user_id'));

        $this->set(compact('eventer', 'canentry'));
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

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
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
        $this->loadModel('Queues');
        $queue = $this->Queues->newEntity();
        $queue['eventer_id'] = $eventerid;
        $queue['user_id']=$this->Auth->user()['id'];
        if (!$this->Queues->save($queue)) {
            $this->Flash->error(__('The eventer could not be saved. Please, try again.'));
        }
        return $this->redirect(['action' => 'view', $eventerid]);
    }

    public function deleteQueue($eventerid=null, $id=null)
    {
        $this->loadModel('Queues');
        $this->request->allowMethod(['post', 'delete']);
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
        $this->loadModel('Queues');
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

    public function switch($status=null, $eventerid=null, $id=null)
    {
        $this->loadModel('Queues');
        $queue = $this->Queues->get($id);
        $queue['status'] = $status;
        if (!$this->Queues->save($queue)) {
            $this->Flash->error(__('The queue could not be saved. Please, try again.'));
        }
        return $this->redirect(['action' => 'view', $eventerid]);
    }
}
