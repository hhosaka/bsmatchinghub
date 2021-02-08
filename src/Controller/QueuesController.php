<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Queues Controller
 *
 * @property \App\Model\Table\QueuesTable $Queues
 *
 * @method \App\Model\Entity\Queue[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class QueuesController extends AppController
{
    public function isAuthorized($user = null)
    {
        $action = $this->request->getParam('action');
        if(in_array($action,['index','entry','add','delete','changeStatus'])){
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
            'contain' => ['Eventers', 'Users'],
        ];
        $queues = $this->paginate($this->Queues);

        $this->set(compact('queues'));
    }

    /**
     * View method
     *
     * @param string|null $id Queue id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $queue = $this->Queues->get($id, [
            'contain' => ['Eventers', 'Users'],
        ]);

        $this->set('queue', $queue);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $queue = $this->Queues->newEntity();
        if ($this->request->is('post')) {
            $queue = $this->Queues->patchEntity($queue, $this->request->getData());
            if ($this->Queues->save($queue)) {
                $this->Flash->success(__('The queue has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The queue could not be saved. Please, try again.'));
        }
        $eventers = $this->Queues->Eventers->find('list', ['limit' => 200]);
        $users = $this->Queues->Users->find('list', ['limit' => 200]);
        $this->set(compact('queue', 'eventers', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Queue id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function edit($id = null)
    // {
    //     $queue = $this->Queues->get($id, [
    //         'contain' => [],
    //     ]);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $queue = $this->Queues->patchEntity($queue, $this->request->getData());
    //         if ($this->Queues->save($queue)) {
    //             $this->Flash->success(__('The queue has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The queue could not be saved. Please, try again.'));
    //     }
    //     $eventers = $this->Queues->Eventers->find('list', ['limit' => 200]);
    //     $users = $this->Queues->Users->find('list', ['limit' => 200]);
    //     $this->set(compact('queue', 'eventers', 'users'));
    // }

    /**
     * Delete method
     *
     * @param string|null $id Queue id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    public function delete($eventerid=null, $id=null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $queue = $this->Queues->get($id);
        if ($this->Queues->delete($queue)) {
            $this->Flash->success(__('The queue has been deleted.'));
        } else {
            $this->Flash->error(__('The queue could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller'=>'Eventers','action' => 'view', $eventerid]);
    }

    public function entry($eventerid=null)
    {
        $queue = $this->Queues->newEntity();
        $queue['eventer_id'] = $eventerid;
        $queue['user_id']=$this->Auth->user()['id'];
        if (!$this->Queues->save($queue)) {
            $this->Flash->error(__('The eventer could not be saved. Please, try again.'));
        }
        return $this->redirect(['controller'=>'Eventers','action' => 'view', $eventerid]);
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
            $queue['status'] = 'WAITING';
            break;
        }
        if (!$this->Queues->save($queue)) {
            $this->Flash->error(__('The queue could not be saved. Please, try again.'));
        }
        return $this->redirect(['controller' => 'Eventers','action' => 'view', $eventerid]);
    }

}
