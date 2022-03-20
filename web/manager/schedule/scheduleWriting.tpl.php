<?php
  require_once("../require/header.php");
?>
<? if(empty($id)){?>
    <h2 class="title_h2">スケジュール修正</h1>
<?}else{?>
    <h2 class="title_h2">スケジュール新規作成</h1>
<?}?>
<section class="info_page">
    <? if(empty($id)){?>
        <p class="sub_navi clearfix"><a href="../require/main.php">TOP</a> ≫ スケジュール修正</p>
    <?}else{?>
        <p class="sub_navi clearfix"><a href="../require/main.php">TOP</a> ≫ スケジュール新規作成</p>
    <?}?>
</section><br>
<div class="main_body">
    <form class="write_contents" method="post" enctype="multipart/form-data">
        <?if (isset($schedule['id'])) {?>
            <input type="hidden" name="schedule[id]" value="<?=$schedule['id']?>">
        <?}?>
        <dl>
            <dt>タイトル</dt>
            <dd class="schedule_text"><input type="text" name="schedule[title]" value="<?= @$schedule['title'] ?>"></dd>
            <?= isset($errorMsgs['title'])? "<br><span>{$errorMsgs['title']}</span>": ''?>
        </dl>
        <dl>
            <dt>開催地</dt>
            <dd class="schedule_text"><input type="text" name="schedule[address]" value="<?= @$schedule['address'] ?>"></dd>
            <?= isset($errorMsgs['address'])? "<br><span>{$errorMsgs['address']}</span>": ''?>
        </dl>
        <dl>
            <dt>日付日時</dt>
            <dd>
                <input type="date" placeholder="yyyy-mm-dd" name="schedule[start_date]" value="<?= @$schedule['start_date'] ?>">
                <input type="time" placeholder="hh:mm" name="schedule[start_time]" value="<?= @$schedule['start_time'] ?>">
                ~ <input type="time" placeholder="hh:mm" name="schedule[end_time]" value="<?= @$schedule['end_time'] ?>">
            </dd>
            <?= isset($errorMsgs['limit_date'])? "<br><span>{$errorMsgs['start_date']}</span>": ''?>
            <?= isset($errorMsgs['limit_time'])? "<br><span>{$errorMsgs['start_time']}</span>": ''?>
            <?= isset($errorMsgs['limit_time'])? "<br><span>{$errorMsgs['end_time']}</span>": ''?>
        </dl>
        <dl>
            <dt>参加費</dt>
            <dd class="schedule_text"><input type="text" name="schedule[entry_fee]" value="<?= @$schedule['entry_fee'] ?>"></dd>
            <?= isset($errorMsgs['entry_fee'])? "<br><span>{$errorMsgs['entry_fee']}</span>": ''?>
        </dl>
        <dl>
            <dt>定員</dt>
            <dd class="schedule_text"><input type="text" name="schedule[limit_count]" value="<?= @$schedule['limit_count'] ?>"></dd>
            <?= isset($errorMsgs['limit_count'])? "<br><span>{$errorMsgs['limit_count']}</span>": ''?>
        </dl>
        <dl class="big_contents">
            <dt>本文</dt>
            <dd><textarea name="schedule[text]"><?= @$schedule['text'] ?></textarea></dd>
            <?= isset($errorMsgs['text'])? "<span>{$errorMsgs['text']}</span>": ''?>
        </dl>
        <dl class="big_contents">
            <dt>ファイル</dt>
            <dd class="write_img">
                <input type="file" name="img">
                <?if (!empty($schedule['img'])) {?>
                      <input type="hidden" name="schedule[img]" value="<?=$schedule['img']?>">
                      <label for="file_delete">ファイル削除</label>
                      <input type="checkbox" id="file_delete" name="file_delete" value="1">
                      <img id="preview" src="/common/media/schedule/<?=$schedule['img']?>">
                <?}?>
            </dd>
            <?= isset($errorMsgs['img'])? "<span>{$errorMsgs['img']}</span>": ''?>
        </dl>
        <? if(isset($_GET['id'])) {?>
            <dl>
                <dt>作成日付</dt>
                <dd><?= $schedule['registration_datetime'] ?></dd>
            </dl>
            <dl>
                <dt>修正日付</dt>
                <dd><?= $schedule['update_datetime']?></dd>
            </dl>
        <?}?>
        <dl>
            <dt>公開日付</dt>
            <dd>
                <input type="date" placeholder="yyyy-mm-dd" name="schedule[public_date]" value="<?= $schedule['public_date'] ?>">
                <input type="time" placeholder="hh:mm" name="schedule[public_time]" value="<?= $schedule['public_time'] ?>">
            </dd>
            <?= isset($errorMsgs['public_date'])? "<br><span>{$errorMsgs['public_date']}</span>": ''?>
            <?= isset($errorMsgs['public_time'])? "<br><span>{$errorMsgs['public_time']}</span>": ''?>
        </dl>
        <dl>
            <dt>公開終了</dt>
            <dd>
                <input type="date" placeholder="yyyy-mm-dd" name="schedule[limit_date]" value="<?= $schedule['limit_date'] ?>">
                <input type="time" placeholder="hh:mm" name="schedule[limit_time]" value="<?= $schedule['limit_time'] ?>">
            </dd>
            <?= isset($errorMsgs['limit_date'])? "<br><span>{$errorMsgs['limit_date']}</span>": ''?>
            <?= isset($errorMsgs['limit_time'])? "<br><span>{$errorMsgs['limit_time']}</span>": ''?>
        </dl>
        <dl>
            <dt>公開範囲</dt>
            <dd class="schedule_text">
                <select name="schedule[status]">
                    <option value="">-------</option>
                    <option value="1" <?= ($schedule['status']==1)? "selected":"" ?>>公開</option>
                    <option value="2" <?= ($schedule['status']==2)? "selected":""?>>非公開</option>
                    <?if (isset($schedule['id'])) {?>
                        <option value="3">削除</option>
                    <?}?>
                </select>
            </dd>
            <?= isset($errorMsgs['status'])? "<br><span>{$errorMsgs['status']}</span>": ''?>
        </dl>
        <p class="page">
            <label for="creat_new">修正して新規作成</label>
            <input type="checkbox" id="creat_new" name="creat_new" value="1">
        </p>
        <p class="page">
            <input type="button" onclick="location.href='./scheduleBoard.php'" value="戻る">
            <input type="submit" value="登録">
        </p>
    </form>
</div>
<?php
  require_once("../require/footer.php");
?>
