<?php
  require_once("../require/header.php");
?>

<h2 class="title_h2">スケジュール</h1>
    <section class="info_page">
      <p class="sub_navi clearfix"><a href="../require/main.php">TOP</a> ≫ スケジュール</p>
    </section><br>
    <div class="main_body">
        <div class="schedule_contents">
            <?for ($i=0; $i < $count; $i++) {?>
                <div>
                    <p class="schedule_date"><?= $scheduleList[$i]['start_time']?> ~ <?= $scheduleList[$i]['end_time'] ?></p>
                    <p class="title_link"><a href="./scheduleWriting.php?id=<?=$scheduleList[$i]['id']?>"><?= $scheduleList[$i]['title'] ?></a></p>
                    <p><?= $scheduleList[$i]['address'] ?></p>
                    <p>定  員：<?=$reservationCount[$i]?>/<?= $scheduleList[$i]['limit_count'] ?>人 　あと<?=$scheduleList[$i]['limit_count']-$reservationCount[$i]?>人受付可能</p>
                    <p>参加費：<?= $scheduleList[$i]['entry_fee'] ?></p>
                    <p>公開状態：<?= $scheduleList[$i]['status']==1? "公開":"非公開" ?></p>
                    <p class="page">
                        <input type="button" onclick="location.href='./scheduleWriting.php?id=<?=$scheduleList[$i]['id']?>'" value="修正">
                        <input type="button" onclick="location='./checkInquiryBoard.php?schedule=<?=$scheduleList[$i]['id']?>'" value="参加予約確認">
                    </p>
                </div>

            <?}?>
            <p class="page">
                <input type="button" value="作成" onclick="location='./scheduleWriting.php'">
                <input type="button" onclick="location='./checkInquiryBoard.php'" value="参加予約確認">
            </p><br>
            <p class="page_num">
                <?if ($page != 1) {?>
                    <a class="pre_page" href="./scheduleBoard.php?page=1"><<</a>
                <?}
                for ($i=($page-5)<1? 1:($page-5); $i<($page+5) ; $i++) {
                    if ($i < $page) {?>
                        <a class="pages" href="./scheduleBoard.php?page=<?=$i?>"><?= $i ?></a>
                    <?}elseif ($i == $page) {?>
                        <span class="current_pages"><?= $i ?></span>
                    <?}elseif ($i <= $maxPage) {?>
                        <a class="pages" href="./scheduleBoard.php?page=<?=$i?>"><?= $i ?></a>
                    <?}
                }
                if ($page != $maxPage) {?>
                    <a class="next_page" href="./scheduleBoard.php?page=<?=$maxPage?>">>></a>
                <?}?>
            </p>
        </div>
    </div>
<?php
  require_once("../require/footer.php");
?>
