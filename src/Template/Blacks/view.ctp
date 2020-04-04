<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Black $black
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Black'), ['action' => 'edit', $black->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Black'), ['action' => 'delete', $black->id], ['confirm' => __('Are you sure you want to delete # {0}?', $black->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Blacks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Black'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="blacks view large-9 medium-8 columns content">
    <h3><?= h($black->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $black->has('user') ? $this->Html->link($black->user->id, ['controller' => 'Users', 'action' => 'view', $black->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($black->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Owner Id') ?></th>
            <td><?= $this->Number->format($black->owner_id) ?></td>
        </tr>
    </table>
</div>
