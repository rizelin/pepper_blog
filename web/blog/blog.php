<?php
require_once("../require/mysql.php");

  if (isset($_GET['id'])) {
    $sql = "SELECT `title`,`text`,`img`,`public_datetime` FROM `post` WHERE `id` = {$_GET['id']} AND `category` = 2";
    if ($res = $_link->query($sql)) {
        while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
            $row['public_datetime'] = substr(str_replace("-", "/", $row['public_datetime']),0,10);
            $blog = $row;
        }
    }
    $blog['public_datetime'] = substr($blog['public_datetime'],0,10);
    $blog['img'] = explode(",",$blog['img']);

  }

require_once("blog.tpl.php");
?>
