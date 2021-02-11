<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\BlacksTable&\Cake\ORM\Association\HasMany $Blacks
 * @property \App\Model\Table\FriendsTable&\Cake\ORM\Association\HasMany $Friends
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Blacks', [
            'foreignKey' => 'owner_id',
        ]);
        
        $this->hasMany('Friends', [
            'foreignKey' => 'owner_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('username')
            ->maxLength('username', 128)
            ->requirePresence('username', 'create')
            ->notEmptyString('username');

        $validator
            ->scalar('password')
            ->maxLength('password', 128)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('handlename')
            ->maxLength('handlename', 128)
            ->requirePresence('handlename', 'create')
            ->notEmptyString('handlename');

        $validator
            ->scalar('role')
            ->maxLength('role', 16)
            ->requirePresence('role', 'create')
            ->notEmptyString('role');

        $validator
            ->scalar('status')
            ->notEmptyString('status');

        $validator
            ->dateTime('start_time')
            ->notEmptyDateTime('start_time');

        $validator
            ->dateTime('end_time')
            ->notEmptyDateTime('end_time');

        $validator
            ->boolean('accept')
            ->requirePresence('accept', 'create');

        $validator
            ->scalar('skype_account')
            ->maxLength('skype_account', 128)
            ->allowEmptyString('skype_account');

        $validator
            ->scalar('twitter_account')
            ->maxLength('twitter_account', 128)
            ->notEmptyString('twitter_account');

        $validator
            ->scalar('twicas_url')
            ->maxLength('twicas_url', 128)
            ->allowEmptyString('twicas_url');

        $validator
            ->scalar('comment')
            ->maxLength('comment', 1024)
            ->allowEmptyString('comment');

        $validator
            ->scalar('short_comment')
            ->maxLength('short_comment', 64);

        $validator
            ->scalar('keyword')
            ->maxLength('keyword', 512)
            ->allowEmptyString('keyword');

        $validator
            ->scalar('search_keyword')
            ->maxLength('search_keyword', 512)
            ->allowEmptyString('search_keyword');

        $validator
            ->scalar('use_friends')
            ->notEmptyString('use_friends');

        $validator
            ->dateTime('creation_date');

        $validator
            ->dateTime('modification_date');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['username']));

        return $rules;
    }
}
