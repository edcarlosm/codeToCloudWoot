<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Whatsapp Entity
 *
 * @property int $id
 * @property string $nome
 * @property string $numero_telefone
 * @property int $id_telefone
 * @property int $id_contanegocios_api
 * @property string $user_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $api_key_server
 * @property string $instancia
 *
 * @property \CakeDC\Users\Model\Entity\User $user
 */
class Whatsapp extends Entity
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
        'nome' => true,
        'numero_telefone' => true,
        'id_telefone' => true,
        'id_contanegocios_api' => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'api_key_server' => true,
        'instancia' => true,
        'user' => true,
    ];
}
