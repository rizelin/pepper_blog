<?php
require_once("../../require/mysql.php");
require_once("../require/login.php");
//paging
$page = isset($_GET['page'])? $_GET['page']:1;
$sql = "SELECT `id` FROM `post`
        WHERE `category`=2 AND `status` IN(1,2)";
if ($res = $_link->query($sql)) {
    if ($res->num_rows != 0) {
        $totalData = $res->num_rows;
    }
}
$pageCount = 10;
$maxPage = ceil($totalData/$pageCount);
$startNum = ($page-1)*$pageCount;

//リスト読み込み
$sql = "SELECT `id`,`title`,`img`,`registration_datetime`,`public_datetime`,`limit_datetime`,`status`
        FROM `post`
        WHERE `category`=2 AND `status`IN(1,2)
        ORDER BY `registration_datetime` DESC
        LIMIT {$startNum},{$pageCount}" ;
if ($res = $_link->query($sql)) {
    if ($res->num_rows != 0) {
      while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
          $row['img'] = explode(",",$row['img']);
          $row['img'] = $row['img'][0];
          $blogList[] = $row;
      }
      $count = count($blogList);
    }
}

require_once("blogBoard.tpl.php");
?>
