<?php
require_once("../require/mysql.php");

//paging
$page = isset($_GET['page'])? $_GET['page']:1;
$sql = "SELECT `id` FROM `post`
        WHERE `category`=2 AND `status` = 1 AND `public_datetime`< NOW() AND (`limit_datetime`='0000-00-00 00:00:00' OR `limit_datetime`> NOW())";
if ($res = $_link->query($sql)) {
    if ($res->num_rows != 0) {
        $totalData = $res->num_rows;
    }
}
$pageCount = 10;
$maxPage = ceil($totalData/$pageCount);
$startNum = ($page-1)*$pageCount;

//リスト読み込み
$sql = "SELECT `id`,`title`,`text`,`img`,`public_datetime`
        FROM `post`
        WHERE `category`=2 AND `status`=1 AND `public_datetime`< NOW() AND (`limit_datetime`='0000-00-00 00:00:00' OR `limit_datetime`> NOW())
        ORDER BY `public_datetime` DESC
        LIMIT {$startNum},{$pageCount}" ;
if ($res = $_link->query($sql)) {
    if ($res->num_rows != 0) {
      while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
          $row['public_datetime'] = substr(str_replace("-", "/", $row['public_datetime']),0,10);
          $row['text'] = mb_substr($row['text'],0,100,"utf-8")."...";
          $row['img'] = explode(",",$row['img']);
          $row['img'] = $row['img'][0];
          $blogList[] = $row;
      }
      $count = count($blogList);
    }

}

//削除されたファイル探して空く
for ($i=0; $i < $count; $i++) {
  $file = file_exists('../common/media/blog/'.$blogList[$i]['img']);
  if (!$file) {
    $blogList[$i]['img'] = "";
  }
}

require_once("blogBoard.tpl.php");
?>
