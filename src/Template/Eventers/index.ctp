<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Eventer[]|\Cake\Collection\CollectionInterface $eventers
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $caninitiate ? $this->Html->link(__('Initiate'), ['action' => 'add']) : '' ?></li>
        <li><?= $candelete ? $this->Html->link(__('Delete'), ['action' => 'delete_eventer_self']) : '' ?></li>
        <li><?= $this->Html->link(__('Settings'), ['controller' => 'Users', 'action' => 'settings']) ?></li>
        <li><?= $isadmin ? $this->Html->link(__('Logout'), ['controller' => 'Users', 'action' => 'logout'], ['confirm' => __('You may keep login. Are you sure you want to logout?')]) : '' ?></li>
    </ul>
</nav>
<div class="eventers index large-9 medium-8 columns content">
    <h3><?= __('凸待ちキャス合同掲示板') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('TwitCasting Owner') ?></th>
                <th scope="col" width='7%'><?= $this->Paginator->sort('Waiting') ?></th>
                <th scope="col" width='7%'><?= $this->Paginator->sort('OnStage') ?></th>
                <th scope="col" width='7%'><?= $this->Paginator->sort('Win') ?></th>
                <th scope="col" width='7%'><?= $this->Paginator->sort('Lose') ?></th>
                <th scope="col" width='10%' class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($eventers as $eventer): ?>
            <tr>
                <td><?= $eventer->has('user') ? $this->Html->link($eventer->user->handlename, ['action' => 'view', $eventer->id]) : '' ?></td>
                <td><?= count(array_keys(array_column($eventer->queues,'status'),'WAITING'))?></td>
                <td><?= count(array_keys(array_column($eventer->queues,'status'),'ONSTAGE'))?></td>
                <td><?= count(array_keys(array_column($eventer->queues,'status'),'WIN'))?></td>
                <td><?= count(array_keys(array_column($eventer->queues,'status'),'LOSE'))?></td>
                <td class="actions">
                    <?= $this->Html->link('Visit', $eventer->user->twicas_url)?>
                    <?= $isadmin ? $this->Form->postLink(__('Delete'), ['action' => 'delete', $eventer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $eventer->user->handlename)]) : '' ?>
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
