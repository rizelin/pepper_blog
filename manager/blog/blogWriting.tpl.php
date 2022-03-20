<?php
    require_once("../require/header.php");
?>
<?if(empty($id)){?>
    <h2 class="title_h2">Blog修正</h1>
<?}else{?>
    <h2 class="title_h2">Blog新規作成</h1>
<?}?>
<section class="info_page">
    <?if(empty($id)){?>
        <p class="sub_navi clearfix"><a href="../require/main.php">TOP</a> ≫ Blog修正</p>
    <?}else{?>
        <p class="sub_navi clearfix"><a href="../require/main.php">TOP</a> ≫ Blog新規作成</p>
    <?}?>
</section><br>
<div class="main_body">
  <form class="write_contents" action="./blogWriting.php" method="post" enctype="multipart/form-data">
      <?if (isset($blog['id'])) {?>
          <input type="hidden" name="blog[id]" value="<?=$blog['id']?>">
      <?}?>
      <input type="hidden" name="blog[category]" value="2">
      <dl>
          <dt>タイトル</dt>
          <dd class="schedule_text"><input type="text" name="blog[title]" value="<?= @$blog['title'] ?>"></dd>
          <?= isset($errorMsgs['title'])? "<span>{$errorMsgs['title']}</span>": ''?>
      </dl>
      <dl class="big_contents">
          <dt>本文</dt>
          <dd><textarea name="blog[text]"><?=@$blog['text'] ?></textarea></dd>
          <?= isset($errorMsgs['text'])? "<span>{$errorMsgs['text']}</span>": ''?>
      </dl>
      <dl class="big_contents">
          <dt>ファイル</dt>
          <dd class="write_img">
              <input type="file" name="img[]" multiple="multiple">
              <?if ($blog['img'][0] != "") {
                foreach ($blog['img'] as $key => $value) {?>
                  <div>
                      <input type="hidden" name="blog[img][]" value="<?=$value?>">
                      <input type="checkbox" id="file_delete<?=$value?>" name="file_delete[]" value="<?=$value?>">
                      <label for="file_delete<?=$value?>">
                        ファイル削除<br><img id="preview" src="/common/media/blog/<?=$value?>">
                      </label>
                  </div>
                <?}
              }?>
          </dd>
          <?= isset($errorMsgs['img'])? "<span>{$errorMsgs['img']}</span>": ''?>
      </dl>

      <? if(isset($_GET['id'])) {?>
          <dl>
              <dt>作成日付</dt>
              <dd><?= $blog['registration_datetime'] ?></dd>
          </dl>
          <dl>
              <dt>修正日付</dt>
              <dd><?= $blog['update_datetime']?></dd>
          </dl>
      <?}?>
      <dl>
          <dt>公開日付</dt>
          <dd>
              <input type="date" name="blog[public_date]" value="<?= $blog['public_date'] ?>">
              <input type="time" name="blog[public_time]" value="<?= $blog['public_time'] ?>">
          </dd>
          <?= isset($errorMsgs['public_date'])? "<span>{$errorMsgs['public_date']}</span>": ''?>
          <?= isset($errorMsgs['public_time'])? "<span>{$errorMsgs['public_time']}</span>": ''?>
      </dl>
      <dl>
          <dt>公開終了</dt>
          <dd>
              <input type="date" name="blog[limit_date]" value="<?= $blog['limit_date'] ?>">
              <input type="time" name="blog[limit_time]" value="<?= $blog['limit_time'] ?>">
          </dd>
          <?= isset($errorMsgs['limit_date'])? "<span>{$errorMsgs['limit_date']}</span>": ''?>
          <?= isset($errorMsgs['limit_time'])? "<span>{$errorMsgs['limit_time']}</span>": ''?>
      </dl>
      <dl>
          <dt>公開範囲</dt>
          <dd class="schedule_text">
              <select name="blog[status]">
                  <option value="">-------</option>
                  <option value="1" <?= ($blog['status']==1)? "selected":"" ?>>公開</option>
                  <option value="2" <?= ($blog['status']==2)? "selected":""?>>非公開</option>
                  <?if (isset($blog['id'])) {?>
                      <option value="3">削除</option>
                  <?}?>
              </select>
          </dd>
          <?= isset($errorMsgs['status'])? "<span>{$errorMsgs['status']}</span>": ''?>
      </dl>
      <p class="page">
          <input type="button" onclick="location.href='./blogBoard.php'" value="戻る">
          <input type="submit" value="登録">
      </p>
  </form>

</div>
<?php
    require_once("../require/footer.php");
?>
