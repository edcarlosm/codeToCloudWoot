<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Template Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $json
 * @property int $api_whatsapp_id_telefone
 * @property int $api_whatsapp_contanegocio_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Whatsapp $whatsapp
 */
class Template extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'name' => true,
        'json' => true,
        'api_whatsapp_id_telefone' => true,
        'api_whatsapp_contanegocio_id' => true,
        'created' => true,
        'modified' => true,
        'whatsapp' => true,
    ];
}
