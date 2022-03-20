<?php
require_once("../../require/mysql.php");
require_once("../require/login.php");

$prefectures = array(
  1 => '北海道',2 => '青森県',3 => '岩手県',4 => '宮城県',5 => '秋田県',
  6 => '山形県',7 => '福島県',8 => '茨城県',9 => '栃木県',10 => '群馬県',
  11 => '埼玉県',12 => '千葉県',13 => '東京都',14 => '神奈川県',15 => '新潟県',
  16 => '富山県',17 => '石川県',18 => '福井県',19 => '山梨県',20 => '長野県',
  21 => '岐阜県',22 => '静岡県',23 => '愛知県',24 => '三重県',25 => '滋賀県',
  26 => '京都府',27 => '大阪府',28 => '兵庫県',29 => '奈良県',30 => '和歌山県',
  31 => '鳥取県',32 => '島根県',33 => '岡山県',34 => '広島県',35 => '山口県',
  36 => '徳島県',37 => '香川県',38 => '愛媛県',39 => '高知県',40 => '福岡県',
  41 => '佐賀県',42 => '長崎県',43 => '熊本県',44 => '大分県',45 => '宮崎県',
  46 => '鹿児島県',47 =>'沖縄県'
);

//Select List
$sql = "SELECT `id`,`title` FROM `schedule`";
if ($res = $_link->query($sql)) {
    while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
        $schedule[] = $row;
    }
    $scheduleCnt = count($schedule);
}

/*paging, searchの where文*/
if ($_GET['schedule'] != 0) {
  $where = "WHERE `schedule_id` = {$_GET['schedule']}";
}

//paging
$sql = "SELECT `id` FROM `inquiry` {$where}";
if ($res = $_link->query($sql)) {
    if ($res->num_rows != 0) {
        $totalData = $res->num_rows;
    }
}
$page = isset($_GET['page'])? $_GET['page']:1;
$pageCount = 10;
$maxPage = ceil($totalData/$pageCount);
$startNum = ($page-1)*$pageCount;

//reservation search
$sql = "SELECT `id`,`company`,`name`,`age`,`email`,`tel`,`zip_code`,`prefecture`,`address1`,`address2`,`reservation_count`,`registration_datetime`,`response_datetime`,`checked`
        FROM `inquiry` {$where}
        ORDER BY `registration_datetime` DESC
        LIMIT {$startNum},{$pageCount}";

if ($res = $_link->query($sql)) {
    while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
        if (!empty($row['registration_datetime'])) {
          $row['registration_datetime'] = substr(str_replace("-", "/", $row['registration_datetime']),0,10);
        }
        if (!empty($row['response_datetime'])) {
            $row['response_datetime'] = substr(str_replace("-", "/", $row['response_datetime']),0,10);
        }
        foreach ($prefectures as $key => $value) {
            if ($row['prefecture'] == $key) {
                $row['prefecture'] = $value;
            }
        }
            $inquiry[] = $row;
    }
    $inquiryCnt = count($inquiry);
}

require_once("checkInquiryBoard.tpl.php");
?>
