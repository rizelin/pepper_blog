<?php
require("../require/header.php");
?>

<h2 class="title_h2">予約内容確認</h1>
<div class="main_body">
    <div class="inquiryConfirm_contents">
        <p>下記の内容で参加申込書を入力いただきました。
            <br>「申請する」ボタンを押すと申請完了になります。
            <br>※参加キャンセルは電話のみで可能です。
        </p>

        <dl>
            <dt>アトリエ名</dt>
            <dd><?= $schedule['title'] ?></dd>
        </dl>
        <dl>
            <dt>アトリエ時間</dt>
            <dd><?= $schedule['start_time']?> ~ <?= $schedule['end_time'] ?></dd>
        </dl>
        <dl>
            <dt>定　員</dt>
            <dd><?= $schedule['limit_count'] ?>人</dd>
        </dl>
        <dl>
            <dt>参加費</dt>
            <dd><?= $schedule['entry_fee'] ?></dd>
        </dl>
        <dl>
            <dt>開催地</dt>
            <dd><?= $schedule['address'] ?></dd>
        </dl>

        <form class="inquiry_confirm_form" action="./inquiryConfirm.php" method="post">
            <dl>
                <dt>御社名</dt>
                <dd><?= $inquiry['company'] ?></dd>
                <input type="hidden" name="confirm[company]" value="<?= $inquiry['company'] ?>">
            </dl>
            <dl>
                <dt>お名前</dt>
                <dd><?= $inquiry['name'] ?></dd>
                <input type="hidden" name="confirm[name]" value="<?= $inquiry['name'] ?>">
            </dl>
            <dl>
                <dt>メール</dt>
                <dd><?= $inquiry['email'] ?></dd>
                <input type="hidden" name="confirm[email]" value="<?= $inquiry['email'] ?>">
            </dl>
            <dl>
                <dt>お電話番号</dt>
                <dd><?= $inquiry['tel'] ?></dd>
                <input type="hidden" name="confirm[tel]" value="<?= $inquiry['tel'] ?>">
            </dl>
            <dl>
                <dt>ご住所</dt>
                <dd><?= $inquiry['zip_code'] ?><br><?= $inquiry['prefecture'] ?><?= $inquiry['address1'] ?><?= $inquiry['address2'] ?></dd>
                <input type="hidden" name="confirm[zip_code]" value="<?= $inquiry['zip_code'] ?>">
                <input type="hidden" name="confirm[prefecture]" value="<?= $inquiry['prefecture'] ?>">
                <input type="hidden" name="confirm[address1]" value="<?= $inquiry['address1'] ?>">
                <input type="hidden" name="confirm[address2]" value="<?= $inquiry['address2'] ?>">
            </dl>
            <dl>
                <dt>＊学年(年齢)</dt>
                <dd><?= $inquiry['age'] ?></dd>
                  <input type="hidden" name="confirm[age]" value="<?= $inquiry['age'] ?>" >
            </dl>
            <dl>
                <dt>参加希望人数</dt>
                <dd><?= $inquiry['reservation_count'] ?>人</dd>
                <input type="hidden" name="confirm[reservation_count]" value="<?= $inquiry['reservation_count'] ?>">
            </dl>
            <p class="page">
                <input type="submit" value="申請する">
                <input type="button" value="戻る" onclick="location='./inquiryWriting.php?id=<?=$schedule['id']?>'">
            </p>
        </form>
    </div>
</div>

<?php
require_once("../require/footer.php");
?>
