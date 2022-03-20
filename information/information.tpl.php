<?php
require_once("../require/header.php");
?>

<form class="search" action="../require/search.php" method="post">
  <input class="search_text" type="text" placeholder="search" name="search">
  <input class="search_button" type="submit" value="検索">
</form>


<section class="info_page">
    <h1 class="page_name">お知らせ</h1>
    <p class="sub_navi clearfix"><a href="../require/main.php">TOP</a> ≫ <a href="./informationBoard.php">お知らせ</a> ≫ 詳細</p>

    <dl class="info_list">
        <dt class="info_title"><?= $info['title'] ?></dt>
        <dd class="info_datetime clearfix"><?= $info['public_datetime'] ?></dd>
    </dl>
    <dl class="info_board">
        <?if ($info['img'] != "") {?>
            <dd class="info_board_img"><img class="info_img" src="/common/media/information/<?= $info['img'] ?>"></dd>
        <?}?>
        <dd class="info_text"><?= $info['text'] ?></dd>
    </dl>
    <p class="page">
        <input type="button" class="back_btn bnt_color" onclick="location.href='./informationBoard.php'" value="戻る">
    </p>
</section>

<?php
require_once("../require/footer.php");
?>
