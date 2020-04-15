<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Black[]|\Cake\Collection\CollectionInterface $blacks
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('メイン画面'), ['controller'=>'Users', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="blacks index large-9 medium-8 columns content">
    <h3><?= __('Blacks') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col" width="15%" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($blacks as $black): ?>
            <tr>
                <td><?= $black->has('user') ? $this->Html->link($black->user->handlename, ['controller' => 'Users', 'action' => 'viewUser', $black->user->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $black->id], ['confirm' => __('Are you sure you want to delete # {0}?', $black->user->handlename)]) ?>
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
