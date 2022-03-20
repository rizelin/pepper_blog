<?php
require_once("../require/header.php");
?>

<form class="search" action="../require/search.php" method="post">
  <input class="search_text" type="text" placeholder="お知らせ、Blog検索" name="search">
  <input class="search_button" type="submit" value="検索">
</form>

<section class="info_page">
  <p class="sub_navi"><a href="../require/main.php">TOP</a> ≫ 紹介</p>
</section>
<div class="main_body">
    <div class="atorie_contents">
        <h3 class="title_h3">アトリエサテライト甲府紹介</h3>
        <dl class="atorie_contents_text">
        <?if (!empty($profile['img'])) {?>
          <img class="atorie_contents_img" src="../common/media/profile/<?=$profile['img']?>" alt="アトリエ写真">
        <?}?>
        <?= $profile['text'] ?>
    </div>

    <div class="atorie_contents_map">
        <h3 class="title_h3">交通アクセス</h3>
        <div id="map" class="atorie_map"></div>
        <p>
            山梨県甲府市中小河原町571
            <br>TEL.055-241-0022
        </p>
    </div>

</div>

<?php
require_once("../require/footer.php");
?>
