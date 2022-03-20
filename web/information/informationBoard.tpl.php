<?php
require_once("../require/header.php");
?>

<form class="search" action="../require/search.php" method="post">
  <input class="search_text" type="text" placeholder="お知らせ、Blog検索" name="search">
  <input class="search_button" type="submit" value="検索">
</form>

<h2 class="title_h2">お知らせ</h1>
<section class="info_page">
    <p class="sub_navi clearfix"><a href="../require/main.php">TOP</a> ≫ お知らせ</p>
    <div class="board_contents">
        <table class="blog_board_table">
            <?for($i=0; $i < $count; $i++) {?>
                <tr>
                    <td><span　class="list_datetime"><?= $infoList[$i]['public_datetime'] ?></span></td>
                    <td class="title_link"><a href="./information.php?id=<?=$infoList[$i]['id']?>"><?= $infoList[$i]['title'] ?></a></td>
                    <td><p class="page"><input type="button" onclick="location.href='./information.php?id=<?=$infoList[$i]['id']?>'" value="詳細"></p></td>
                </tr>
            <?}?>
        </table>
    </div>
</section>

<article class="page_num">
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
</article>

<?php
require_once("../require/footer.php");
?>
