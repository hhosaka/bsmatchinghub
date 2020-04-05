<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->handlename) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('メールアドレス') ?></th>
            <td><?= h($user->username) ?></td>
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
            <th scope="row"><?= __('どんな対戦を希望しているか（対戦レベル）') ?></th>
        </tr>
        <tr>
            <th scope="row"><?= __('競技志向') ?></th>
            <td><?= $user->keyword00 ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ショップ大会') ?></th>
            <td><?= $user->keyword01 ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('フリー対戦') ?></th>
            <td><?= $user->keyword02 ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('調整') ?></th>
            <td><?= $user->keyword03 ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('どんな対戦を希望しているか（時間）') ?></th>
        </tr>
        <tr>
            <th scope="row"><?= __('連戦') ?></th>
            <td><?= $user->keyword06 ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('一本勝負') ?></th>
            <td><?= $user->keyword07 ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('登録日時') ?></th>
            <td><?= h($user->creation_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('更新日時') ?></th>
            <td><?= h($user->modification_date) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('ブラックリスト') ?></h4>
        <?php if (!empty($user->blacks)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Owner Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->blacks as $blacks): ?>
            <tr>
                <td><?= h($blacks->id) ?></td>
                <td><?= h($blacks->owner_id) ?></td>
                <td><?= h($blacks->user_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Blacks', 'action' => 'view', $blacks->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Blacks', 'action' => 'edit', $blacks->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Blacks', 'action' => 'delete', $blacks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $blacks->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
