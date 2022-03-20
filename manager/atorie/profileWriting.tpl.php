

<?php
  require_once("../require/header.php");
?>
<?if(isset($_GET['fixed_id'])){?>
    <h2 class="title_h2">アトリエ紹介修正</h1>
<?}else{?>
    <h2 class="title_h2">アトリエ紹介作成</h1>
<?}?>
<section class="profile_page">
    <?if(isset($_GET['fixed_id'])){?>
        <p class="sub_navi clearfix"><a href="../require/main.php">TOP</a> ≫ アトリエ紹介修正</p>
    <?}else{?>
        <p class="sub_navi clearfix"><a href="../require/main.php">TOP</a> ≫ アトリエ紹介作成</p>
    <?}?>
</section><br>

<div class="main_body">
  <form class="write_contents" action="./profileWriting.php" method="post" enctype="multipart/form-data">
      <?if (isset($profile['id'])) {?>
          <input type="hidden" name="profile[id]" value="<?=$profile['id']?>">
      <?}?>
      <dl>
          <dt>タイトル</dt>
          <dd class="schedule_text"><input type="text" name="profile[title]" value="<?= @$profile['title'] ?>"></dd>
          <?= isset($errorMsgs['title'])? "<span>{$errorMsgs['title']}</span>": ''?>
      </dl>
      <dl class="big_contents">
          <dt>主な開催内容</dt>
          <dd><textarea name="profile[text]"><?= @$profile['text'] ?></textarea></dd>
          <?= isset($errorMsgs['text'])? "<span>{$errorMsgs['text']}</span>": ''?>
      </dl>
      <dl id="addedFormDiv">
          <dt>
              <input type="hidden" id="subTxtCnt" value="<?=$subTxtCnt?>">
              <input type="button" onclick="addForm();" value="追加" />
              <input type="button" onclick="delForm();" value="削除" />
          </dt>
          <?foreach ($dt as $key => $value) {?>
              <dl id="added_<?=$key?>">
                      <dt>
                          <span>タイトル<?=$key?></span>
                          <input type="text" name="dt[<?=$key?>]" value="<?=$value?>">
                      </dt>
                      <dd>
                          <span>内容<?=$key?></span>
                          <textarea name="dd[<?=$key?>]"><?=$dd[$key]?></textarea>
                      </dd>
              </dl>
          <?}?>
      </dl> <!-- 폼을 삽입할 DIV -->
      <dl>
          <dt>ファイル</dt>
          <dd class="write_img">
              <input type="file" name="img">
              <?if (!empty($profile['img'])) {?>
                    <input type="hidden" name="profile[img]" value="<?=$profile['img']?>">
                    <label for="file_delete">ファイル削除</label>
                    <input type="checkbox" id="file_delete" name="file_delete" value="1">
                    <img id="preview" src="../../common/media/profile/<?=$profile['img']?>">
              <?}?>
          </dd>
          <?= isset($errorMsgs['img'])? "<span>{$errorMsgs['img']}</span>": ''?>
      </dl>

      <?if(isset($_GET['fixed_id'])) {?>
          <dl>
              <dt>作成日付</dt>
              <dd><?= $profile['registration_datetime'] ?></dd>
          </dl>
          <dl>
              <dt>修正日付</dt>
              <dd><?= $profile['update_datetime']?></dd>
          </dl>
      <?}?>
      <?if (isset($_GET['fixed_id'])) {?>
        <p><input type="checkbox" id="delete" name="profile[status]" value="1"><label for="delete">この記事を削除する</label></p>
      <?}?>
      <p class="page">
          <input type="button" onclick="location.href='atorie.php'" value="戻る">
          <input type="submit" value="登録">
      </p>
  </form>
</div>
<?php
  require_once("../require/footer.php");
?>
