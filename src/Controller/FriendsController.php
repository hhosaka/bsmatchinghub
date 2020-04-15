<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Friends Controller
 *
 * @property \App\Model\Table\FriendsTable $Friends
 *
 * @method \App\Model\Entity\Friend[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FriendsController extends AppController
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
        $friends = $this->paginate($this->Friends->findByOwnerId($this->Auth->user()['id']));

        $this->set(compact('friends'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($userid)
    {
        $ownerid = $this->Auth->user()['id'];
        if(!$this->Friends->exists(['owner_id'=>$ownerid, 'user_id'=>$userid])){
            $friend = $this->Friends->newEntity();
            $friend['owner_id'] = $ownerid;
            $friend['user_id'] = $userid;
    
            if ($this->Friends->save($friend)) {
                $this->Flash->success(__('The friend has been saved.'));
            }
            else{
                $this->Flash->error(__('The friend could not be saved. Please, try again.'));
            }
        }
        $this->redirect($this->request->referer());
    }

    /**
     * Delete method
     *
     * @param string|null $id Friend id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id)
    {
        $owner_id = $this->Auth->user()['id'];
        $this->request->allowMethod(['post', 'delete']);
        $friend = $this->Friends->get($id);
        if($friend->owner_id==$owner_id){
            if ($this->Friends->delete($friend)) {
                $this->Flash->success(__('The friend has been deleted.'));
            } else {
                $this->Flash->error(__('The friend could not be deleted. Please, try again.'));
            }
        }else{
            $this->Flash->error(__('The friend could not be deleted. it is not yours.'));
        }
        return $this->redirect($this->request->referer());
    }
}
