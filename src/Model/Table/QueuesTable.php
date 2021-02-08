<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Queues Model
 *
 * @property \App\Model\Table\EventersTable&\Cake\ORM\Association\BelongsTo $Eventers
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Queue get($primaryKey, $options = [])
 * @method \App\Model\Entity\Queue newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Queue[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Queue|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Queue saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Queue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Queue[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Queue findOrCreate($search, callable $callback = null, $options = [])
 */
class QueuesTable extends Table
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

        $this->setTable('queues');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Eventers', [
            'foreignKey' => 'eventer_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
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
            ->scalar('status')
            ->notEmptyString('status');

        $validator
            ->dateTime('creation_date')
            ->notEmptyDateTime('creation_date');

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
        $rules->add($rules->existsIn(['eventer_id'], 'Eventers'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
