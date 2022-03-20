<?php
require_once("../require/mysql.php");

//曜日
$week = array('日','月','火','水','木','金','土');

//paging
$page = isset($_GET['page'])? $_GET['page']:1;
$sql = "SELECT `id` FROM `schedule`
        WHERE `status`=1 AND `public_datetime`< NOW() AND (`limit_datetime`='0000-00-00 00:00:00' OR `limit_datetime`> NOW())";
if ($res = $_link->query($sql)) {
    if ($res->num_rows != 0) {
        $totalData = $res->num_rows;
    }
}
$pageCount = 10;
$maxPage = ceil($totalData/$pageCount);
$startNum = ($page-1)*$pageCount;

//リスト読み込み
$sql = "SELECT `id`,`title`,`address`,`start_time`,`end_time`,`img`,`limit_count`,`entry_fee`,`public_datetime`,`limit_datetime`,`status`
        FROM `schedule`
        WHERE `status`=1 AND `public_datetime`< NOW() AND (`limit_datetime`='0000-00-00 00:00:00' OR `limit_datetime`> NOW())
        ORDER BY `start_time` 
        LIMIT {$startNum},{$pageCount}" ;
if ($res = $_link->query($sql)) {
    if ($res->num_rows != 0) {
      while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
            $row['public_datetime'] = substr(str_replace("-", "/",$row['public_datetime']),0,10);
            $day = $week[date('w',strtotime($row['start_time']))];
            $row['start_time'] = substr(str_replace("-", "/",$row['start_time']),0,16);
            $row['start_time'] = substr_replace($row['start_time'],'('.$day.') ',10,1);
            $row['end_time'] = substr($row['end_time'],-8,-3);

          $scheduleList[] = $row;
      }
      $count = count($scheduleList);
    }
}


$timeNow = date("Y/m/d");
$timeNow = strtotime($timeNow);
$timeOut = array();
//定員
for ($i=0; $i < $count; $i++) {
  $sql = "SELECT SUM(a.`reservation_count`) as r_c
          FROM `inquiry` as a
          INNER JOIN `schedule` as b
          ON a.`schedule_id` = b.`id`
          WHERE a.`schedule_id` = {$scheduleList[$i]['id']}
          AND a.`checked` IN(1,2)";

    if ($res = $_link->query($sql)) {
          if ($row = $res->fetch_array(MYSQLI_ASSOC)) {
                $rc = $row ;
            }
    }
  $reservationCount[$i] = (is_null($rc['r_c']))? (int)0:(int)$rc['r_c'];

  /*現在時間と授業時間の日付比較、超えたら配列に入れて値が配列にあるかどうか判断
  $scheduleList[$i]['start_time'] = substr($scheduleList[$i]['start_time'],0,10);
  $time = strtotime($scheduleList[$i]['start_time']);

  if($timeNow > $time) {
    $timeOut[] = $i;
  }*/

}

require_once("scheduleBoard.tpl.php");
?>
