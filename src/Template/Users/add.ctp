<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Blacks'), ['controller' => 'Blacks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Black'), ['controller' => 'Blacks', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->control('username');
            echo $this->Form->control('password');
            echo $this->Form->control('role');
            echo $this->Form->control('status');
            echo $this->Form->control('start_time');
            echo $this->Form->control('end_time');
            echo $this->Form->control('list_mode');
            echo $this->Form->control('skype_account');
            echo $this->Form->control('twitter_account');
            echo $this->Form->control('twitter_handle_name');
            echo $this->Form->control('comment');
            echo $this->Form->control('keyword00');
            echo $this->Form->control('keyword01');
            echo $this->Form->control('keyword02');
            echo $this->Form->control('keyword03');
            echo $this->Form->control('keyword04');
            echo $this->Form->control('keyword05');
            echo $this->Form->control('keyword06');
            echo $this->Form->control('keyword07');
            echo $this->Form->control('keyword08');
            echo $this->Form->control('keyword09');
            echo $this->Form->control('keyword10');
            echo $this->Form->control('keyword11');
            echo $this->Form->control('keyword12');
            echo $this->Form->control('keyword13');
            echo $this->Form->control('keyword14');
            echo $this->Form->control('keyword15');
            echo $this->Form->control('creation_date');
            echo $this->Form->control('modification_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
