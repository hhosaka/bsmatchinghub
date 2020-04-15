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
    public function isAuthorized($user = null)
    {
        return true;
    }

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
        $blacks = $this->paginate($this->Blacks->findByOwnerId($this->Auth->user()['id']));

        $this->set(compact('blacks'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($userid)
    {
        $ownerid = $this->Auth->user()['id'];
        if(!$this->Blacks->exists(['owner_id'=>$ownerid, 'user_id'=>$userid])){
            $black = $this->Blacks->newEntity();
            $black['owner_id'] = $ownerid;
            $black['user_id'] = $userid;
    
            if ($this->Blacks->save($black)) {
                $this->Flash->success(__('The black has been saved.'));
            }
            else{
                $this->Flash->error(__('The black could not be saved. Please, try again.'));
            }
        }
        $this->redirect($this->request->referer());
    }

    /**
     * Delete method
     *
     * @param string|null $id Black id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id)
    {
        $owner_id = $this->Auth->user()['id'];
        $this->request->allowMethod(['post', 'delete']);
        $black = $this->Blacks->get($id);
        if($black->owner_id==$owner_id){
            if ($this->Blacks->delete($black)) {
                $this->Flash->success(__('The black has been deleted.'));
            } else {
                $this->Flash->error(__('The black could not be deleted. Please, try again.'));
            }
        }else{
            $this->Flash->error(__('The black could not be deleted. it is not yours.'));
        }
        return $this->redirect($this->request->referer());
    }
}
