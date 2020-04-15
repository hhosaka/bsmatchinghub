<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('対戦希望開始'), ['action' => 'activate']) ?></li>
        <li><?= $this->Html->link(__('対戦希望終了'), ['action' => 'deactivate']) ?></li>
        <li><?= $this->Html->link(__('条件設定／ユーザー設定'), ['action' => 'settings']) ?></li>
        <li><?= $this->Html->link(__('ログアウト'), ['action' => 'logout']) ?></li>
    </ul>
</nav>
<div class="users index large-9 medium-8 columns content">

    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" width ="5%"><?= $this->Paginator->sort('id',['label'=>'ID']) ?></th>
                <th scope="col" width ="15%"><?= $this->Paginator->sort('handlename',['label'=>'ハンドルネーム']) ?></th>
                <th scope="col" width ="10%"><?= h('ステータス') ?></th>
                <th scope="col" width ="15%"><?= $this->Paginator->sort('start_time',['label'=>'開始予定時間']) ?></th>
                <th scope="col" width ="15%"><?= $this->Paginator->sort('end_time',['label'=>'終了予定時間']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('comment',['label'=>'コメント']) ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $this->Number->format($user->id) ?></td>
                <td><?= h($user->handlename) ?></td>
                <td><?= strtotime($user->start_time) > time()?'READY':'ACTIVE' ?></td>
                <td><?= h($user->start_time) ?></td>
                <td><?= h($user->end_time) ?></td>
                <td><?= h($user->comment) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('詳細'), ['action' => 'view', $user->id]) ?>
                    <?= $this->Html->link(__('チャット'), ['action' => 'chat', $user->id]) ?>
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

    <h3><?= __('検索条件') ?></h3>
    <?=$this->Form->create() ?>
    <fieldset>
    <?=$this->Form->control('search_keyword',['label'=>'検索用キーワード','default'=>$user['search_keyword']]) ?>
    </fieldset>
    <?=$this->Form->button("再検索")?>
    <?=$this->Form->end()?>
</div>
