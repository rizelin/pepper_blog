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

    <!--style-->
    <link rel="stylesheet" type="text/css" href="../../common/css/slick.css">
    <link rel="stylesheet" href="../common/css/reset.css">
    <link rel="stylesheet" href="../common/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--JS$JQuery-->
    <script type="text/javascript" charset="utf-8" src="https://map.yahooapis.jp/js/V1/jsapi?appid=dj00aiZpPTYwT2JBdFhndWg1aSZzPWNvbnN1bWVyc2VjcmV0Jng9ZDA-"></script>
    <script src="../common/js/jquery-1.11.3.js"></script>
    <script src="../common/js/script.js"></script>
    <script src="../common/js/slick.min.js"></script>

    <title>Pepper アトリエサテライト甲府</title>
</head>
<body>

    <div class="pepper_header">
        <a href="../require/main.php"><h1 class="pepper_title">Pepper アトリエサテライト甲府</h1></a>
          <dl class="navi_bar2">
              <dt><img src="../common/img/menuBtn1.png" alt="home"><a href="../atorie/atorie.php">紹介</a></dt>
              <dt><img src="../common/img/menuBtn2.png" alt="information"><a href="../information/informationBoard.php">お知らせ</a></dt>
              <dt><img src="../common/img/menuBtn3.png" alt="blog"><a href="../blog/blogBoard.php">Blog</a></dt>
              <dt><img src="../common/img/menuBtn4.png" alt="schedule"><a href="../schedule/scheduleBoard.php">スケジュール</a></dt>
          </dl>
    </div>
