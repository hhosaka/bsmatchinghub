<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('View'), ['action' => 'viewUser']) ?></li>
        <li><?= $this->Html->link(__('Edit'), ['action' => 'editUser']) ?></li>
        <li><?= $this->Html->link(__('Logout'), ['action' => 'logout']) ?></li>
    </ul>
</nav>
<div class="users index large-9 medium-8 columns content">

    <h3><?= __('条件設定') ?></h3>
    <?=$this->Form->create() ?>
    <fieldset>
        <?=$this->Form->control("keyword00",['type'=>'checkbox','label'=>'競技志向']) ?>
        <?=$this->Form->control("keyword01",['type'=>'checkbox','label'=>'ショップ大会']) ?>
        <?=$this->Form->control("keyword02",['type'=>'checkbox','label'=>'フリー対戦']) ?>
        <?=$this->Form->control("keyword03",['type'=>'checkbox','label'=>'調整']) ?>
        <?=$this->Form->control("keyword06",['type'=>'checkbox','label'=>'連戦']) ?>
        <?=$this->Form->control("keyword07",['type'=>'checkbox','label'=>'一本勝負']) ?>
    </fieldset>
    <?=$this->Form->button("Send")?>
    <?=$this->Form->end()?>
    <h3><?= __('対戦待ちプレイヤーリスト') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" width ="5%"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col" width ="15%"><?= $this->Paginator->sort('handlename') ?></th>
                <th scope="col" width ="10%"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" width ="10%"><?= $this->Paginator->sort('start_time') ?></th>
                <th scope="col" width ="10%"><?= $this->Paginator->sort('end_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('comment') ?></th>
                <th scope="col" width ="15%" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $this->Number->format($user->id) ?></td>
                <td><?= h($user->handlename) ?></td>
                <td><?= h($user->status) ?></td>
                <td><?= h($user->start_time) ?></td>
                <td><?= h($user->end_time) ?></td>
                <td><?= h($user->comment) ?></td>
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
