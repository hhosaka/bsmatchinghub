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
                ['action' => 'deleteSelf'],
                ['confirm' => __('Are you sure you want to delete this account ?')]
            )
        ?></li>
        <li><?= $this->Html->link(__('Main Screen'), ['controller' => 'Eventers', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <?php
            echo $this->Form->control('username',['type'=>'email','label'=>'Mail Address']);
            echo $this->Form->control('password',['label'=>'Password']);
            echo $this->Form->control('twitter_account',['label'=>'Twitter ID']);
            echo $this->Form->control('twicas_url',['label'=>'Twicas URL(Option. Only for eventer)']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Save')) ?>
    <?= $this->Form->end() ?>
</div>
