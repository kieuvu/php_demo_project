<?php
session_start();

include("./function/sqlconn.php");

if ($_SESSION['loginData']['userPerm'] != 1) {
  echo "<script>window.top.location='index.php';</script>";
}


$target = "";
if (isset($_GET['target'])) {
  $target = $_GET['target'];
  $query = "DELETE FROM products WHERE prd_id='$target'";
  if (mysqli_query($conn, $query)) {
    unlink("./data/upload/img/" . $target);
    unlink("./data/upload/img/" . $target . "_1");
    unlink("./data/upload/img/" . $target . "_2");
    unlink("./data/upload/img/" . $target . "_3");
    mysqli_close($conn);
    header('location: prd_manage.php');
  }
}
