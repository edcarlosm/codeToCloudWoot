<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Whatsapps Model
 *
 * @property \CakeDC\Users\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Whatsapp newEmptyEntity()
 * @method \App\Model\Entity\Whatsapp newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Whatsapp[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Whatsapp get($primaryKey, $options = [])
 * @method \App\Model\Entity\Whatsapp findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Whatsapp patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Whatsapp[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Whatsapp|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Whatsapp saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Whatsapp[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Whatsapp[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Whatsapp[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Whatsapp[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WhatsappsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('whatsapps');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'CakeDC\Users\Model\Table\UsersTable'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('nome')
            ->maxLength('nome', 20)
            ->requirePresence('nome', 'create')
            ->notEmptyString('nome');

        $validator
            ->scalar('numero_telefone')
            ->maxLength('numero_telefone', 20)
            ->requirePresence('numero_telefone', 'create')
            ->notEmptyString('numero_telefone');

        $validator
            ->requirePresence('id_telefone', 'create')
            ->notEmptyString('id_telefone')
            ->add('id_telefone', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('id_contanegocios_api', 'create')
            ->notEmptyString('id_contanegocios_api')
            ->add('id_contanegocios_api', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->uuid('user_id')
            ->notEmptyString('user_id');

        $validator
            ->scalar('api_key_server')
            ->maxLength('api_key_server', 255)
            ->requirePresence('api_key_server', 'create')
            ->notEmptyString('api_key_server');

        $validator
            ->scalar('instancia')
            ->maxLength('instancia', 255)
            ->requirePresence('instancia', 'create')
            ->notEmptyString('instancia');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['id_telefone']), ['errorField' => 'id_telefone']);
        $rules->add($rules->isUnique(['id_contanegocios_api']), ['errorField' => 'id_contanegocios_api']);
        $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
