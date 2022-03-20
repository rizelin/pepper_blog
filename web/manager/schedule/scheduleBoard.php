<?php
require_once("../../require/mysql.php");
require_once("../require/login.php");

//曜日
$week = array('日','月','火','水','木','金','土');

//paging
$page = isset($_GET['page'])? $_GET['page']:1;
$sql = "SELECT `id` FROM `schedule`
        WHERE `status` IN(1,2)";
if ($res = $_link->query($sql)) {
    if ($res->num_rows != 0) {
        $totalData = $res->num_rows;
    }
}
$pageCount = 10;
$maxPage = ceil($totalData/$pageCount);
$startNum = ($page-1)*$pageCount;

//リスト読み込み
$sql = "SELECT `id`,`title`,`address`,`start_time`,`end_time`,`limit_count`,`entry_fee`,`registration_datetime`,`public_datetime`,`limit_datetime`,`status`
        FROM `schedule`
        WHERE `status`IN(1,2)
        ORDER BY `start_time` DESC
        LIMIT {$startNum},{$pageCount}" ;
if ($res = $_link->query($sql)) {
    if ($res->num_rows != 0) {
      while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
          if (isset($row['registration_datetime'])) {
              $row['registration_datetime'] = substr(str_replace("-", "/",$row['registration_datetime']),0,10);
          }
          if (isset($row['start_time'])) {
              $day = $week[date('w',strtotime($row['start_time']))];
              $row['start_time'] = substr(str_replace("-", "/",$row['start_time']),0,16);
              $row['start_time'] = substr_replace($row['start_time'],'('.$day.') ',10,1);
          }
          if (isset($row['end_time'])) {
              $row['end_time'] = substr($row['end_time'],-8,-3);
          }

          $scheduleList[] = $row;
      }
      $count = count($scheduleList);
    }
}

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
}
require_once("scheduleBoard.tpl.php");
?>
