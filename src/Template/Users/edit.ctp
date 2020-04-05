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
                __('Delete'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Blacks'), ['controller' => 'Blacks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Black'), ['controller' => 'Blacks', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
            echo $this->Form->control('username');
            echo $this->Form->control('password');
            echo $this->Form->control('handlename');
            echo $this->Form->control('status');
            echo $this->Form->control('start_time');
            echo $this->Form->control('end_time');
            echo $this->Form->control('skype_account');
            echo $this->Form->control('twitter_account');
            echo $this->Form->control('twitter_handle_name');
            echo $this->Form->control('comment');
            echo $this->Form->control('keyword00',['type'=>'checkbox','label'=>'競技志向']);
            echo $this->Form->control('keyword01',['type'=>'checkbox','label'=>'ショップ大会']);
            echo $this->Form->control('keyword02',['type'=>'checkbox','label'=>'フリー対戦']);
            echo $this->Form->control('keyword03',['type'=>'checkbox','label'=>'調整']);
            echo $this->Form->control('keyword06',['type'=>'checkbox','label'=>'連戦']);
            echo $this->Form->control('keyword07',['type'=>'checkbox','label'=>'一本勝負']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
