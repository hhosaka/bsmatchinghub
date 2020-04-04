<div class="members form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend>
        お客様情報登録フォーム
        </legend>
        <?php
            echo $this->Form->control('family_name',['label'=>'姓']);
            echo $this->Form->control('first_name',['label'=>'名']);
            echo $this->Form->control('family_name_kana',['label'=>'セイ']);
            echo $this->Form->control('first_name_kana',['label'=>'メイ']);
            echo $this->Form->control('phone_number1',['label'=>'電話番号　"-"等付けずに数字だけ入力してください']);
            echo $this->Form->control('phone_number2',['label'=>'電話番号(予備)']);
            echo $this->Form->control('sex',['type'=>'select','label'=>'性別','options'=>['male'=>'男性','female'=>'女性']]);
            echo $this->Form->control('birthday',[
                'label'=>'生年月日',
                'type' => 'date',
                'dateFormat' => 'YMD',
                'monthNames' => false,
                'minYear'=>'1900',
                'separator' => array('年', '月', '日'),
                ]);
            echo $this->Form->control('zip_code',['label'=>'郵便番号　"-"等付けずに数字だけ入力してください']);
            echo $this->Form->control('prefecture',[
                'label'=>'都道府県',
                'type'=>'select',
                'default'=>'東京都',
                'options'=>[
                '東京都'=>'東京都','神奈川県'=>'神奈川県','北海道'=>'北海道','青森県'=>'青森県','岩手県'=>'岩手県',
                '宮城県'=>'宮城県','秋田県'=>'秋田県','山形県'=>'山形県','福島県'=>'福島県','茨城県'=>'茨城県',
                '栃木県'=>'栃木県','群馬県'=>'群馬県','埼玉県'=>'埼玉県','千葉県'=>'千葉県','新潟県'=>'新潟県',
                '富山県'=>'富山県','石川県'=>'石川県','福井県'=>'福井県','山梨県'=>'山梨県','長野県'=>'長野県',
                '岐阜県'=>'岐阜県','静岡県'=>'静岡県','愛知県'=>'愛知県','三重県'=>'三重県','滋賀県'=>'滋賀県',
                '京都府'=>'京都府','大阪府'=>'大阪府','兵庫県'=>'兵庫県','奈良県'=>'奈良県','和歌山県'=>'和歌山県',
                '鳥取県'=>'鳥取県','鳥取県'=>'鳥取県','岡山県'=>'岡山県','広島県'=>'広島県','山口県'=>'山口県',
                '徳島県'=>'徳島県','香川県'=>'香川県','愛媛県'=>'愛媛県','高知県'=>'高知県','福岡県'=>'福岡県',
                '佐賀県'=>'佐賀県','長崎県'=>'長崎県','熊本県'=>'熊本県','大分県'=>'大分県','宮崎県'=>'宮崎県',
                '鹿児島県'=>'鹿児島県','沖縄県'=>'沖縄県']]);
            echo $this->Form->control('address1',['label'=>'住所']);
            echo $this->Form->control('address2',['label'=>'住所(続き)']);
            echo $this->Form->control('email1',['label'=>'メールアドレス']);
            echo $this->Form->control('confirm_email',['label'=>'確認のためもう一度入力してください']);
    ?>
    </fieldset>
    <?= $this->Form->button(__('送信')) ?>
    <?= $this->Form->end() ?>
</div>
