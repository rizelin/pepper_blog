<?php
require_once("../../require/mysql.php");
require_once("../require/login.php");

//DB読み込み
if (isset($_GET['id'])) {
  $sql = "SELECT `id`,`title`,`text`,`img`,`registration_datetime`,`public_datetime`,`limit_datetime`,`update_datetime`,`status`
          FROM `post`
          WHERE `id` = {$_GET['id']}";

  if ($res = $_link->query($sql)) {
      while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
          $info = $row;
      }
  }
  $info['public_date'] = substr($info['public_datetime'], 0, 10);
  $info['public_time'] =  substr($info['public_datetime'], 11, 8);

  $info['limit_date'] = substr($info['limit_datetime'], 0, 10);
  $info['limit_time'] = substr($info['limit_datetime'], 11, 8);
}

//INSERT,UPDATE
if (isset($_POST['info'])) {
  $info = $_POST['info'];

  //指定したcolumだけ
  $allowColumns = array(
                        'id' => '',
                        'category' => 'カテゴリー',
                        'title' => 'タイトル',
                        'text' => '本文',
                        'img' => '添付ファイル',
                        'public_date' => '公開日',
                        'public_time' => '公開時間',
                        'limit_date' => '公開終了',
                        'limit_time' => '公開終了時間',
                        'status' => '公開範囲',
                        'public_datetime' => '公開日付',
                        'limit_datetime' => '公開終了'
                       );
  //必須項目
  $requireInputs = array('category','title','text','public_date','public_time','status');
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


   if (!empty($info['limit_date']) && $info['public_date'] > $info['limit_date']) {
       $errors['public_date'] = 10;
   }

  foreach ($requireInputs as $key => $value) {
      if (empty($info[$value])) {
        $errors[$value] = 1;
      }
  }
  foreach ($info as $key => $value) {
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
      $info['public_datetime'] = $info['public_date']." ".$info['public_time'];
      $info['limit_datetime'] = isset($info['limit_date'])? (isset($info['limit_time'])? $info['limit_date']." ".$info['limit_time']: "") :"";
      unset($info['public_date'],$info['public_time'],$info['limit_date'],$info['limit_time']);

//file処理
  if(!empty($_FILES['img']['name']) || isset($_POST['file_delete'])) {
      $saveDir = "/home/.sites/117/site48/web/common/media/information/";

      if (!empty($_FILES['img']['name'])) {
          $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
          $info['img'] = date("YmdHis").".".$ext;

          if (is_uploaded_file($_FILES['img']['tmp_name'])) {
              move_uploaded_file($_FILES['img']['tmp_name'],$saveDir.$info['img']);
          }
    }elseif (isset($_POST['file_delete'])) {
          $path = $saveDir.$info['img'];
          @unlink($path);
          $info['img'] = '';
    }
  }

    //sql準備
    //DB情報準備
      $sqlFlg = FALSE;
      $columns = array();
      $values = array();
      foreach ($allowColumns as $key => $value) {
          if (isset($info[$key])) {
              $columns[] = "`{$key}`";
              if (empty($info[$key])) {
                  $values[] = "NULL";
              }else {
                  $values[] = "'".$_link->real_escape_string($info[$key])."'";
              }
          }
      }

    if (is_null($info['id'])) {
      //新規作成
      $columns = implode(',',$columns);
      $values = implode(',',$values);
      $sql = "INSERT INTO `post`($columns, `registration_datetime`)
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
      $sql = "UPDATE `post` SET $updateSet,`update_datetime`=NOW() WHERE `id`={$info['id']}";
      if ($res = $_link->query($sql)) {
          $sqlFlg = TRUE;
      }
    }

    if ($sqlFlg) {
        $_link->commit();
        header("Location:./informationBoard.php");
        exit();
    }else {
        $_link->rollback();
    }
  }

}

require_once("informationWriting.tpl.php");
?>
