<?php
// ini_set('display_errors',1);

?>
<html>
<head>
    <meta charest="utf-8">
    <!--twitter preview card-->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="https://eunhye.wj.am/blog/blog.php?id=<?=$_GET['id']?>">
    <meta name="twitter:title" content="<?= $blog['title'] ?>">
    <meta name="twitter:description" content="<?= $blog['text'] ?>">
    <meta name="twitter:image" content="http://eunhye.wj.am/common/media/blog/<?=$_GET['img']?>">
    <!-- 모바일과 PC크기를 1:1비율로 보여주는 태그 반드시 먼저 설정할 것! -->
    <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1,maximum-scale=1">
    <!-- 숫자로 인한 자동 생성되는 링크 제거 -->
    <meta name="format-detection" content="telephone=no">

    <title>Pepper アトリエサテライト甲府</title>
    <link rel="stylesheet" href="../common/css/reset.css">
    <link rel="stylesheet" href="../common/css/style.css">
    <link rel="stylesheet" href="../common/css/css.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://map.yahooapis.jp/js/V1/jsapi?appid=dj00aiZpPTYwT2JBdFhndWg1aSZzPWNvbnN1bWVyc2VjcmV0Jng9ZDA-"></script>
    <script src="../common/js/jquery-1.11.3.js"></script>
    <script src="../common/js/script.js"></script>
</head>
<body>

    <div class="pepper_header">
        <a href="../require/main.php"><h1 class="pepper_title">Pepper アトリエサテライト甲府</h1></a>
        <?if ($main == 1) {?>
          <dl class="navi_bar">
            <a href="../atorie/atorie.php"><div id="header_menu_mainMenuBtn1"></div><br><span class="main_menu_text">紹介</span></a>
            <a href="../information/informationBoard.php"><div id="header_menu_mainMenuBtn2"></div><br><span class="main_menu_text">お知らせ</span></a>
            <a href="../blog/blogBoard.php"><div id="header_menu_mainMenuBtn3"></div><br><span class="main_menu_text">Blog</span></a>
            <a href="../schedule/scheduleBoard.php"><div id="header_menu_mainMenuBtn4"></div><br><span class="main_menu_text">スケジュール</span></a>
        </dl>
        <?}else{?>
          <dl class="navi_bar2">
              <dt><img src="../common/img/menuBtn1.png" alt="home"><a href="../atorie/atorie.php">紹介</a></dt>
              <dt><img src="../common/img/menuBtn2.png" alt="information"><a href="../information/informationBoard.php">お知らせ</a></dt>
              <dt><img src="../common/img/menuBtn3.png" alt="blog"><a href="../blog/blogBoard.php">Blog</a></dt>
              <dt><img src="../common/img/menuBtn4.png" alt="schedule"><a href="../schedule/scheduleBoard.php">スケジュール</a></dt>
          </dl>
        <?} ?>
    </div>
