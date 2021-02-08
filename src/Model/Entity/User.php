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
 * @property bool $accept
 * @property string $skype_account
 * @property string|null $twitter_account
 * @property string|null $twitter_handle_name
 * @property string $comment
 * @property string $short_comment
 * @property string $keyword
 * @property string $search_keyword
 * @property bool $use_friends
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property \Cake\I18n\FrozenTime $modification_date
 *
 * @property \App\Model\Entity\Black[] $blacks
 * @property \App\Model\Entity\Friend[] $friends
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
        'twicas_url' => true,
        'twitterid' => true,
        'comment' => true,
        'short_comment' => true,
        'keyword' => true,
        'search_keyword' => true,
        'use_friends' => true,
        'creation_date' => true,
        'modification_date' => true,
        'blacks' => true,
        'friends' => true,
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
