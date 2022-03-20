<?php
require_once("../../require/mysql.php");
require_once("../require/login.php");

//全体項目
$sql = "SELECT `id`,`title` FROM `profile` WHERE `status` != 1";
  if ($res = $_link->query($sql)) {
      while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
        $profiles[] = $row;
      }
      $count = count($profiles);
  }

/*選択した記事
if (isset($_GET['profile_id'])) {
  $fixedId = $_GET['profile_id'];
  $profile = "WHERE `id`={$fixedId}";
  $sql = "UPDATE `profile` SET `profile_status` = 0 WHERE `status` != 1 AND `profile_status` = 1";
  if ($res = $_link->query($sql)) {
      $sql = "UPDATE `profile` SET `profile_status` = 1 WHERE `id` = '{$fixedId}'";
      if ($res = $_link->query($sql)) {
          $_link->commit();
      }
  }
}

$sql = "SELECT `id`,`text`,`img` FROM `profile`WHERE `profile_status` = 1";
if ($res = $_link->query($sql)) {
  while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
      $fixed = $row;
  }
}
*/

//固定
if (isset($_POST['fix_id'])) {
  $fixedId = $_POST['fix_id'];

  if (empty($fixedId)) {
        $notice = "固定する記事を選択してください。";
  }else{
      $sql = "UPDATE `profile` SET `profile_status` = 0 WHERE `profile_status` = 1";
      if ($res = $_link->query($sql)) {
          $sql = "UPDATE `profile` SET `profile_status` = 1 WHERE `id` = {$fixedId}";
          if ($res = $_link->query($sql)) {
              $_link->commit();
              $notice = "固定されました。";
          }
      }
  }
}

//選択した記事検索
if (isset($_GET['profile_id'])) {
  $searchId = $_GET['profile_id'];
  $where = "`id`={$searchId}";
}else {
  $where = "`profile_status` = 1";
}

$sql = "SELECT `id`,`text`,`img` FROM `profile`WHERE {$where}";
  if ($res = $_link->query($sql)) {
    while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
      $fixed = $row;
    }
  }

if (!isset($fixed)) {
  $fixed['text'] = "紹介リストから適用させる記事を検索したあと固定してください。";
}

require_once("atorie.tpl.php");
 ?>
