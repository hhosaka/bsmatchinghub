<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Black $black
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $black->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $black->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Blacks'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="blacks form large-9 medium-8 columns content">
    <?= $this->Form->create($black) ?>
    <fieldset>
        <legend><?= __('Edit Black') ?></legend>
        <?php
            echo $this->Form->control('owner_id');
            echo $this->Form->control('user_id', ['options' => $users]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
