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
        if(in_array($action,['index','view','add','delete'])){
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

        $this->set(compact('eventers'));
    }

    /**
     * View method
     *
     * @param string|null $id Eventer id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $eventer = $this->Eventers->get($id, [
            'contain' => ['Users', 'Queues'=>['Users']],
        ]);

        $this->set('eventer', $eventer);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    // public function add()
    // {
    //     $eventer = $this->Eventers->newEntity();
    //     if ($this->request->is('post')) {
    //         $eventer = $this->Eventers->patchEntity($eventer, $this->request->getData());
    //         if ($this->Eventers->save($eventer)) {
    //             $this->Flash->success(__('The eventer has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The eventer could not be saved. Please, try again.'));
    //     }
    //     $users = $this->Eventers->Users->find('list', ['limit' => 200]);
    //     $this->set(compact('eventer', 'users'));
    // }

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

    /**
     * Edit method
     *
     * @param string|null $id Eventer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function edit($id = null)
    // {
    //     $eventer = $this->Eventers->get($id, [
    //         'contain' => [],
    //     ]);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $eventer = $this->Eventers->patchEntity($eventer, $this->request->getData());
    //         if ($this->Eventers->save($eventer)) {
    //             $this->Flash->success(__('The eventer has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The eventer could not be saved. Please, try again.'));
    //     }
    //     $users = $this->Eventers->Users->find('list', ['limit' => 200]);
    //     $this->set(compact('eventer', 'users'));
    // }

    /**
     * Delete method
     *
     * @param string|null $id Eventer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
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
}
