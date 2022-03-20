<?php
ini_set('display_errors',1);
require_once("./header.php");
?>
<form class="search" action="../require/search.php" method="post">
  <input class="search_text" type="text" placeholder="お知らせ、Blog検索" name="search">
  <input class="search_button" type="submit" value="検索">
</form>

<div class="main_body">
    <div class="main_contents">
        <h3>スケジュール</h2>
        <?for ($i=0; $i < $scheduleCnt; $i++) {?>
          <div>
                <p class="main_date"><?=$schedule[$i]['start_time']." ~ ".$schedule[$i]['end_time']?></p>
                <p class="title_link"><a href="../schedule/schedule.php?id=<?=$schedule[$i]['id']?>"><?=$schedule[$i]['title']?></a></p>
                <p><?=$schedule[$i]['address']?></p>
            </div>
        <?}?>
    </div>

    <div class="main_contents">
        <h3>お知らせ</h2>
          <?for ($i=0; $i < $informationCnt; $i++) {?>
            <div>
                <p class="main_date"><?=$information[$i]['public_datetime']?></p>
                <p class="title_link"><a href="../information/information.php?id=<?=$information[$i]['id']?>"><?=$information[$i]['title']?></a></p>
            </div>
          <?}?>
    </div>
</div>

<?php
require_once("./footer.php");
?>
