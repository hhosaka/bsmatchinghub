<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Black[]|\Cake\Collection\CollectionInterface $blacks
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Black'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="blacks index large-9 medium-8 columns content">
    <h3><?= __('Blacks') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('owner_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($blacks as $black): ?>
            <tr>
                <td><?= $this->Number->format($black->id) ?></td>
                <td><?= $this->Number->format($black->owner_id) ?></td>
                <td><?= $black->has('user') ? $this->Html->link($black->user->id, ['controller' => 'Users', 'action' => 'view', $black->user->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $black->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $black->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $black->id], ['confirm' => __('Are you sure you want to delete # {0}?', $black->id)]) ?>
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
