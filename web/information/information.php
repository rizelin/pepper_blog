<?php
require_once("../require/mysql.php");

  if (isset($_GET['id'])) {
    $sql = "SELECT `title`,`text`,`img`,`public_datetime` FROM `post` WHERE `id` = {$_GET['id']} AND `category` = 1";
    if ($res = $_link->query($sql)) {
        while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
            $row['public_datetime'] = substr(str_replace("-", "/", $row['public_datetime']),0,10);
            $info = $row;
        }
    }
    $info['public_datetime'] = substr($info['public_datetime'],0,10);


  //削除されたファイル探して空く
    $file = file_exists('../common/media/information/'.$info['img']);
    if (!$file) {
        $info['img'] = "";
    }
  }

require_once("information.tpl.php");
?>
