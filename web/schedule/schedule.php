<?php
require_once("../require/mysql.php");

//曜日
$week = array('日','月','火','水','木','金','土');

if (isset($_GET['id'])) {
    $sql = "SELECT `id`,`title`,`text`,`img`,`address`,`start_time`,`end_time`,`limit_count`,`entry_fee`,`registration_datetime`,`public_datetime`,`limit_datetime`,`status`
            FROM `schedule`
            WHERE `id` = {$_GET['id']}";

    if ($res = $_link->query($sql)) {
        while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
              $row['registration_datetime'] = substr(str_replace("-", "/",$row['registration_datetime']),0,10);
              $day = $week[date('w',strtotime($row['start_time']))];
              $row['start_time'] = substr(str_replace("-", "/",$row['start_time']),0,16);
              $row['start_time'] = substr_replace($row['start_time'],'('.$day.') ',11,1);
              $row['end_time'] = substr($row['end_time'],-8,-3);
            $schedule = $row;
        }
    }
    $schedule['registration_datetime'] = substr($schedule['registration_datetime'],0,10);


    //定員
    $sql = "SELECT SUM(a.`reservation_count`) as r_c
            FROM `inquiry` as a
            INNER JOIN `schedule` as b
            ON a.`schedule_id` = b.`id`
            WHERE a.`schedule_id` = {$_GET['id']}
            AND a.`checked` IN(1,2)";

    if ($res = $_link->query($sql)) {
      if ($row = $res->fetch_array(MYSQLI_ASSOC)) {
        $rc = $row ;
      }
    }
    $reservationCount = (is_null($rc['r_c']))? (int)0:(int)$rc['r_c'];

    /*現在時間と授業時間の日付比較、超えたら配列に入れて値が配列にあるかどうか判断
    $timeNow = date("Y/m/d");
    $timeNow = strtotime($timeNow);
    $time = substr($schedule['start_time'],0,10);
    $time = strtotime($time);

    if($timeNow > $time) {
      $timeOut = $i;
    }
    */
}


require_once("schedule.tpl.php");
?>
