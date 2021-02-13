<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Eventer $eventer
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $canentry ? $this->Html->link(__('Entry'), [ 'action' => 'entry', $eventer->id]) : ''?> </li>
        <li><?= $exists ? $this->Html->link(__('OnStage'), [ 'action' => 'switch_self', 'ONSTAGE', $eventer->id]) : ''?> </li>
        <li><?= $exists ? $this->Html->link(__('Win'), [ 'action' => 'switch_self', 'WIN', $eventer->id]) : ''?> </li>
        <li><?= $exists ? $this->Html->link(__('Lose'), [ 'action' => 'switch_self', 'LOSE', $eventer->id]) : ''?> </li>
        <li><?= $exists ? $this->Html->link(__('Cancel'), [ 'action' => 'switch_self', 'CANCEL', $eventer->id]) : ''?> </li>
        <li><?= $exists ? $this->Html->link(__('Delete'), [ 'action' => 'delete_queue_self', $eventer->id]) : ''?> </li>
        <li><?= $this->Html->link(__('Main Page'), [ 'action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="eventers view large-9 medium-8 columns content">
    <h3><?= $this->Html->link(h($eventer->user->handlename), $eventer->user->twicas_url)?></h3>
    <div class="related">
        <h4><?= __('Waiting Queue') ?></h4>
        <?php if (!empty($eventer->queues)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('User') ?></th>
                <th scope="col" width ="15%"><?= __('Status') ?></th>
                <th scope="col" width ="15%"><?= __('Creation Date') ?></th>
                <th scope="col" width ="20%" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($eventer->queues as $queues): ?>
            <tr>
                <td><?= h($queues->user->handlename) ?></td>
                <td><?= $isadmin || $queues['user_id']==$userid ? $this->Html->link($queues->status, [ 'action' => 'change_status', $eventer->id, $queues->id]) : $queues->status ?></td>
                <td><?= h($queues->creation_date) ?></td>
                <td class="actions">
                    <?= $isadmin ? $this->Form->postLink(__('Delete'), ['action' => 'delete_queue', $eventer->id, $queues->id], ['confirm' => __('Are you sure you want to delete # {0}?', $queues->user->handlename)]) : '***' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
