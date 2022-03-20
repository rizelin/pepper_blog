<?php
require_once("../require/mysql.php");

$sql = "SELECT `text`,`img` FROM `profile` WHERE `profile_status`=1";
if ($res = $_link->query($sql)) {
  while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
    $profile = $row;
  }
}

require_once("atorie.tpl.php");
 ?>
