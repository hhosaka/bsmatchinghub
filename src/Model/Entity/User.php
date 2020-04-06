<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $handlename
 * @property string $role
 * @property string $status
 * @property \Cake\I18n\FrozenTime $start_time
 * @property \Cake\I18n\FrozenTime $end_time
 * @property string $list_mode
 * @property string $skype_account
 * @property string|null $twitter_account
 * @property string|null $twitter_handle_name
 * @property string $comment
 * @property bool $keyword00
 * @property bool $keyword01
 * @property bool $keyword02
 * @property bool $keyword03
 * @property bool $keyword04
 * @property bool $keyword05
 * @property bool $keyword06
 * @property bool $keyword07
 * @property bool $keyword08
 * @property bool $keyword09
 * @property bool $keyword10
 * @property bool $keyword11
 * @property bool $keyword12
 * @property bool $keyword13
 * @property bool $keyword14
 * @property bool $keyword15
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property \Cake\I18n\FrozenTime $modification_date
 *
 * @property \App\Model\Entity\Black[] $blacks
 */
class User extends Entity
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
        'username' => true,
        'password' => true,
        'handlename' => true,
        'role' => true,
        'status' => true,
        'start_time' => true,
        'end_time' => true,
        'accept' => true,
        'skype_account' => true,
        'twitter_account' => true,
        'twitter_handle_name' => true,
        'comment' => true,
        'keyword00' => true,
        'keyword01' => true,
        'keyword02' => true,
        'keyword03' => true,
        'keyword04' => true,
        'keyword05' => true,
        'keyword06' => true,
        'keyword07' => true,
        'keyword08' => true,
        'keyword09' => true,
        'keyword10' => true,
        'keyword11' => true,
        'keyword12' => true,
        'keyword13' => true,
        'keyword14' => true,
        'keyword15' => true,
        'creation_date' => true,
        'modification_date' => true,
        'blacks' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }
}
