<?php
ini_set('display_errors',1);
require_once("../require/mysql.php");

if (isset($_GET['logout'])) {
  unset($_SESSION['user']);
}
if (isset($_SESSION['user'])) {
  header("Location:./require/main.php");
  exit();
}

if (isset($_POST['id'])) {
  $password = $_POST['password'];
  $hashPw = hash('sha256',$password);

  $sql = "SELECT `user_id`,`password`
          FROM `manager`
          WHERE `user_id`='{$_POST['id']}' AND `password`='{$hashPw}'";
  if ($res = $_link->query($sql)) {
      if ($res->num_rows == 1) {
          while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
              $_SESSION['user'] = $row;
              header("Location:./require/main.php");
              exit();
          }
      }
  }
}


require_once("index.tpl.php");
?>
