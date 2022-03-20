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
          $blog = $row;
      }
  }
  $blog['public_date'] = substr($blog['public_datetime'], 0, 10);
  $blog['public_time'] =  substr($blog['public_datetime'], 11, 8);

  $blog['limit_date'] = substr($blog['limit_datetime'], 0, 10);
  $blog['limit_time'] = substr($blog['limit_datetime'], 11, 8);

  $blog['img'] = explode(",",$blog['img']);
}

//INSERT,UPDATE
if (isset($_POST['blog'])) {
  $blog = $_POST['blog'];

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
                     3 => 'が公開終了より遅いです。'
                  );

  if (!empty($blog['limit_date']) && $blog['public_date'] > $blog['limit_date']) {
    $errors['public_date'] = 3;
  }

  foreach ($requireInputs as $key => $value) {
      if (empty($blog[$value])) {
        $errors[$value] = 1;
      }
  }
  foreach ($blog as $key => $value) {
      if (!in_array($key,array_keys($allowColumns))) {
        $errors[$key] = 2;
      }
  }

if ($_FILES['img']['name'][0] != "") {
  $imgError = array();
  foreach ($_FILES['img']['error'] as $key => $value) {
      switch ($_FILES['img']['error'][$key]) {
          case 1:  $imgError[] = $_FILES['img']['name'][$key].":最大アップロードできるファイルサイズは2MBです。"; break;
        	case 2:  $imgError[] = $_FILES['img']['name'][$key].":最大アップロードできるファイルサイズは2MBです。"; break;
        	case 3:  $imgError[] = $_FILES['img']['name'][$key].":アップロードされたファイルは一部のみしかアップロードされていません。";break;
        	case 4:  $imgError[] = $_FILES['img']['name'][$key].":ファイルはアップロードされませんでした。"; break;
        	case 6:  $imgError[] = $_FILES['img']['name'][$key].":テンポラリフォルダがありません。"; break;
        	case 7:  $imgError[] = $_FILES['img']['name'][$key].":ディスクへの書き込みに失敗しました。"; break;
        	case 8:  $imgError[] = $_FILES['img']['name'][$key].":ファイルのアップロードを中止しました。"; break;
      }
  }
  if (!empty($imgError)) {
    $errors['img'] = implode("\n",$imgError);
  }
}

//error確認
  if (isset($errors)) {

    $errorMsgs = array();
    foreach ($errors as $key => $value) {
      if ($key == 'img') {
        $errorMsgs[$key] = $errors['img'];
      }else {
        $errorMsgs[$key] = "{$allowColumns[$key]}{$errorType[$value]}";
      }
    }
  }else {

      $blog['public_datetime'] = $blog['public_date']." ".$blog['public_time'];
      $blog['limit_datetime'] = isset($blog['limit_date'])? (isset($blog['limit_time'])? $blog['limit_date']." ".$blog['limit_time']: "") :"";
      unset($blog['public_date'],$blog['public_time'],$blog['limit_date'],$blog['limit_time']);

  //file処理
  if (isset($_POST['file_delete'])) {
    foreach ($blog['img'] as $blogKey => $fileName) {
      foreach ($_POST['file_delete'] as $key => $deleteFile) {
          if ($fileName == $deleteFile) {
              $path = $saveDir.$deleteFile;  //folder用
              @unlink($path);
              unset($blog['img'][$blogKey]);
          }
      }
    }
  }
  if (isset($blog['img'])) {
    $blog['img'] = implode(",",$blog['img']);
  }

  if($_FILES['img']['name'][0] != "") {
      $saveDir = "/home/.sites/117/site48/web/common/media/blog/";
      $img = array();

        foreach ($_FILES['img']['name'] as $key => $value) {
          //ファイル拡張子確認
          $ext = pathinfo($_FILES['img']['name'][$key], PATHINFO_EXTENSION);
          $img[$key] = date("YmdHis")."_{$key}.".$ext;
          if (is_uploaded_file($_FILES['img']['tmp_name'][$key])) {
              move_uploaded_file($_FILES['img']['tmp_name'][$key],$saveDir.$img[$key]);
          }
        }
        $img = implode(",",$img);
        $blog['img'] .= (empty($blog['img']))? $img: ",".$img;
    }


    //sql準備
    //DB情報準備
      $sqlFlg = FALSE;
      $columns = array();
      $values = array();
      foreach ($allowColumns as $key => $value) {
          if (isset($blog[$key])) {
              $columns[] = "`{$key}`";
              if (empty($blog[$key])) {
                  $values[] = "NULL";
              }else {
                  $values[] = "'".$_link->real_escape_string($blog[$key])."'";
              }
          }
      }
    if (is_null($blog['id'])) {
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
      $sql = "UPDATE `post` SET $updateSet,`update_datetime`=NOW() WHERE `id`={$blog['id']}";

      if ($res = $_link->query($sql)) {
          $sqlFlg = TRUE;
      }
    }

    if ($sqlFlg) {
        $_link->commit();
        header("Location:./blogBoard.php");
        exit();
    }else {
        $_link->rollback();
    }
  }
}

require_once("blogWriting.tpl.php");
?>
