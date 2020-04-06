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
        <?=$this->Form->control("keyword00",['type'=>'checkbox','label'=>'競技志向','default'=>$user['keyword00']]) ?>
        <?=$this->Form->control("keyword01",['type'=>'checkbox','label'=>'ショップ大会','default'=>$user['keyword01']]) ?>
        <?=$this->Form->control("keyword02",['type'=>'checkbox','label'=>'フリー対戦','default'=>$user['keyword02']]) ?>
        <?=$this->Form->control("keyword03",['type'=>'checkbox','label'=>'調整','default'=>$user['keyword03']]) ?>
        <?=$this->Form->control("keyword06",['type'=>'checkbox','label'=>'連戦','default'=>$user['keyword06']]) ?>
        <?=$this->Form->control("keyword07",['type'=>'checkbox','label'=>'一本勝負','default'=>$user['keyword07']]) ?>
    </fieldset>
    <?=$this->Form->button("再検索")?>
    <?=$this->Form->end()?>
    <h3><?= __('対戦待ちプレイヤーリスト') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" width ="5%"><?= $this->Paginator->sort('id',['label'=>'ID']) ?></th>
                <th scope="col" width ="15%"><?= $this->Paginator->sort('handlename',['label'=>'ハンドルネーム']) ?></th>
                <th scope="col" width ="10%"><?= $this->Paginator->sort('status',['label'=>'ステータス']) ?></th>
                <th scope="col" width ="10%"><?= $this->Paginator->sort('start_time',['label'=>'開始予定時間']) ?></th>
                <th scope="col" width ="10%"><?= $this->Paginator->sort('end_time',['label'=>'終了予定時間']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('comment',['label'=>'コメント']) ?></th>
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
