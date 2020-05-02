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
                ['action' => 'deleteSelf'],
                ['confirm' => __('Are you sure you want to delete this account ?')]
            )
        ?></li>
        <li><?= $this->Html->link(__('フレンドリスト'), ['controller' => 'Friends', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('ブラックリスト'), ['controller' => 'Blacks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('メイン画面'), ['controller' => 'Users', 'action' => 'index']) ?></li>
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
            echo $this->Form->control('use_friends',[
                'label'=>'フレンド設定',
                'type'=>'select',
                'default'=>'NONE',
                'options'=>[
                    'NONE'=>'すべての情報を公開(NONE)',
                    'OPEN'=>'フレンドにだけ情報公開(OPEN)',
                    'CLOSE'=>'フレンドのみ(CLOSE)']
                ]);
            
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
    </fieldset>
    <?= $this->Form->button(__('保存')) ?>
    <?= $this->Form->end() ?>
    <!--
    <div class="related">
        <h4><?= __('Friends') ?></h4>
        <?php if (!empty($user->friends)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->friends as $friends): ?>
            <tr>
                <td><?= h($friends->user->handlename) ?></td>
                <td class="actions">
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Friends', 'action' => 'delete', $friends->id], ['confirm' => __('Are you sure you want to delete # {0}?', $friends->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    -->

</div>
