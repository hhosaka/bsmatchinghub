<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('ユーザー登録') ?></legend>
        <?php
            echo $this->Form->control('username',['type'=>'email', 'label'=>'メールアドレス']);
            echo $this->Form->control('password',['label'=>'パスワード']); 
            echo $this->Form->control('twitter_account',['label'=>'Twitter ID']);
            echo $this->Form->control('comment',['label'=>'コメント','default'=>'よろしくおねがいします。']);
            echo $this->Html->link('利用規約', 'https://sites.google.com/site/hhosaka183/bs-matching-hub/bs-matching-hub-li-yong-gui-yue/');
            echo $this->Form->control('accept',['require'=>true, 'type'=>'checkbox', 'label'=>'利用規約に同意します。']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('送信')) ?>
    <?= $this->Form->end() ?>
</div>
