<?php
  require_once("../require/header.php");
?>

<h2 class="title_h2">お知らせ</h1>
<section class="info_page">
<p class="sub_navi clearfix"><a href="../require/main.php">HOME</a> ≫ お知らせ</p>

<div class="checkin_contents">
  <table class="check_board_table">
        <tr>
            <th class="information_th1">登録日付</th>
            <th class="information_th2">タイトル</th>
            <th class="information_th4">公開・終了日付</th>
            <th class="information_th3"></th>
        </tr>
    <?for ($i=0; $i < $count; $i++) {?>
      <tr class="checkin_tr">
          <td class="information_th1">
              <abbr title="<?=$infoList[$i]['registration_datetime']?>"><?= substr(str_replace("-", "/", $infoList[$i]['registration_datetime']),0,10) ?></abbr>
              <br><?= ($infoList[$i]['status'] == 1)? "公開":"非公開" ?>
          </td>
          <td class="board_title title_link">
              <a href="./informationWriting.php?id=<?=$infoList[$i]['id']?>"><?= $infoList[$i]['title'] ?></a>
          </td>
          <td class="information_th2">
            <abbr class="public_datetime" title="<?=$infoList[$i]['public_datetime']?>">公開 <?= substr(str_replace("-", "/", $infoList[$i]['public_datetime']),0,10)?></abbr><br>
            <abbr class="limit_datetime" title="<?=$infoList[$i]['limit_datetime']?>">終了 <?= substr(str_replace("-", "/", $infoList[$i]['limit_datetime']),0,10) ?></abbr>
          </td>
          <td>
              <p class="page">
                  <input type="button" onclick="location.href='./informationWriting.php?id=<?=$infoList[$i]['id']?>'" value="修正">
              </p>
          </td>
      </tr>
    <?}?>
  </table>
</div>

  <p class="page">
      <input type="button" value="作成" onclick="location='./informationWriting.php'">
  </p>

</section>

<p class="page_num">
  <?if ($page != 1) {?>
      <a class="pre_page" href="./informationBoard.php?page=1"><<</a>
  <?}
  for ($i=($page-5)<1? 1:($page-5); $i<($page+5) ; $i++) {
      if ($i < $page) {?>
          <a class="pages" href="./informationBoard.php?page=<?=$i?>"><?= $i ?></a>
      <?}elseif ($i == $page) {?>
          <span class="current_pages"><?= $i ?></span>
      <?}elseif ($i <= $maxPage) {?>
          <a class="pages" href="./informationBoard.php?page=<?=$i?>"><?= $i ?></a>
      <?}
  }
  if ($page != $maxPage) {?>
      <a class="next_page" href="./informationBoard.php?page=<?=$maxPage?>">>></a>
  <?}?>
</p>
<?php
  require_once("../require/footer.php");
?>
