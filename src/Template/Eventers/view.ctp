<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Eventer $eventer
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Entry'), ['controller'=>'Queues', 'action' => 'entry', $eventer->id]) ?> </li>
        <li><?= $this->Html->link(__('Back'), [ 'action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="eventers view large-9 medium-8 columns content">
    <h3><?= h($eventer->user->handlename) ?></h3>
    <div class="related">
        <h4><?= __('対戦待ち行列') ?></h4>
        <?php if (!empty($eventer->queues)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('User') ?></th>
                <th scope="col" width ="15%"><?= __('Status') ?></th>
                <th scope="col" width ="15%"><?= __('Creation Date') ?></th>
                <th scope="col" width ="15%" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($eventer->queues as $queues): ?>
            <tr>
                <td><?= h($queues->user->handlename) ?></td>
                <td><?= $this->Html->link($queues->status, [ 'controller' => 'Queues', 'action' => 'change_status', $eventer->id, $queues->id]) ?></td>
                <td><?= h($queues->creation_date) ?></td>
                <td class="actions">
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Queues', 'action' => 'delete', $eventer->id, $queues->id], ['confirm' => __('Are you sure you want to delete # {0}?', $queues->user->handlename)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
