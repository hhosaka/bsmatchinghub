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
            ->dateTime('start_time')
            ->notEmptyDateTime('start_time');

        $validator
            ->dateTime('end_time')
            ->notEmptyDateTime('end_time');

        $validator
            ->scalar('list_mode')
            ->notEmptyString('list_mode');

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
            ->boolean('keyword00')
            ->requirePresence('keyword00', 'create')
            ->notEmptyString('keyword00');

        $validator
            ->boolean('keyword01')
            ->requirePresence('keyword01', 'create')
            ->notEmptyString('keyword01');

        $validator
            ->boolean('keyword02')
            ->requirePresence('keyword02', 'create')
            ->notEmptyString('keyword02');

        $validator
            ->boolean('keyword03')
            ->requirePresence('keyword03', 'create')
            ->notEmptyString('keyword03');

        $validator
            ->boolean('keyword04')
            ->requirePresence('keyword04', 'create')
            ->notEmptyString('keyword04');

        $validator
            ->boolean('keyword05')
            ->requirePresence('keyword05', 'create')
            ->notEmptyString('keyword05');

        $validator
            ->boolean('keyword06')
            ->requirePresence('keyword06', 'create')
            ->notEmptyString('keyword06');

        $validator
            ->boolean('keyword07')
            ->requirePresence('keyword07', 'create')
            ->notEmptyString('keyword07');

        $validator
            ->boolean('keyword08')
            ->requirePresence('keyword08', 'create')
            ->notEmptyString('keyword08');

        $validator
            ->boolean('keyword09')
            ->requirePresence('keyword09', 'create')
            ->notEmptyString('keyword09');

        $validator
            ->boolean('keyword10')
            ->requirePresence('keyword10', 'create')
            ->notEmptyString('keyword10');

        $validator
            ->boolean('keyword11')
            ->requirePresence('keyword11', 'create')
            ->notEmptyString('keyword11');

        $validator
            ->boolean('keyword12')
            ->requirePresence('keyword12', 'create')
            ->notEmptyString('keyword12');

        $validator
            ->boolean('keyword13')
            ->requirePresence('keyword13', 'create')
            ->notEmptyString('keyword13');

        $validator
            ->boolean('keyword14')
            ->requirePresence('keyword14', 'create')
            ->notEmptyString('keyword14');

        $validator
            ->boolean('keyword15')
            ->requirePresence('keyword15', 'create')
            ->notEmptyString('keyword15');

        $validator
            ->dateTime('creation_date')
            ->notEmptyDateTime('creation_date');

        $validator
            ->dateTime('modification_date')
            ->notEmptyDateTime('modification_date');

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
