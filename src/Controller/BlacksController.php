<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Blacks Controller
 *
 * @property \App\Model\Table\BlacksTable $Blacks
 *
 * @method \App\Model\Entity\Black[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BlacksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => [ 'Users'],
        ];
        $blacks = $this->paginate($this->Blacks);

        $this->set(compact('blacks'));
    }

    /**
     * View method
     *
     * @param string|null $id Black id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $black = $this->Blacks->get($id, [
            'contain' => [ 'Users'],
        ]);

        $this->set('black', $black);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $black = $this->Blacks->newEntity();
        if ($this->request->is('post')) {
            $black = $this->Blacks->patchEntity($black, $this->request->getData());
            if ($this->Blacks->save($black)) {
                $this->Flash->success(__('The black has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The black could not be saved. Please, try again.'));
        }
        $owners = $this->Blacks->Users->find('list', ['limit' => 200]);
        $users = $this->Blacks->Users->find('list', ['limit' => 200]);
        $this->set(compact('black', 'owners', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Black id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $black = $this->Blacks->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $black = $this->Blacks->patchEntity($black, $this->request->getData());
            if ($this->Blacks->save($black)) {
                $this->Flash->success(__('The black has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The black could not be saved. Please, try again.'));
        }
        $owners = $this->Blacks->Owners->find('list', ['limit' => 200]);
        $users = $this->Blacks->Users->find('list', ['limit' => 200]);
        $this->set(compact('black', 'owners', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Black id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $black = $this->Blacks->get($id);
        if ($this->Blacks->delete($black)) {
            $this->Flash->success(__('The black has been deleted.'));
        } else {
            $this->Flash->error(__('The black could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
