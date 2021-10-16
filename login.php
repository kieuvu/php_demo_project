<?php
include('./header.php');

if (!empty($_SESSION['loginData'])) {
  echo "<script>window.top.location='index.php';</script>";
}


include('./function/sqlconn.php');
?>
<?php
$userAccount = "";
$userPass = "";
$err = [];

if (!empty($_POST)) {
  $userAccount = $_POST['userAccount'];
  $userPass = $_POST['userPass'];

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
      mysqli_close($conn);
      echo "<script>window.top.location='index.php';</script>";
    }
  }
}
?>
<div id="main_login">
  <div class="container">
    <div class="logForm">
      <div class="login log_logo">
        <img src="./assets/img/user.png" alt="">
      </div>
      <span class="log_heading text-dark mb-3">ĐĂNG NHẬP</span>
      <form action="" method="POST">
        <div class="form-group">
          <label for="userAccount">Tài khoản:</label>
          <span class="text-danger"><?php echo (!empty($err['userAccount'])) ? $err['userAccount'] : "" ?></span>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default userAccount">Nhập tài khoản</span>
            </div>
            <input value="<?php echo $userAccount ?>" name="userAccount" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
          </div>
        </div>
        <div class="form-group">
          <label for="userPassword">Mật khẩu:</label>
          <span class="text-danger"><?php echo (!empty($err['userPass'])) ? $err['userPass'] : "" ?></span>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default userPassword">Nhập mật khẩu</span>
            </div>
            <input name="userPass" type="password" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
          </div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <a href="">Chưa có tài khoản</a>
          <a href="">Quên mật khẩu</a>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Đăng nhập</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
include('./footer.php')
?>