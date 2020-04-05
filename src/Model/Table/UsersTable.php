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
            'foreignKey' => 'user_id',
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
            ->maxLength('status', 32)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->dateTime('start_time');

        $validator
            ->dateTime('end_time');

        $validator
            ->scalar('skype_account')
            ->maxLength('skype_account', 128)
            ->requirePresence('skype_account', 'create')
            ->notEmptyString('skype_account');

        $validator
            ->scalar('twitter_account')
            ->maxLength('twitter_account', 128)
            ->allowEmptyString('twitter_account');

        $validator
            ->scalar('twitter_handle_name')
            ->maxLength('twitter_handle_name', 128)
            ->allowEmptyString('twitter_handle_name');

        $validator
            ->scalar('comment')
            ->maxLength('comment', 1024)
            ->requirePresence('comment', 'create')
            ->notEmptyString('comment');

        $validator
            ->boolean('keyword00');

        $validator
            ->boolean('keyword01');

        $validator
            ->boolean('keyword02');

        $validator
            ->boolean('keyword03');

        $validator
            ->boolean('keyword04');

        $validator
            ->boolean('keyword05');

        $validator
            ->boolean('keyword06');

        $validator
            ->boolean('keyword07');

        $validator
            ->boolean('keyword08');

        $validator
            ->boolean('keyword09');

        $validator
            ->boolean('keyword10');

        $validator
            ->boolean('keyword11');

        $validator
            ->boolean('keyword12');

        $validator
            ->boolean('keyword13');

        $validator
            ->boolean('keyword14');

        $validator
            ->boolean('keyword15');

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
