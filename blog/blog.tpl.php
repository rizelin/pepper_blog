<?php
require_once("../require/header.php");
?>
<form class="search" action="../require/search.php" method="post">
  <input class="search_text" type="text" placeholder="search" name="search">
  <input class="search_button" type="submit" value="検索">
</form>

<section class="blog_page">
  <h1 class="page_name">Blog</h1>
  <p class="sub_navi clearfix"><a href="../require/main.php">TOP</a> ≫ <a href="./blogBoard.php">Blog</a> ≫ 詳細</p>
    <dl class="blog_list">
      <input type="hidden" id="id" value="<?=$_GET['id']?>">
      <dt class="blog_title"><?= $blog['title'] ?></dt>
      <dd class="blog_datetime clearfix"><?= $blog['public_datetime'] ?></dd>
    </dl>
    <dl class="blog_board">
        <?if ($blog['img'][0] != "") {
          foreach ($blog['img'] as $key => $value) {?>
            <dd class="blog_board_img">
              <div class="blog_img" style="background-image:url('../common/media/blog/<?= $value ?>')"></div>
            </dd>
        <?}
        }?>
        <dd class="blog_text"><?= $blog['text'] ?></dd>
    </dl>
    <ul id="sns_share">
        <li><button id="facebook" onclick="facebook(<?=$_GET['id']?>)"><img class="sns_img" src="../common/img/facebook.png"></button></li>
        <li><button id="twitter" onclick="twitter(<?=$_GET['id']?>)"><img class="sns_img" src="../common/img/twitter.png"></button></li>
        <li><button id="line"  onclick="line(<?=$_GET['id']?>)"><img class="sns_img" src="../common/img/line.png"></button></li>
    </ul>
    <p class="page">
        <input type="button" class="back_btn bnt_color" onclick="location.href='./blogBoard.php'" value="戻る">
    </p>
</section>

<?php
require_once("../require/footer.php");
?>
