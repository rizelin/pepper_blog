<?php
require_once("../require/header.php");
?>

<form class="search" action="../require/search.php" method="post">
  <input class="search_text" type="text" placeholder="お知らせ、Blog検索" name="search">
  <input class="search_button" type="submit" value="検索">
</form>

<h2 class="title_h2">スケジュール詳細</h1>
<section class="info_page">
<p class="sub_navi clearfix"><a href="../require/main.php">TOP</a> ≫ <a href="./scheduleBoard.php">スケジュール</a> ≫ 詳細</p>
</section><br>
<div class="main_body">
    <div class="schedule_contents">
        <div class="schedule">
            <div class="schedule_img">
                <?if ($schedule['img'] != "") {?>
                    <img src="/common/media/schedule/<?=$schedule['img']?>" alt=""></dt>
                <?}else {?>
                    <img src="/common/img/noImage.png" alt="">
                <?}?>
            </div>
            <p class="schedule_date"><?= $schedule['start_time']?> ~ <?= $schedule['end_time']?> </p>
            <p id="schedule_title"><?= $schedule['title']?></a></p>
            <p><?= $schedule['address'] ?></p>
            <p><?=$reservationCount?>/<?= $schedule['limit_count'] ?>人 <span>参加費 <?= $schedule['entry_fee'] ?></sapn></p>
            <p><?= $schedule['text'] ?></p>
        </div>
        <p class="page">
            <?if($schedule['limit_count'] <= $reservationCount){?>
                  <span>申し込み受付は終了しました。</span>
                  <input type="button" class="reservation_btn bnt_color" value="予約締切" disabled>
            <?}else {?>
                  <input type="button" class="reservation_btn bnt_color" onclick="location='../inquiry/inquiryWriting.php?id=<?=$schedule['id']?>'" value="参加予約">
            <?}?>
            <input type="button" onclick="location.href='./scheduleBoard.php'" value="戻る">
        </p>
    </div>
</div>
<?php
require_once("../require/footer.php");
?>
