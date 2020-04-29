<?php if($result):?>
        <div class="users form large-9 medium-8 columns content">
                <legend><?= __('対戦依頼を受けました。Skypeで'.$sender->handlename."さんを呼び出してください") ?></legend>
                <input type="button" value="Skype ID:<?php echo $sender->skype_account ?>をクリップボードにコピー" onclick='
                var ta = document.createElement("textarea");
                ta.value = "<?php echo $sender->skype_account; ?>";
                document.body.appendChild(ta);
                ta.select();
                document.execCommand("copy");
                ta.parentElement.removeChild(ta);'/>
        </div>
<?PHP else:?>
        <div class="users form large-9 medium-8 columns content">
                <legend><?= __($sender->handlename."さんは対戦可能状態ではありませんでした。") ?></legend>
        </div>
<?PHP endif?>
