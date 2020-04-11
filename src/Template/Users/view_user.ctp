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
            <th scope="row"><?= __('希望対戦レベル') ?></th>
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
            <th scope="row"><?= __('希望対戦時間') ?></th>
        </tr>
        <tr>
            <th scope="row"><?= __('連戦') ?></th>
            <td><?= $user->keyword06 ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('一本勝負') ?></th>
            <td><?= $user->keyword07 ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
