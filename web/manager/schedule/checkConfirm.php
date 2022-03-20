<?php
require_once("../../require/mysql.php");
require_once("../require/login.php");

/*
checkInquiryBoard.phpから状態変更
ajaxから値をもらってechoで値を送る(successのresult)
*/
if (isset($_POST['confirm'])) {
  $id = $_POST['confirm'];
  $sql = "UPDATE `inquiry` SET `response_datetime`= NOW(),`checked`= 2 WHERE `id`= {$id}";
  if ($res = $_link->query($sql)) {
      if ($_link->affected_rows == 1) {
          echo "確定完了<br>".date("Y/m/d H:m");
      }
  }
}

if (isset($_POST['cancel'])) {
    $id = $_POST['cancel'];
    $sql = "UPDATE `inquiry` SET `response_datetime`= NOW(),`checked`= 3 WHERE `id`= {$id}";
    if ($res = $_link->query($sql)) {
        if ($_link->affected_rows == 1) {
            echo "キャンセル完了<br>".date("Y/m/d H:m");
        }
    }
}

?>
