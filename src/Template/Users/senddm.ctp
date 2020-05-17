<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users form">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __($reciever['handlename'].'さんにダイレクトメッセージを送信します') ?></legend>
        <?= $this->Form->control('message',['label'=>'メッセージ']); ?>
    </fieldset>
    <?= $this->Form->button(__('送信')) ?>
    <?= $this->Form->end() ?>
</div>
