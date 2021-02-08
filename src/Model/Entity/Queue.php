<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Queue Entity
 *
 * @property int $id
 * @property int $eventer_id
 * @property int $user_id
 * @property string $status
 * @property \Cake\I18n\FrozenTime $creation_date
 *
 * @property \App\Model\Entity\Eventer $eventer
 * @property \App\Model\Entity\User $user
 */
class Queue extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'eventer_id' => true,
        'user_id' => true,
        'status' => true,
        'creation_date' => true,
        'eventer' => true,
        'user' => true,
    ];
}
