<?php
require_once("./mysql.php");
$main = 1;
//曜日
$week = array('日','月','火','水','木','金','土');

//schedule
$sql = "SELECT `id`,`title`,`start_time`,`end_time`,`address`
        FROM `schedule`
        WHERE `status`=1 AND `public_datetime`< NOW() AND (`limit_datetime`='0000-00-00 00:00:00' OR `limit_datetime`> NOW())
        ORDER BY `start_time` 
        LIMIT 0,5";
if ($res = $_link->query($sql)) {
  while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
      $day = $week[date('w',strtotime($row['start_time']))];
      $row['start_time'] = substr(str_replace("-", "/", $row['start_time']),0,16);
      $row['start_time'] = substr_replace($row['start_time'],'('.$day.') ',10,1);
      $row['end_time'] = substr($row['end_time'],-8,-3);
      $schedule[] = $row;
  }
  $scheduleCnt = count($schedule);
}

//info
$sql = "SELECT `id`,`title`,`public_datetime`
        FROM `post`
        WHERE `status`=1 AND `category`=1 AND `public_datetime`<NOW()
        ORDER BY `public_datetime` DESC
        LIMIT 0,5";
if ($res = $_link->query($sql)) {
  while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
    if (isset($row['public_datetime'])) {
        $row['public_datetime'] = substr(str_replace("-", "/", $row['public_datetime']),0,10);
    }
      $information[] = $row;
  }
  $informationCnt = count($information);
}



require_once("main.tpl.php");
?>
