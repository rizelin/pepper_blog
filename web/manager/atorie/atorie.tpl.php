<?php
require_once("../require/header.php");
?>

<section class="info_page">
  <p class="sub_navi"><a href="../require/main.php">TOP</a> ≫ アトリエサテライト</p>
</section><br>

<div class="main_body">
    <div class="atorie_contents">
      <?if (isset($notice)) {?>
        <p><?=$notice?></p>
      <?}?>
        <dl class="atorie_bottom">
            <?= isset($confirmMsg)? "<p id='notice_message'>$confirmMsg</p>":'';?>
            <form class="select" action="./atorie.php" method="get">
              <select class="profile_select" name="profile_id">
                  <option selected value="">紹介リスト<option>
                  <?for($i=0 ; $i < $count; $i++){?>
                      <option value="<?=$profiles[$i]['id']?>"<?=($profiles[$i]['id']==$fixed['id'])? "selected" :''?>><?=$profiles[$i]['title']?></option>
                  <?}?>
              </select>
              <input type="submit" name="" value="検索">
            </form>

            <form class="select" action="./atorie.php" method="post">
                  <input type="hidden" name="fix_id" value="<?=$_GET['profile_id']?>">
                  <abbr title="まず検索ボタンを押してから押してください。"><input type="submit" name="" value="固定"></abbr>
            </form>

            <input type="button" class="" onclick="location='./profileWriting.php?fixed_id=<?=$fixed['id']?>'" value="修正">
            <input type="button" class="" onclick="location='./profileWriting.php'" value="新規作成">
        </dl>

        <dl class="atorie_contents_text">
          <h3 class="title_h3">アトリエサテライト紹介</h3>
            <?if (!empty($fixed['img'])) {?>
              <img class="atorie_contents_img" src="../../common/media/profile/<?=$fixed['img']?>" alt="アトリエ写真">
            <?}?>
            <?= $fixed['text'] ?>
            <dd>
                <a href="http://pepper-atelier-akihabara.jp/archives/439" title="ワークショップで使用した資料がご覧いただけます。" target="_blank">ワークショップ資料</a>
                <a id="facebook_link" href="https://www.facebook.com/groups/201404886887345/" title="Pepper アトリエサテライト甲府のFackbookに移動します。" target="_blank">Fackbook</a>
            </dd>
        </dl>
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
