<?php
if(isset($_SESSION['user'])){
  $sql = "SELECT `user_id`,`password` FROM `manager`
          where `user_id`='{$_SESSION['user']['user_id']}' and `password`='{$_SESSION['user']['password']}'";
  if($res = $_link->query($sql)){
    //행수를 알아내는 태그 num_rows
    if($res->num_rows == 1){
      while($row = $res->fetch_array(MYSQLI_ASSOC)){
        $user = $row;
      }
    }
  }
}
if(!isset($user)){
  header("Location:../index.php?logout");
  exit();
}
 ?>
