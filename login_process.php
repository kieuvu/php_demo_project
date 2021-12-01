<?php
session_start();
include('./function/sqlconn.php');

$err = [];
$stt = false;

if (!empty($_POST)) {
  $userAccount = $_POST['userAccount'];
  $userPass = $_POST['userPassword'];

  if (empty($userAccount)) {
    $err['userAccount'] = "*Chưa nhập tài khoản.";
  }
  if (empty($userPass)) {
    $err['userPass'] = "*Chưa nhập mật khẩu.";
  }

  if (!empty($userAccount) && !empty($userPass)) {
    $loginData = "";
    $query = "SELECT * FROM users WHERE userAccount LIKE '$userAccount'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
      $loginData = mysqli_fetch_assoc($result);
      $checkPass = password_verify($userPass, $loginData['userPass']);

      if (!$checkPass) {
        $err['userPass'] = "*Sai mật khẩu.";
      }
    } else {
      $err['userAccount'] = "*Tài khoản không tồn tại.";
    }

    if (empty($err)) {
      $_SESSION['loginData'] = $loginData;
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
