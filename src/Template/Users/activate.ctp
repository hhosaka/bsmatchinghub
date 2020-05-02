<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users form">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('募集開始') ?></legend>
        <?php
            echo $this->Form->control('start_time',['label'=>'募集開始時間','value'=>$user->start_time]);
            echo $this->Form->control('time',[
                'label'=>'募集時間',
                'type'=>'select',
                'default'=>'+60 minute',
                'options'=>[
                    '+30 minute'=>'30分',
                    '+60 minute'=>'1時間',
                    '+90 minute'=>'1時間30分',
                    '+120 minute'=>'2時間',
                    '+150 minute'=>'2時間30分',
                    '+180 minute'=>'3時間'
                ]]);
            echo $this->Form->control('comment',['label'=>'コメント']);
        ?>
        <?= $this->Form->control('others', ['label'=>'キーワード("|"で複数条件を指定できます。)','value'=>$data['others']]);?>
        <div style="display:inline-flex">
        <?php $i=0; foreach ($keywords as $keyword):?>
            <?=$this->Form->control('keyword'.$i, ['type'=>'checkbox','label'=>$keyword,'checked'=>$data['keyword'.$i]]); $i=$i+1 ?>
            <?php if($i%4==3):?>
                </div><br><div style="display:inline-flex">
            <?php endif?>
        <?php endforeach ?>
        </div>
        <?= $this->Form->control('close', ['type'=>'checkbox', 'label'=>'ツイッターに報告しない', 'checked'=>false]);?>
    </fieldset>
    <?= $this->Form->button(__('送信')) ?>
    <?= $this->Form->end() ?>
</div>
