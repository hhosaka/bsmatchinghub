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
        <li><?= $this->Html->link(__('Back'), [ 'action' => 'index']) ?> </li>
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
                <td><?= $this->Html->link($queues->status, [ 'action' => 'change_status', $eventer->id, $queues->id]) ?></td>
                <td><?= h($queues->creation_date) ?></td>
                <td class="actions">
                    <?= $this->Form->postLink(__('OnStage'), ['action' => 'switch', 'ONSTAGE', $eventer->id, $queues->id]) ?>
                    <?= $this->Form->postLink(__('Win'), ['action' => 'switch', 'WIN', $eventer->id, $queues->id]) ?>
                    <?= $this->Form->postLink(__('Lose'), ['action' => 'switch', 'LOSE', $eventer->id, $queues->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete_queue', $eventer->id, $queues->id], ['confirm' => __('Are you sure you want to delete # {0}?', $queues->user->handlename)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
