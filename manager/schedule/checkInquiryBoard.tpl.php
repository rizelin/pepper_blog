<?php
  require_once("../require/header.php");
?>
<h2 class="title_h2">予約現況</h1>
<div class="main_body">
  <p class="sub_navi clearfix"><a href="../require/main.php">HOME</a> ≫ 予約状況</p>

    <form class="check_board_form" action="./checkInquiryBoard.php" method="get">
      <select name="schedule">
          <option value="0">全体予約</option>
          <?for ($i=0; $i < $scheduleCnt ; $i++) {?>
              <option value="<?= $schedule[$i]['id'] ?>" <?=$_GET['schedule']==$schedule[$i]['id']?"selected":""?>><?= $schedule[$i]{'title'} ?></option>
          <?}?>
      </select>
      <input type="submit" value="検索">
    </form>
    <div class="checkin_contents">
        <table class="check_board_table">
            <tr>
                <th>予約日付</th>
                <th>会社名</th>
                <th>お名前</th>
                <th>参加希望人数</th>
                <th>状態変更</th>
                <th>状態</th>
                <th>情報詳細</th>
            </tr>
          <?for ($i=0; $i < $inquiryCnt; $i++) {?>
                <tr class="checkin_tr">
                    <td>
                      <?= $inquiry[$i]['registration_datetime'] ?>
                    </td>
                    <td><?= $inquiry[$i]['company'] ?></td>
                    <td><?= $inquiry[$i]['name'] ?></td>
                    <td><?= $inquiry[$i]['reservation_count'] ?></td>
                    <td>
                      <input type="button" class="bnt_color" name="confirm" value="確定" onclick="confirm(<?= $inquiry[$i]['id'] ?>)">
                      <input type="button" class="bnt_color" name="cancel" value="キャンセル" onclick="cancel(<?= $inquiry[$i]['id'] ?>)">
                    </td>
                    <td id="checked" name="checked" class="checked<?= $inquiry[$i]['id'] ?>">
                        <?switch ($inquiry[$i]['checked']) {
                          case 2:?>  確定完了      <?  break;
                          case 3:?>  キャンセル完了 <?  break;
                          default:?> 確認前        <?  break;  }?>
                        <br><?=substr($inquiry[$i]['response_datetime'],0,10)?>
                    </td>
                    <td>
                      <input type="button" id="detali_btn<?=$inquiry[$i]['id']?>" class="detail_btn bnt_color" value="見る" onclick="detailInfo(<?= $inquiry[$i]['id'] ?>)">
                      <input type="button" id="close_btn<?=$inquiry[$i]['id']?>" class="close_btn bnt_color" value="閉じる" onclick="closeInfo(<?= $inquiry[$i]['id'] ?>)">
                    </td>
                </tr>

                <tr id="detail<?=$inquiry[$i]['id']?>" class="detail_info">
                    <td colspan="2">email: <?=$inquiry[$i]['email']?></td>
                    <td colspan="2">電話番号: <?=$inquiry[$i]['tel']?></td>
                    <td colspan="3">住所: <?=$inquiry[$i]['zip_code']?> <?= $inquiry[$i]['prefecture'].$inquiry[$i]['address1'].$inquiry[$i]['address2']?></td>
                </tr>
            <?}?>
        </table>
    </div>


    <article class="page_num">
      <?if ($page != 1) {?>
          <a class="pre_page" href="./checkInquiryBoard.php?schedule=<?=$_GET['schedule']?>&page=1"><<</a>
      <?}
      for ($i=($page-5)<1? 1:($page-5); $i<($page+5) ; $i++) {
          if ($i < $page) {?>
              <a class="pages" href="./checkInquiryBoard.php?schedule=<?=$_GET['schedule']?>&page=<?=$i?>"><?= $i ?></a>
          <?}elseif ($i == $page) {?>
              <span class="current_pages"><?= $i ?></span>
          <?}elseif ($i <= $maxPage) {?>
              <a class="pages" href="./checkInquiryBoard.php?schedule=<?=$_GET['schedule']?>&page=<?=$i?>"><?= $i ?></a>
          <?}
      }
      if ($page != $maxPage) {?>
          <a class="next_page" href="./checkInquiryBoard.php?schedule=<?=$_GET['schedule']?>&page=<?=$maxPage?>">>></a>
      <?}?>
    </article>


</div>

<?php
  require_once("../require/footer.php");
?>
