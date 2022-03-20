<?php
require_once("../../require/mysql.php");
require_once("../require/login.php");

//DB読み込み
if (isset($_GET['id'])) {
  $sql = "SELECT `id`,`title`,`text`,`img`,`address`,`start_time`,`end_time`,`entry_fee`,`limit_count`,`registration_datetime`,`public_datetime`,`limit_datetime`,`update_datetime`,`status`
          FROM `schedule`
          WHERE `id` = {$_GET['id']}";

  if ($res = $_link->query($sql)) {
      while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
          $schedule = $row;
      }
  }
  $schedule['public_date'] = substr($schedule['public_datetime'], 0, 10);
  $schedule['public_time'] =  substr($schedule['public_datetime'], 11, 8);

  $schedule['limit_date'] = substr($schedule['limit_datetime'], 0, 10);
  $schedule['limit_time'] = substr($schedule['limit_datetime'], 11, 8);

  $schedule['start_date'] = substr($schedule['start_time'], 0, 10);
  $schedule['start_time'] = substr($schedule['start_time'], 11, 8);

  $schedule['end_time'] = substr($schedule['end_time'], 11, 8);
}


//INSERT,UPDATE
if (isset($_POST['schedule'])) {
  $schedule = $_POST['schedule'];

  //指定したcolumだけ
  $allowColumns = array(
                        'id' => '',
                        'title' => 'タイトル',
                        'text' => '本文',
                        'img' => '添付ファイル',
                        'address' => '開催地',
                        'entry_fee' => '参加費',
                        'start_date' => 'スケジュール日付',
                        'start_time' => '始まり時間',
                        'end_time' => '終わり時間',
                        'limit_count' => '定員',
                        'public_date' => '公開日',
                        'public_time' => '公開時間',
                        'limit_date' => '制限日',
                        'limit_time' => '制限時間',
                        'status' => '公開範囲',
                        'public_datetime' => '公開日付',
                        'limit_datetime' => '制限日付'
                       );
  //必須項目
  $requireInputs = array('title','text','address','start_date','start_time','end_time','limit_count','public_date','public_time','status');
  $errorType = array(
                     1 => 'が入力されていません。',
                     2 => 'が不正に入力されています。',
                     3 => '最大アップロードできるファイルサイズは2MBです。',
                     4 => '最大アップロードできるファイルサイズは2MBです。',
                     5 => 'アップロードされたファイルは一部のみしかアップロードされていません。',
                     7 => 'テンポラリフォルダがありません。',
                     8 => 'ディスクへの書き込みに失敗しました。',
                     9 => 'ファイルのアップロードを中止しました。',
                     10 => 'が公開終了より遅いです。'
                   );

/*
  limit_count는 숫자만
  end_time < start_time
  limit_date <= public_date 같을 시에는 limit_time < public_time
*/
  if (!empty($schedule['limit_date']) && $schedule['public_date'] > $schedule['limit_date']) {
      $errors['public_date'] = 10;
  }

  foreach ($requireInputs as $key => $value) {
      if (empty($schedule[$value])) {
        $errors[$value] = 1;
      }
  }
  foreach ($schedule as $key => $value) {
      if (!in_array($key,array_keys($allowColumns))) {
        $errors[$key] = 2;
      }
  }

  if ($_FILES['img']['error'] > 0) {
      switch ($_FILES['img']['error']) {
          case 1:  $errors['img'] = 3; break;
        	case 2:  $errors['img'] = 4; break;
        	case 3:  $errors['img'] = 5;break;
        	case 6:  $errors['img'] = 7; break;
        	case 7:  $errors['img'] = 8; break;
        	case 8:  $errors['img'] = 9; break;
      }
  }

  if (isset($errors)) {
    $errorMsgs = array();
    foreach ($errors as $key => $value) {
      $errorMsgs[$key] = "{$allowColumns[$key]}{$errorType[$value]}";

    }

  }else {
      $schedule['public_datetime'] = $schedule['public_date']." ".$schedule['public_time'];
      $schedule['limit_datetime'] = isset($schedule['limit_date'])? (isset($schedule['limit_time'])? $schedule['limit_date']." ".$schedule['limit_time']: "") :"";
      $schedule['start_time'] = $schedule['start_date']." ".$schedule['start_time'];
      $schedule['end_time'] = $schedule['start_date']." ".$schedule['end_time'];

      unset($schedule['public_date'],$schedule['public_time'],$schedule['limit_date'],$schedule['limit_time'],$schedule['start_date']);

      //file処理
        if(!empty($_FILES['img']['name']) || isset($_POST['file_delete'])) {
            $saveDir = "/home/.sites/117/site48/web/common/media/schedule/";

            if (!empty($_FILES['img']['name'])) {
                $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
                $schedule['img'] = date("YmdHis").".".$ext;

                if (is_uploaded_file($_FILES['img']['tmp_name'])) {
                    move_uploaded_file($_FILES['img']['tmp_name'],$saveDir.$schedule['img']);
                }
          }elseif (isset($_POST['file_delete'])) {
                $path = $saveDir.$schedule['img'];
                @unlink($path);
                $schedule['img'] = '';
          }
        }

    //DB情報準備
      $sqlFlg = FALSE;
      $columns = array();
      $values = array();
      foreach ($allowColumns as $key => $value) {
          if (isset($schedule[$key])) {
              $columns[] = "`{$key}`";
              if (empty($schedule[$key])) {
                  $values[] = "NULL";
              }else {
                  $values[] = "'".$_link->real_escape_string($schedule[$key])."'";
              }
          }
      }

    if (is_null($schedule['id']) || isset($_POST['creat_new'])) {
      //新規作成
      if (isset($_POST['creat_new'])) {
        unset($columns[0],$values[0]);
      }

      $columns = implode(',',$columns);
      $values = implode(',',$values);
      $sql = "INSERT INTO `schedule`($columns, `registration_datetime`)
              VALUES($values, NULL)";

      if ($res = $_link->query($sql)) {
          if ($_link->affected_rows == 1) {
            $sqlFlg = TRUE;
          }
      }

    }else {
      //修正・削除
      foreach ($columns as $key => $value) {
          if($value != "`id`") {
              $updateSet[] = "$value={$values[$key]}";
          }
      }
      $updateSet = implode(",", $updateSet);
      $sql = "UPDATE `schedule` SET $updateSet,`update_datetime`=NOW() WHERE `id`={$schedule['id']}";
      if ($res = $_link->query($sql)) {
          $sqlFlg = TRUE;
      }
    }

    if ($sqlFlg) {
        $_link->commit();
        header("Location:./scheduleBoard.php");
        exit();
    }else {
        $_link->rollback();
    }
  }

}

require_once("scheduleWriting.tpl.php");
?>
