<?php
  require_once("./header.php");
?>

<form class="search" action="../require/search.php" method="post">
  <input class="search_text" type="text" placeholder="search" name="search">
  <input class="search_button" type="submit" value="検索">
</form>

<section id="search_page">
  <p class="sub_navi clearfix"><a href="../require/main.php">HOME</a> ≫ 検索結果</p>
  <?if (isset($search)){?>

    <article class="info_page">
      <h1 class="page_name">お知らせ</h1>
      <ul class="info_list">
          <li class="search_count"><?=$infoCnt?>件</li>
      <?if ($infoCnt > 0) {
          for ($i=0; $i < $infoCnt; $i++) {?>
            <li class="search_info_box">
                <span><?= $info[$i]['public_datetime'] ?></span>
                <a href="../information/information.php?id=<?=$info[$i]['id']?>"><?= $info[$i]['title'] ?></a>
            </li>
          <?}?>
      <?}else {?>
          <li>一致する記事がありません。</li>
      <?}?>
      </ul>
    </article>

    <article class="blog_page">
        <h1 class="page_name">blog</h1>
        <ul class="blog_list">
          <li class="search_count"><?=$blogCnt?>件</li>
        <?if ($blogCnt > 0) {?>
            <?for ($i=0; $i < $blogCnt; $i++) {?>
              <ul class="search_blog_box">
                <?if (!empty($blog[$i]['img'])){?>
                    <li><img class="search_blog_img" src="/common/media/blog/<?=$blog[$i]['img']?>" width="70px" height="70px"></li>
                <?}else {?>
                    <li><img class="search_blog_img" src="/common/img/noImage.jpg"></li>
                <?}?>
                    <li class="seach_blog_body">
                        <p class="list_datetime"><?= $blog[$i]['public_datetime'] ?></p>
                        <a href="../blog/blog.php?id=<?=$blog[$i]['id']?>"><?= $blog[$i]['title'] ?></a>
                    </li>
              </ul>
            <?}?>
        <?}else {?>
            <li>一致する記事がありません。</li>
        <?}?>
        </ul>
    </article>

    <?}else {?>
        <p class="search_error">検索内容を入れて検索してください。</p>
    <?}?>

</section>

<?php
  require_once("./footer.php");
?>
