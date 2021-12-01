<?php
include("./function/sqlconn.php");
include("./function/stringfn.php");

$err = [];
$stt = false;

if (!empty($_POST)) {
  $userAccount = $_POST['userAccount'];
  $userPass = $_POST['userPass'];
  $userRePass = $_POST['userRePass'];

  if (empty($userAccount)) {
    $err['userAccount'] = "*Chưa nhập tài khoản.";
  } else {
    if (strlen($userAccount) < 8) {
      $err['userAccount'] = "*Tên tài khoản phải trên 8 ký tự.";
    } else {
      $query = "SELECT *  FROM users WHERE userAccount LIKE '$userAccount'";
      $result = mysqli_query($conn, $query);
      if (mysqli_num_rows($result) > 0) {
        $err['userAccount'] = "*Tên tài khoản đã có người sử dụng.";
      }
    }
  }

  if (empty($userPass)) {
    $err['userPass'] = "*Chưa nhập mật khẩu.";
  } else {
    if (strlen($userPass) < 8) {
      $err['userAccount'] = "*Mật khẩu phải trên 8 ký tự.";
    } else {
      if ($userPass != $userRePass) {
        $err['userPass'] = "*Mật khẩu nhập lại không khớp.";
      }
    }
  }

  if (empty($err)) {
    $userId = randomName(10);
    $userPass = password_hash($userPass, PASSWORD_DEFAULT);
    $query = "INSERT INTO users( userAccount, userPass  ,userCreatedAt ) VALUES('$userAccount','$userPass',now())";
    if (mysqli_query($conn, $query)) {
      $stt = true;
      mysqli_close($conn);
    }
  }

  $finalResult = array(
    "err" => $err,
    "stt" => $stt
  );
  echo json_encode($finalResult);
}
