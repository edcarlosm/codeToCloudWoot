<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Templates Model
 *
 * @property \App\Model\Table\WhatsappsTable&\Cake\ORM\Association\BelongsTo $Whatsapps
 *
 * @method \App\Model\Entity\Template newEmptyEntity()
 * @method \App\Model\Entity\Template newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Template[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Template get($primaryKey, $options = [])
 * @method \App\Model\Entity\Template findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Template patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Template[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Template|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Template saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Template[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Template[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Template[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Template[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TemplatesTable extends Table
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

        $this->setTable('templates');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Whatsapps', [
            'foreignKey' => 'api_whatsapp_contanegocio_id',
            'joinType' => 'INNER',
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
            ->scalar('name')
            ->maxLength('name', 15)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('json')
            ->maxLength('json', 4294967295)
            ->allowEmptyString('json');

        $validator
            ->requirePresence('api_whatsapp_id_telefone', 'create')
            ->notEmptyString('api_whatsapp_id_telefone');

        $validator
            ->notEmptyString('api_whatsapp_contanegocio_id');

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
        return $rules;
    }
}
