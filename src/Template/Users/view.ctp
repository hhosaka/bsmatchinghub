<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('フレンドリストに登録'),
                ['controller' => 'Friends', 'action' => 'add', $user->id],
                ['confirm' => __('Are you sure you want to add # {0} to Friend?', $user->handlename)]
            )
        ?></li>
        <li><?= $this->Form->postLink(
                __('ブラックリストに登録'),
                ['controller' => 'Blacks', 'action' => 'add', $user->id],
                ['confirm' => __('Are you sure you want to add # {0} to Black list?', $user->handlename)]
            )
        ?></li>
        <li><?= $this->Html->link(__('メイン画面'), ['controller'=>'Users', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->handlename) ?></h3>
    <legend><?php if($hide) echo __('<<フレンド登録されるまで特定の情報は表示されません。>>'); ?></legend>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ステータス') ?></th>
            <td><?= h($user->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Skype ID') ?></th>
            <td><?= h($user->skype_account) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Twitter ID') ?></th>
            <td><?= h($user->twitter_account) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Twitterハンドルネーム') ?></th>
            <td><?= h($user->twitter_handle_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('コメント') ?></th>
            <td><?= h($user->comment) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('開始時間（開始予定時間）') ?></th>
            <td><?= h($user->start_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('終了予定時間') ?></th>
            <td><?= h($user->end_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('キーワード') ?></th>
            <td><?= h($user->keyword) ?></td>
        </tr>
    </table>
</div>
