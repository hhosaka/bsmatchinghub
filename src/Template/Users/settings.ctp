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
                __('アカウントの削除'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]
            )
        ?></li>
        <!--
            <li><?= $this->Html->link(__('List Blacks'), ['controller' => 'Blacks', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('New Black'), ['controller' => 'Blacks', 'action' => 'add']) ?></li>
        -->
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <?php
            echo $this->Form->control('username',['type'=>'email','label'=>'メールアドレス']);
            echo $this->Form->control('password',['label'=>'パスワード']);
            echo $this->Form->control('handlename',['label'=>'ハンドルネーム（この名前が公開されます）']);
            echo $this->Form->control('skype_account',['label'=>'Skype ID']);
            echo $this->Form->control('twitter_account',['label'=>'Twitter ID']);
            echo $this->Form->control('twitter_handle_name',['label'=>'Twitterのハンドルネーム']);
            echo $this->Form->control("keyword",['label'=>'キーワード']);
            echo $this->Form->control("search_keyword",['label'=>'検索キーワード']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('送信')) ?>
    <?= $this->Form->end() ?>
</div>
