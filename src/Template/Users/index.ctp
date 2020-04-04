<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Blacks'), ['controller' => 'Blacks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Black'), ['controller' => 'Blacks', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Users') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('username') ?></th>
                <th scope="col"><?= $this->Paginator->sort('password') ?></th>
                <th scope="col"><?= $this->Paginator->sort('role') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('start_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('end_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('list_mode') ?></th>
                <th scope="col"><?= $this->Paginator->sort('skype_account') ?></th>
                <th scope="col"><?= $this->Paginator->sort('twitter_account') ?></th>
                <th scope="col"><?= $this->Paginator->sort('twitter_handle_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('comment') ?></th>
                <th scope="col"><?= $this->Paginator->sort('keyword00') ?></th>
                <th scope="col"><?= $this->Paginator->sort('keyword01') ?></th>
                <th scope="col"><?= $this->Paginator->sort('keyword02') ?></th>
                <th scope="col"><?= $this->Paginator->sort('keyword03') ?></th>
                <th scope="col"><?= $this->Paginator->sort('keyword04') ?></th>
                <th scope="col"><?= $this->Paginator->sort('keyword05') ?></th>
                <th scope="col"><?= $this->Paginator->sort('keyword06') ?></th>
                <th scope="col"><?= $this->Paginator->sort('keyword07') ?></th>
                <th scope="col"><?= $this->Paginator->sort('keyword08') ?></th>
                <th scope="col"><?= $this->Paginator->sort('keyword09') ?></th>
                <th scope="col"><?= $this->Paginator->sort('keyword10') ?></th>
                <th scope="col"><?= $this->Paginator->sort('keyword11') ?></th>
                <th scope="col"><?= $this->Paginator->sort('keyword12') ?></th>
                <th scope="col"><?= $this->Paginator->sort('keyword13') ?></th>
                <th scope="col"><?= $this->Paginator->sort('keyword14') ?></th>
                <th scope="col"><?= $this->Paginator->sort('keyword15') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creation_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modification_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $this->Number->format($user->id) ?></td>
                <td><?= h($user->username) ?></td>
                <td><?= h($user->password) ?></td>
                <td><?= h($user->role) ?></td>
                <td><?= h($user->status) ?></td>
                <td><?= h($user->start_time) ?></td>
                <td><?= h($user->end_time) ?></td>
                <td><?= h($user->list_mode) ?></td>
                <td><?= h($user->skype_account) ?></td>
                <td><?= h($user->twitter_account) ?></td>
                <td><?= h($user->twitter_handle_name) ?></td>
                <td><?= h($user->comment) ?></td>
                <td><?= h($user->keyword00) ?></td>
                <td><?= h($user->keyword01) ?></td>
                <td><?= h($user->keyword02) ?></td>
                <td><?= h($user->keyword03) ?></td>
                <td><?= h($user->keyword04) ?></td>
                <td><?= h($user->keyword05) ?></td>
                <td><?= h($user->keyword06) ?></td>
                <td><?= h($user->keyword07) ?></td>
                <td><?= h($user->keyword08) ?></td>
                <td><?= h($user->keyword09) ?></td>
                <td><?= h($user->keyword10) ?></td>
                <td><?= h($user->keyword11) ?></td>
                <td><?= h($user->keyword12) ?></td>
                <td><?= h($user->keyword13) ?></td>
                <td><?= h($user->keyword14) ?></td>
                <td><?= h($user->keyword15) ?></td>
                <td><?= h($user->creation_date) ?></td>
                <td><?= h($user->modification_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
