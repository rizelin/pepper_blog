<?php
  require_once("../require/header.php");
?>
<?if(empty($id)){?>
    <h2 class="title_h2">お知らせ修正</h1>
<?}else{?>
    <h2 class="title_h2">お知らせ新規作成</h1>
<?}?>
<section class="info_page">
    <?if(empty($id)){?>
        <p class="sub_navi clearfix"><a href="../require/main.php">TOP</a> ≫ お知らせ修正</p>
    <?}else{?>
        <p class="sub_navi clearfix"><a href="../require/main.php">TOP</a> ≫ お知らせ新規作成</p>
    <?}?>
</section><br>
<div class="main_body">
  <form class="write_contents" action="./informationWriting.php" method="post" enctype="multipart/form-data">
      <?if (isset($info['id'])) {?>
          <input type="hidden" name="info[id]" value="<?=$info['id']?>">
      <?}?>
      <input type="hidden" name="info[category]" value="1">
      <dl>
          <dt>タイトル</dt>
          <dd class="schedule_text"><input type="text" name="info[title]" value="<?= @$info['title'] ?>"></dd>
          <?= isset($errorMsgs['title'])? "<span>{$errorMsgs['title']}</span>": ''?>
      </dl>
      <dl class="big_contents">
          <dt>本文</dt>
          <dd><textarea name="info[text]"><?= @$info['text'] ?></textarea></dd>
          <?= isset($errorMsgs['text'])? "<span>{$errorMsgs['text']}</span>": ''?>
      </dl>
      <dl class="big_contents">
          <dt>ファイル</dt>
          <dd class="write_img">
              <input type="file" name="img">
              <?if (!empty($info['img'])) {?>
                    <input type="hidden" name="info[img]" value="<?=$info['img']?>">
                    <label for="file_delete">ファイル削除</label>
                    <input type="checkbox" id="file_delete" name="file_delete" value="1">
                    <img id="preview" src="/common/media/information/<?=$info['img']?>">
              <?}?>
          </dd>
          <?= isset($errorMsgs['img'])? "<span>{$errorMsgs['img']}</span>": ''?>
      </dl>

      <?if(isset($_GET['id'])) {?>
          <dl>
              <dt>作成日付</dt>
              <dd><?= $info['registration_datetime'] ?></dd>
          </dl>
          <dl>
              <dt>修正日付</dt>
              <dd><?= $info['update_datetime']?></dd>
          </dl>
      <?}?>
      <dl>
          <dt>公開日付</dt>
          <dd>
              <input type="date" placeholder="yyyy-mm-dd" name="info[public_date]" value="<?= $info['public_date'] ?>">
              <input type="time" placeholder="hh:mm" name="info[public_time]" value="<?= $info['public_time'] ?>">
          </dd>
          <?= isset($errorMsgs['public_date'])? "<span>{$errorMsgs['public_date']}</span>": ''?>
          <?= isset($errorMsgs['public_time'])? "<span>{$errorMsgs['public_time']}</span>": ''?>
      </dl>
      <dl>
          <dt>公開終了</dt>
          <dd>
              <input type="date" placeholder="yyyy-mm-dd" name="info[limit_date]" value="<?= $info['limit_date'] ?>">
              <input type="time" placeholder="hh:mm" name="info[limit_time]" value="<?= $info['limit_time'] ?>">
          </dd>
          <?= isset($errorMsgs['limit_date'])? "<span>{$errorMsgs['limit_date']}</span>": ''?>
          <?= isset($errorMsgs['limit_time'])? "<span>{$errorMsgs['limit_time']}</span>": ''?>
      </dl>
      <dl>
          <dt>公開範囲</dt>
          <dd class="schedule_text">
              <select name="info[status]">
                  <option value="">-------</option>
                  <option value="1" <?= ($info['status']==1)? "selected":"" ?>>公開</option>
                  <option value="2" <?= ($info['status']==2)? "selected":""?>>非公開</option>
                  <?if (isset($info['id'])) {?>
                      <option value="3">削除</option>
                  <?}?>
              </select>
          </dd>
          <?= isset($errorMsgs['status'])? "<span>{$errorMsgs['status']}</span>": ''?>
      </dl>
      <p class="page">
          <input type="button" onclick="location.href='informationBoard.php'" value="戻る">
          <input type="submit" value="登録">
      </p>
  </form>
</div>
<?php
  require_once("../require/footer.php");
?>
