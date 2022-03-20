<?php
require_once("../require/header.php");
?>

<form class="search" action="../require/search.php" method="post">
  <input class="search_text" type="text" placeholder="お知らせ、Blog検索" name="search">
  <input class="search_button" type="submit" value="検索">
</form>

<h2 class="title_h2">Blog</h1>
<section class="blog_page">
  <p class="sub_navi clearfix"><a href="../require/main.php">HOME</a> ≫ Blog</p>
  <div class="board_contents">
    <table class="blog_board_table">
        <?for ($i=0; $i < $count; $i++) {?>
            <tr>
                <td>
                    <?if (!empty($blogList[$i]['img'])){?>
                        <img class="blog_list_img" src="/common/media/blog/<?=$blogList[$i]['img']?>">
                    <?}else {?>
                        <img class="blog_list_img" src="/common/img/noImage.png">
                    <?}?>
                </td>
                <td>
                    <span class="list_datetime"><?= $blogList[$i]['public_datetime'] ?></span>
                </td>
                <td class="title_link">
                    <a href="./blog.php?id=<?=$blogList[$i]['id']?>"><?= $blogList[$i]['title'] ?></a>
                    <p class="blog_textarea"><?= $blogList[$i]['text'] ?></p>
                </td>
                <td>
                    <p class="page">
                        <input type="button" onclick="location.href='./blog.php?id=<?=$blogList[$i]['id']?>'" value="詳細">
                    </p>
                </td>
            </tr>
        <?}?>
    </table>
</div>
<!--<div class="board_contents">
    <article class="blog_board_table">
        <?for ($i=0; $i < $count; $i++) {?>
            <ul>
                <li>
                    <?if (!empty($blogList[$i]['img'])){?>
                        <img class="blog_list_img" src="/common/media/blog/<?=$blogList[$i]['img']?>">
                    <?}else {?>
                        <img class="blog_list_img" src="/common/img/noImage.jpg">
                    <?}?>
                </li>
                <li>
                    <span class="list_datetime"><?= $blogList[$i]['public_datetime'] ?></span>
                </li>
                <li class="title_link">
                    <a href="./blog.php?id=<?=$blogList[$i]['id']?>"><?= $blogList[$i]['title'] ?></a>
                    <p class="blog_textarea"><?= $blogList[$i]['text'] ?></p>
                </li>
                <li>
                    <p class="page">
                        <input type="button" onclick="location.href='./blog.php?id=<?=$blogList[$i]['id']?>'" value="詳細">
                    </p>
                </li>
            </ul>
        <?}?>
    </article>-->
</div>


</section>

<article class="page_num">
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
  </article>

<?php
require_once("../require/footer.php");
?>
