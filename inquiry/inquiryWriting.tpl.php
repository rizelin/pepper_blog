<?php
require_once("../require/header.php");

?>

<form class="search" action="../require/search.php" method="post">
  <input class="search_text" type="text" placeholder="search" name="search">
  <input class="search_button" type="submit" value="検索">
</form>

<h2 class="title_h2">申し込み</h1>
<section class="info_page">
  <p class="sub_navi clearfix"><a href="../require/main.php">TOP</a> ≫ 申し込み</p>
</section><br>
<div class="main_body">
    <div class="inquiry_form">
        <dl>
            <dt>登録日付</dt>
            <dd><span><?= substr($schedule['registration_datetime'],0,10) ?></span></dd>
        </dl>
        <dl>
            <dt>アトリエ名</dt>
            <dd><?= $schedule['title'] ?></dd>
        </dl>
        <dl>
            <dt>アトリエ時間</dt>
            <dd><?= $schedule['start_time']?> ~ <?= $schedule['end_time'] ?></dd>
        </dl>
        <dl>
            <dt>定  員</dt>
            <dd><?= $reservationCount ?>/<?= $schedule['limit_count'] ?>人</dd>
        </dl>
        <dl>
            <dt>参加費</dt>
            <dd><?= $schedule['entry_fee'] ?></dd>
        </dl>
        <dl>
            <dt>開催地</dt>
            <dd><?= $schedule['address'] ?></dd>
        </dl>
    </div>

    <form class="inquiry_form"  method="post">
        <dl>
            <dt>御社名</dt>
            <dd><input type="text" name="inquiry[company]" value="<?= @$inquiry['company'] ?>"></dd>
            <?= isset($errorMsgs['company'])? "<p class='fail_text'>{$errorMsgs['company']}</p>": ''?>
        </dl>
        <dl>
            <dt>＊お名前</dt>
            <dd><input type="text" name="inquiry[name]" value="<?= @$inquiry['name'] ?>" placeholder="必須"></dd>
            <?= isset($errorMsgs['name'])? "<p class='fail_text'>{$errorMsgs['name']}</p>": ''?>
        </dl>
        <dl>
            <dt>＊メール</dt>
            <dd><input type="email" name="inquiry[email]" value="<?= @$inquiry['email'] ?>" placeholder="必須"></dd>
            <?= isset($errorMsgs['email'])? "<p class='fail_text'>{$errorMsgs['email']}</p>": ''?>
        </dl>
        <dl>
            <dt>＊メール確認</dt>
            <dd><input type="email" name="inquiry[email2]" value="<?= @$inquiry['email2'] ?>" placeholder="必須"></dd>
            <?= isset($errorMsgs['email2'])? "<p class='fail_text'>{$errorMsgs['email2']}</p>": ''?>
            <?= isset($errorMsgs['emailConfirm'])? "<p class='fail_text'>{$errorMsgs['emailConfirm']}</p>": ''?>
        </dl>
        <dl>
            <dt>＊お電話番号</dt>
            <dd><input type="text" name="inquiry[tel]" value="<?= @$inquiry['tel'] ?>" placeholder="必須"></dd>
            <?= isset($errorMsgs['tel'])? "<p class='fail_text'>{$errorMsgs['tel']}</p>": ''?>
        </dl>
        <dl>
            <dt>＊ご住所</dt>
            <dl>
                <dt>郵便番号<span>※7桁の半角数字で入力してください</span></dt>
                <dd>
                    <input type="text" id="zipcode" name="inquiry[zip_code]" value="<?= @$inquiry['zip_code'] ?>" placeholder="必須">
                    <input type="button" id="search_btn" value="検索">
                </dd>
                <?= isset($errorMsgs['zip_code'])? "<p class='fail_text'>{$errorMsgs['zip_code']}</p>": ''?>
                <dt>都道府県</dt>
                <dd>
                  <select name="inquiry[prefecture]">
                      <option value="">-------</option>
                      <?foreach ($prefectures as $key => $value){?>
                          <option id="prefectures<?=$key?>" value="<?=$key?>" <?=$inquiry['prefecture']==$value? "selected":""?>><?= $value ?></option>
                      <?}?>
                  </select>
                  <?= isset($errorMsgs['prefecture'])? "<p class='fail_text'>{$errorMsgs['prefecture']}</p>": ''?>
                </dd>
                <dt>市・区・群・町</dt>
                <dd><input type="text" id="address1" name="inquiry[address1]" value="<?= @$inquiry['address1'] ?>" placeholder="必須"></dd>
                <?= isset($errorMsgs['address1'])? "<p class='fail_text'>{$errorMsgs['address1']}</p>": ''?>

                <dt>番地・建物名等</dt>
                <dd><input type="text" name="inquiry[address2]" value="<?= @$inquiry['address2'] ?>"></dd>
                <?= isset($errorMsgs['address2'])? "<p class='fail_text'>{$errorMsgs['address2']}</p>": ''?>

            </dl>
        </dl>
        <dl>
            <dt>＊学年(年齢)</dt>
            <dd><input type="text" name="inquiry[age]" value="<?= @$inquiry['age'] ?>" placeholder="必須"></dd>
            <?= isset($errorMsgs['age'])? "<p class='fail_text'>{$errorMsgs['age']}</p>": ''?>
        </dl>
        <dl>
            <dt>＊参加希望人数</dt>
            <dd>
              <input id="inquiry_writing_count" type="text" name="inquiry[reservation_count]" value="<?= @$inquiry['reservation_count'] ?>" placeholder="必須">人
              <br><span>※あと<?= $schedule['limit_count']-$reservationCount?>人受付可能</span>
            </dd>
            <?= isset($errorMsgs['reservation_count'])? "<p class='fail_text'>{$errorMsgs['reservation_count']}</p>": ''?>
        </dl>
        <p class="page">
            <input type="button" onclick="location.href='../schedule/scheduleBoard.php'" value="戻る">
            <input type="submit" value="登録">
        </p>
    </form>

</div>
<?php
require_once("../require/footer.php");
?>
