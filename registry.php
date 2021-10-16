<?php
include('./header.php');

if (!empty($_SESSION['loginData'])) {
  echo "<script>window.top.location='index.php';</script>";
}

include("./function/sqlconn.php");
?>
<?php
$userAccount = "";
$userPass = "";
$userRePass = "";
$err = [];

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
      $userAccount = "";
      $userPass = "";
      $userRePass = "";
      mysqli_close($conn);
      echo "<script>window.top.location='login.php';</script>";
    }
  }
}


?>
<div id="main_registry">
  <div class="container">
    <div class="logForm">
      <div class="registry log_logo">
        <img src="./assets/img/user.png" alt="">
      </div>
      <span class="log_heading text-dark mb-3">ĐĂNG KÝ</span>
      <form action="" method="POST">
        <div class="form-group">
          <label for="userAccount">Tài khoản:</label>
          <span class="text-danger"><?php echo (!empty($err['userAccount'])) ? $err['userAccount'] : "" ?></span>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default userAccount">Nhập tài khoản</span>
            </div>
            <input type="text" value="<?php echo $userAccount ?>" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="userAccount">
          </div>
        </div>
        <div class="form-group">
          <label for="userPassword">Mật khẩu:</label>
          <span class="text-danger"><?php echo (!empty($err['userPass'])) ? $err['userPass'] : "" ?></span>
          <div class=" input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default userPassword">Nhập mật khẩu</span>
            </div>
            <input type="password" autocomplete="new-password" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="userPass">
          </div>
        </div>
        <div class="form-group">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default userRePass">Nhập lại mật khẩu</span>
            </div>
            <input type="password" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="userRePass">
          </div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <a href="">Đã có tài khoản</a>
          <a href="">Quên mật khẩu</a>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Đăng ký</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
include('./footer.php')
?>