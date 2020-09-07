<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('対戦希望開始'), ['action' => 'activate']) ?></li>
        <li><?= $this->Html->link(__('対戦希望終了'), ['action' => 'deactivateSelf']) ?></li>
        <li><?= $this->Html->link(__('設定'), ['action' => 'settings']) ?></li>
        <li><?= $this->Html->link(__('ログアウト'), ['action' => 'logout']) ?></li>
    </ul>
</nav>
<div class="users index large-9 medium-8 columns content">
    <Legend>お知らせ</Legend>
    <hr>
    <pre>
    <?= $information ?>
    </pre>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" width ="5%"><?= $this->Paginator->sort('id',['label'=>'ID']) ?></th>
                <th scope="col" width ="15%"><?= $this->Paginator->sort('handlename',['label'=>'ハンドルネーム']) ?></th>
                <th scope="col" width ="10%"><?= h('ステータス') ?></th>
                <th scope="col" width ="15%"><?= $this->Paginator->sort('start_time',['label'=>'開始予定時間']) ?></th>
                <th scope="col" width ="15%"><?= $this->Paginator->sort('end_time',['label'=>'終了予定時間']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('comment',['label'=>'コメント']) ?></th>
                <th scope="col" width ="15%" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $this->Number->format($user->id) ?></td>
                <td><?= h($user->handlename) ?></td>
                <td><?= strtotime($user->start_time) > time()?'READY':'ACTIVE' ?></td>
                <td><?= h($user->start_time) ?></td>
                <td><?= h($user->end_time) ?></td>
                <td><?= h($user->comment) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('[詳細]'), ['action' => 'view', $user->id]) ?>
                    <?= $this->Html->link(__('[対戦リクエスト]'), 
                        ['action' => 'requestMatch', $user->id],
                        ['confirm' => __('Are you sure you want to send matching request to # {0}?', $user->handlename)]
                    ) ?>
                    <?= $this->Html->link(__('[DM]'), ['action' => 'senddm', $user->id]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>

    <Legend><?= __('検索条件') ?></Legend>
    <hr>

    <?=$this->Form->create() ?>
    <fieldset>
    <?=$this->Form->control('leadtime',[
                'label'=>'リードタイム',
                'type'=>'select',
                'value'=>$data['leadtime'],
                'options'=>[
                    'all'=>'ALL',
                    'now'=>'現在',
                    '+60 minute'=>'１時間後まで含める',
                    '+120 minute'=>'2時間後まで含める',
                    '+180 minute'=>'3時間後まで含める',
                    '+1 day'=>'一日後まで含める',]
                ]);?>
    <?=$this->Form->control('others',['label'=>'検索用キーワード("|"で複数条件を指定できます。)','value'=>$data['others']]) ?>
    <div style="display:inline-flex">
    <?php $i=0; foreach ($keywordlist as $keyword):?>
        <?=$this->Form->control('keyword'.$i ,['type'=>'checkbox','label'=>$keyword,'checked'=>$data['keyword'.$i]]); $i=$i+1 ?>
        <?php if($i%2==0):?>
            </div><br><div style="display:inline-flex">
        <?php endif?>
    <?php endforeach ?>
    </div>
    </fieldset>
    <?=$this->Form->button("再検索")?>
    <?=$this->Form->end()?>
    <legend>サービスを受けるために @BSMatchMaker をフォローしてください。</legend>
</div>
