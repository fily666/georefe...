<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MaGroups Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $MaGeneral
 *
 * @method \App\Model\Entity\MaGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\MaGroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MaGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MaGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MaGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MaGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MaGroup findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MaGroupsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('ma_groups');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('MaStatus', [
            'foreignKey' => 'status_id'
        ]);
        $this->belongsToMany('MaActions', [
            'joinTable' => 'ma_actions_groups',
            'foreignKey' => 'group_id',
            'targetForeignKey' => 'action_id'
            ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->integer('id')
                ->allowEmpty('id', 'create');

        $validator
                ->requirePresence('name', 'create')
                ->notEmpty('name');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['status_id'], 'MaStatus'));

        return $rules;
    }

}
