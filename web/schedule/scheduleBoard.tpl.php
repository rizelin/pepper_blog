<?php
require_once("../require/header.php");
?>

<form class="search" action="../require/search.php" method="post">
  <input class="search_text" type="text" placeholder="お知らせ、Blog検索" name="search">
  <input class="search_button" type="submit" value="検索">
</form>

<h2 class="title_h2">スケジュール</h1>
<section class="info_page">
<p class="sub_navi clearfix"><a href="../require/main.php">TOP</a> ≫ スケジュール</p>
</section><br>
<div class="main_body">
    <div class="schedule_contents">
        <?for ($i=0; $i < $count; $i++) {?>
            <div>
                <dl>
                    <dt>
                        <?if(!empty($scheduleList[$i]['img'])){?>
                            <img src="../common/media/schedule/<?=$scheduleList[$i]['img'] ?>" alt="スケジュールイメージ"></dt>
                        <?}else{?>
                            <img src="../common/img/noImage.png" alt="スケジュールイメージ"></dt>
                        <?}?>
                    <dd class="schedule_text">
                        <p class="schedule_date"><?= $scheduleList[$i]['start_time']?> ~ <?= $scheduleList[$i]['end_time'] ?> </p>
                        <p class="title_link">テーマ：<a href="./schedule.php?id=<?= $scheduleList[$i]['id']?>"><?= $scheduleList[$i]['title'] ?></a></p>
                        <p>場  所：<?= $scheduleList[$i]['address'] ?></p>
                        <p>定  員：<?=$reservationCount[$i]?>/<?= $scheduleList[$i]['limit_count'] ?>人 <span>あと<?=$scheduleList[$i]['limit_count']-$reservationCount[$i]?>人受付可能</span></p>
                        <p>参加費：<?= $scheduleList[$i]['entry_fee'] ?></p>
                        <p class="page">
                            <input type="button" onclick="location.href='./schedule.php?id=<?= $scheduleList[$i]['id']?>'" value="詳細">
                            <?if($scheduleList[$i]['limit_count'] <= $reservationCount[$i]){?>
                                <input type="button" class="reservation_btn bnt_color" value="予約締切" disabled>
                            <?}else {?>
                                <input type="button" class="reservation_btn bnt_color" onclick="location='../inquiry/inquiryWriting.php?id=<?=$scheduleList[$i]['id']?>'" value="参加予約">
                            <?}?>
                        </p>
                    </dd>
                </dl>
            </div>
        <?}?>
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
