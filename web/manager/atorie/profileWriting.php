<?php
ini_set('display.errors',1);
require_once("../../require/mysql.php");
require_once("../require/login.php");

$subTxtCnt = 0;
//修正
if (isset($_GET['fixed_id'])) {
    $sql = "SELECT * FROM `profile` WHERE `id`={$_GET['fixed_id']}";
    if ($res = $_link->query($sql)) {
        while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
          $profile = $row;
        }
    }

  $subTxtCnt = substr_count($profile['text'],"<dt>");   //sub内容数
  $profile['text'] = explode("</dl>",$profile['text']); //main,sub内容分ける

  $subText = explode("<dt>",$profile['text'][1]);//sub内容
  unset($subText[0]);
  foreach ($subText as $key => $value) { //dt,dd別で保存
    $a = explode("<dd>",$value);
    $dt[$key] = strip_tags($a[0]);
    $dd[$key] = strip_tags($a[1]);
  }

  $profile['text'] = strip_tags($profile['text'][0]);
}


if(isset($_POST['profile'])){
$profile = $_POST['profile'];

    //全体項目
    $allowColumns = array(
         'id' => 'ID'
        ,'title' => 'タイトル'
        ,'text' => '本文'
        ,'img' => 'イメージ'
        ,'status' => '削除'
    );
    //必須項目
    $requiredInputs = array(
        'title'
       ,'text'
    );
    $errorTypes = array('1' => 'が未入力です','2' => 'が不正な入力です');

    foreach ($requiredInputs as $key => $val) {
      if (empty($profile[$val])) {
        $errors[$val] = '1';
      }
    }
    foreach ($profile as $key => $val) {
        if(!in_array($key, array_keys($allowColumns))){
            $errors[$key] = '2';
        }
    }
    //img error
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

    if(isset($errors)){
        $errorMsgs = array();
        foreach($errors as $key => $val){
            $errorMsgs[$key] = "{$allowColumns[$key]}{$errorTypes[$val]}";
        }

    }else{

      //file処理
        if(!empty($_FILES['img']['name']) || isset($_POST['file_delete'])) {
            $saveDir = "/home/.sites/117/site48/web/common/media/profile/";

            if (!empty($_FILES['img']['name'])) {
                $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
                $profile['img'] = date("YmdHis").".".$ext;

                if (is_uploaded_file($_FILES['img']['tmp_name'])) {
                  move_uploaded_file($_FILES['img']['tmp_name'],$saveDir.$profile['img']);
                }
          }elseif (isset($_POST['file_delete'])) {
                $path = $saveDir.$profile['img'];
                @unlink($path);
                $profile['img'] = '';
          }
        }

        //内容
        $str ="";
        if (!empty($_POST['dt'][1])) {
           foreach ($_POST['dt'] as $key => $value) {
             $str .= "<dt>".$value."</dt><dd>".$_POST['dd'][$key]."</dd>";
           }
           if (!empty($profile['img'])) {
              $profile['text'] = "<dl class='img_dl'><dd>{$profile['text']}</dd></dl>".$str;
           }else {
              $profile['text'] = "<dl><dd>{$profile['text']}</dd></dl>".$str;
           }
      
        }


      //sql準備
      $sqlFlg = FALSE;
      $columns = array();
      $values = array();
      foreach ($allowColumns as $key => $val) {
        if(isset($profile[$key])){
          $columns[] = "`{$key}`";
          if(empty($profile[$key])){
            $values[] = "NULL";
          }
          else {
            $values[] = "'".$_link->real_escape_string($profile[$key])."'";
          }
        }
      }
      //新規作成
      if(empty($profile['id'])){
        $columns = implode(',',$columns).",`registration_datetime`";
        $values = implode(',',$values).",NULL";
        $sql = "INSERT INTO `profile` ($columns) VALUES ($values)";

        if($res = $_link->query($sql)) {
            if($_link->affected_rows == 1) {
                $sqlFlg = TRUE;
            }
        }
      }else {
        $updateSet = array();
        foreach ($columns as $key => $value) {
          echo $value;
            if ($value != "`id`") {
                $updateSet[] = "$value={$values[$key]}";
            }
            //delete
            if ($value == "`status`") {
                $updateSet[] = "`profile_status`=0";
            }
        }
        $updateSet = implode(",",$updateSet);
        $sql = "UPDATE `profile` SET $updateSet,`update_datetime`=NOW() WHERE `id`= {$profile['id']}";

        if ($res = $_link->query($sql)) {
            if ($_link->affected_rows == 1) {
                $sqlFlg = TRUE;
            }
        }
      }

    }

    if($sqlFlg){
        $_link->commit();
        $_SESSION['confirmMsg'] ="記事登録完了しました。";
        header('location:./atorie.php');
    }else {
        $_link->rollback();
    }
}

require_once("./profileWriting.tpl.php");
?>
