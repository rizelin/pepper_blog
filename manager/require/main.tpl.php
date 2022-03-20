<?php
  require_once("header.php");
?>
<!--img slider-->
<div class="slider">
    <div><img src="../../common/img/slider1.JPG" alt="image1"></div>
    <div><img src="../../common/img/slider2.JPG" alt="image2"></div>
    <div><img src="../../common/img/slider4.jpg" alt="image4"></div>
    <div><img src="../../common/img/slider5.jpg" alt="image5"></div>
    <div><img src="../../common/img/slider6.jpg" alt="image6"></div>
    <div><img src="../../common/img/slider7.jpg" alt="image7"></div>
</div>
<script>
//이미지 슬라이더
$('.slider').slick({
  dots: true,
  slidesToShow: 2,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 2000,
  responsive: [
   {
     breakpoint: 768,
     settings: {
       arrows: false,
       slidesToShow: 1
     }
   }
 ]
});
</script>

<div class="main_body">
    <div class="main_contents">
        <h3>スケジュール</h2>
          <?for ($i=0; $i < $scheduleCnt; $i++) {?>
            <div>
                <p class="main_date"><?=$schedule[$i]['start_time']." ~ ".$schedule[$i]['end_time']?></p>
                <p class="title_link"><a href="../schedule/scheduleWriting.php?id=<?=$schedule[$i]['id'] ?> "> <?=$schedule[$i]['title']?></a></p>
                <p><?=$schedule[$i]['address']?></p>
            </div>
          <?}?>

    </div>

    <div class="main_contents">
        <h2>お知らせ</h2>
          <?for ($i=0; $i < $informationCnt; $i++) {?>
              <div>
                  <p class="main_date"><?=$information[$i]['public_datetime']?></p>
                  <p class="title_link"><a href="../information/informationWriting.php?id=<?=$information[$i]['id']?>"><?=$information[$i]['title']?></a></p>
              </div>
          <?}?>
    </div>
</div>
<?php
  require_once("footer.php");
?>
