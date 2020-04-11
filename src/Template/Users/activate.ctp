<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('募集開始') ?></legend>
        <?php
            echo $this->Form->control('start_time',['label'=>'募集開始時間','value'=>date("Y/m/d H:i:s")]);
            echo $this->Form->control('end_time',['label'=>'終了予定時間','value'=>date("Y/m/d H:i:s",strtotime('+60 minute'))]);
            echo $this->Form->control('comment',['label'=>'コメント']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('送信')) ?>
    <?= $this->Form->end() ?>
</div>
