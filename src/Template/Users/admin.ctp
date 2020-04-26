<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Logout'), ['action' => 'logout']) ?></li>
    </ul>
</nav>
<div class="users index large-9 medium-8 columns content">
    <?='Target:'.$player->handlename?>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" width ="5%"><?= $this->Paginator->sort('id',['label'=>'ID']) ?></th>
                <th scope="col" width ="15%"><?= $this->Paginator->sort('handlename',['label'=>'Handle name']) ?></th>
                <th scope="col" width ="15%"><?= $this->Paginator->sort('twitter_account',['label'=>'Twitter ID']) ?></th>
                <th scope="col" width ="15%" class="skypeid"><?= __('Skype ID') ?></th>
                <th scope="col" width ="15%"><?= $this->Paginator->sort('end_time',['label'=>'end time']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('comment',['label'=>'Comment']) ?></th>
                <th scope="col" width ="15%" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $this->Number->format($user->id) ?></td>
                <td><?= h($user->handlename) ?></td>
                <td><?= h($user->twitter_account) ?></td>
                <td class="skypeid">
                <input type="button" value="<?php echo $user->skype_account ?>" onclick='
                        var ta = document.createElement("textarea");
	                    ta.value = "<?php echo $user->skype_account; ?>";
	                    document.body.appendChild(ta);
	                    ta.select();
	                    document.execCommand("copy");
	                    ta.parentElement.removeChild(ta);'/>
                </td>
                <td><?= h($user->end_time) ?></td>
                <td><?= h($user->comment) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('[Detail]'), ['action' => 'view', $user->id]) ?>
                    <?= $this->Html->link(__('[Target]'), ['action' => 'admin', $user->id]) ?>
                    <?= $this->Html->link(__('[offer]'), ['action' => 'offer', $player->id, $user->id]) ?>
                    <?= $this->Html->link(__('[deactivate]'), ['action' => 'forceDeactivate', $user->id]) ?>
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

    <Legend><?= __('Requery') ?></Legend>
    <hr>

    <?=$this->Form->create() ?>
    <fieldset>
    <?=$this->Form->control('others',['label'=>'Keyword','value'=>$data['others']]) ?>
    <div style="display:inline-flex">
    <?php $i=0; foreach ($conditions as $condition):?>
        <?=$this->Form->control('keyword'.$i ,['type'=>'checkbox','label'=>$condition,'checked'=>$data['keyword'.$i]]); $i=$i+1 ?>
        <?php if($i%4==3):?>
            </div><br><div style="display:inline-flex">
        <?php endif?>
    <?php endforeach ?>
    </div>
    <?=$this->Form->control('activeonly',['type'=>'checkbox','label'=>'Active Only','checked'=>$activeonly]) ?>
    </fieldset>
    <?=$this->Form->button("Send")?>
    <?=$this->Form->end()?>
</div>
