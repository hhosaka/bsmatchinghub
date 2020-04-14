<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Blacks'), ['controller' => 'Blacks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Black'), ['controller' => 'Blacks', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Friends'), ['controller' => 'Friends', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Friend'), ['controller' => 'Friends', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Handlename') ?></th>
            <td><?= h($user->handlename) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= h($user->role) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($user->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Skype Account') ?></th>
            <td><?= h($user->skype_account) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Twitter Account') ?></th>
            <td><?= h($user->twitter_account) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Twitter Handle Name') ?></th>
            <td><?= h($user->twitter_handle_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Comment') ?></th>
            <td><?= h($user->comment) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Short Comment') ?></th>
            <td><?= h($user->short_comment) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Keyword') ?></th>
            <td><?= h($user->keyword) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Search Keyword') ?></th>
            <td><?= h($user->search_keyword) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Time') ?></th>
            <td><?= h($user->start_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('End Time') ?></th>
            <td><?= h($user->end_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creation Date') ?></th>
            <td><?= h($user->creation_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modification Date') ?></th>
            <td><?= h($user->modification_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Accept') ?></th>
            <td><?= $user->accept ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Use Friends') ?></th>
            <td><?= $user->use_friends ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Blacks') ?></h4>
        <?php if (!empty($user->blacks)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->blacks as $blacks): ?>
            <tr>
                <td><?= h($blacks->user->handlename) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Blacks', 'action' => 'view', $blacks->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Blacks', 'action' => 'edit', $blacks->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Blacks', 'action' => 'delete', $blacks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $blacks->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Friends') ?></h4>
        <?php if (!empty($user->friends)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->friends as $friends): ?>
            <tr>
                <td><?= h($friends->handlename) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Friends', 'action' => 'view', $friends->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Friends', 'action' => 'edit', $friends->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Friends', 'action' => 'delete', $friends->id], ['confirm' => __('Are you sure you want to delete # {0}?', $friends->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
