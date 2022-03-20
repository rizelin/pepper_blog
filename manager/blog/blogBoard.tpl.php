<?php
require_once("../require/header.php");
?>


<h2 class="title_h2">Blog</h1>
<section class="blog_page">
  <p class="sub_navi clearfix"><a href="../require/main.php">HOME</a> ≫ Blog</p>
<div class="checkin_contents">
  <table class="check_board_table">
    <tr>
        <th></th>
        <th>登録日付</th>
        <th>タイトル</th>
        <th>公開・終了日付</th>
        <th></th>
    </tr>
    <?for ($i=0; $i < $count; $i++) {?>
      <tr class="checkin_tr">
          <?if (!empty($blogList[$i]['img'])){?>
              <td><img  class="blog_list_img" src="/common/media/blog/<?=$blogList[$i]['img']?>"></td>
          <?}else {?>
              <td><img class="blog_list_img" src="/common/img/noImage.png"></td>
          <?}?>
          <td>
              <p class="blog_registration_datetime"><abbr title="<?=$blogList[$i]['registration_datetime']?>"><?= substr(str_replace("-", "/", $blogList[$i]['registration_datetime']),0,10) ?></abbr></p>
              <?= ($blogList[$i]['status'] == 1)? "公開":"非公開" ?>
          </td>
          <td class="board_title title_link">
              <a href="./blogWriting.php?id=<?=$blogList[$i]['id']?>"><?= $blogList[$i]['title'] ?></a>
          </td>
          <td>
            <abbr class="public_datetime" title="<?=$blogList[$i]['public_datetime']?>">公開 <?= substr(str_replace("-", "/", $blogList[$i]['public_datetime']),0,10) ?></abbr><br>
            <abbr class="limit_datetime" title="<?=$blogList[$i]['limit_datetime']?>">終了
              <?if (!empty($blogList[$i]['limit_datetime'])) {?>
                  <?= substr(str_replace("-", "/", $blogList[$i]['limit_datetime']),0,10) ?></abbr>
              <?}else {?>
                  無期限</abbr>
              <?}?>
          </td>
          <td>
              <p class="page">
                  <input type="button" onclick="location.href='./blogWriting.php?id=<?=$blogList[$i]['id']?>'" value="修正">
              </p>
          </td>
      </tr>
    <?}?>
  </table>
</div>

    <p class="page"><input type="button" value="作成" onclick="location='./blogWriting.php'"></p>

</section>

<p class="page_num">
  <?if ($page != 1) {?>
      <a class="pre_page" href="./blogBoard.php?page=1"><<</a>
  <?}
  for ($i=($page-5)<1? 1:($page-5); $i<($page+5) ; $i++) {
      if ($i < $page) {?>
          <a class="pages" href="./blogBoard.php?page=<?=$i?>"><?= $i ?></a>
      <?}elseif ($i == $page) {?>
          <span class="current_pages"><?= $i ?></span>
      <?}elseif ($i <= $maxPage) {?>
          <a class="pages" href="./blogBoard.php?page=<?=$i?>"><?= $i ?></a>
      <?}
  }
  if ($page != $maxPage) {?>
      <a class="next_page" href="./blogBoard.php?page=<?=$maxPage?>">>></a>
  <?}?>
</p>
<?php
  require_once("../require/footer.php");
?>
