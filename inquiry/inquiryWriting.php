<?php
require_once("../require/mysql.php");

$week = array('日','月','火','水','木','金','土');
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

if (isset($_SESSION['inquiry'])) {
  $inquiry = $_SESSION['inquiry'];
  foreach ($prefectures as $key => $value) {
      if ($inquiry['prefecture'] == $value) {
          $inquiry['prefecture'] = $key;
      }
  }
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $sql = "SELECT `id`,`title`,`address`,`start_time`,`end_time`,`limit_count`,`entry_fee`,`registration_datetime`,`public_datetime`,`limit_datetime`,`status`
          FROM `schedule`
          WHERE `id` = $id" ;
  if ($res = $_link->query($sql)) {
        while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
            $row['title'] = strip_tags($row['title']);
            $day = $week[date('w',strtotime($row['start_time']))];
            $row['start_time'] = substr(str_replace("-", "/", $row['start_time']),0,16);
            $row['start_time'] = substr_replace($row['start_time'],'('.$day.') ',10,1);
            $row['end_time'] = substr($row['end_time'],-8,-3);
            $schedule = $row;
        }
  }

  //定員
  $sql = "SELECT SUM(a.`reservation_count`) as r_c
          FROM `inquiry` as a
          INNER JOIN `schedule` as b
          ON a.`schedule_id` = b.`id`
          WHERE a.`schedule_id` = $id
          AND a.`checked` IN(1,2)";

  if ($res = $_link->query($sql)) {
      if ($row = $res->fetch_array(MYSQLI_ASSOC)) {
            $rc = $row;
      }
      $reservationCount = (is_null($rc['r_c']))? (int)0:(int)$rc['r_c'];
  }
}

if (isset($_POST['inquiry'])) {
  $inquiry = $_POST['inquiry'];
  $allowColumns = array(
                        'company' => '会社名',
                        'name' => 'お名前',
                        'age' => '学年(年齢)',
                        'email' => 'メールアドレス',
                        'email2' => '確認用メールアドレス',
                        'tel' => 'お電話番号',
                        'zip_code' => '郵便番号',
                        'prefecture' => '都道府県',
                        'address1' => '市・区・郡・町',
                        'address2' => '番地・建物名等',
                        'reservation_count' => '参加希望人数'
                        );

  $requiredInputs = array('name','age','email','email2','tel','prefecture','address1','reservation_count');

  $errorTypes = array(
                      1 => 'が入力されていません。' ,
                      2 => 'が不正に入力されました。' ,
                      3 => 'メールアドレスと確認用メールアドレスが一致しません。',
                      4 => 'が定員より多いです。',
                      5 => 'に正しい数字を入れてください。'
                      );

  foreach ($requiredInputs as $key => $value) {
      if (empty($inquiry[$value])) {
          $errors[$value] = 1;
      }
  }

  foreach ($inquiry as $key => $value) {
      if (!in_array($key, array_keys($allowColumns))) {
          $errors[$key] = 2;
      }
  }
  if ($inquiry['email'] !== $inquiry['email2']) {
      $errors['emailConfirm'] = 3;
  }

  if ($inquiry['reservation_count'] > $schedule['limit_count']-$reservationCount) {
     $errors['reservation_count'] = 4;
  }
  if ($inquiry['reservation_count'] <= 0) {
    $errors['reservation_count'] = 5;
  }


    if (isset($errors)) {
      $errorMsgs = array();
      foreach ($errors as $key => $value) {
          $errorMsgs[$key] = "{$allowColumns[$key]}{$errorTypes[$value]}";
      }

    }else {
        foreach ($prefectures as $key => $value) {
            if ($inquiry['prefecture'] == $key) {
                $inquiry['prefecture'] = $value;
            }
        }
        $_SESSION['schedule'] = $schedule;
        $_SESSION['inquiry'] = $inquiry;
        header("Location:./inquiryConfirm.php");
        exit();
    }
}

require_once("inquiryWriting.tpl.php");
?>
