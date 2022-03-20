<?php
require_once("./mysql.php");

if(!empty($_POST['search']) || !empty($_GET['search'])){
  $search = (isset($_POST['search']))? $_POST['search']:$_GET['search'];

    $sql = "SELECT `id`,`category`,`title`,`public_datetime`,`img`
            FROM `post`
            WHERE `status`IN(1,2)
            AND (`title` LIKE '%{$search}%' OR `text` LIKE '%{$search}%')
            ORDER BY `public_datetime` DESC";
    if ($res = $_link->query($sql)) {
        if ($res->num_rows != 0) {
            while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
                    $row['public_datetime'] = substr(str_replace("-", "/",$row['public_datetime']),0,10);

                    if ($row['category'] == 2) {
                        $blog[] = $row;
                    }
                    elseif ($row['category'] == 1) {
                        $info[] = $row;
                    }
            }
        }
        $blogCnt = count($blog);
        $infoCnt = count($info);
    }
}

//削除されたファイル探して空く
for ($i=0; $i < $blogCnt; $i++) {
  $file = file_exists('../common/media/blog/'.$blog[$i]['img']);
  if (!$file) {
    $blog[$i]['img'] = "";
  }
}
require_once("./search.tpl.php");
?>
