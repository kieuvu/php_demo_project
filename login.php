<?php
include('./header.php');

if (!empty($_SESSION['loginData'])) {
  echo "<script>window.top.location='index.php';</script>";
}

include('./function/sqlconn.php');
?>

<div id="main_login">
  <div class="container">
    <div class="logForm">
      <div class="login log_logo">
        <img src="./assets/img/user.png" alt="">
      </div>
      <span class="log_heading text-dark mb-3">ĐĂNG NHẬP</span>
      <form>
        <div class="form-group">
          <label for="account" id="userAccount">Tài khoản:</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default">Nhập tài khoản</span>
            </div>
            <input id="account" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
          </div>
        </div>
        <div class="form-group">
          <label for="password" id="userPassword">Mật khẩu:</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default">Nhập mật khẩu</span>
            </div>
            <input type="password" id="password" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
          </div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <a href="./registry.php">Chưa có tài khoản</a>
          <a href="">Quên mật khẩu</a>
        </div>
        <div class="text-center">
          <button type="submit" id="loginSubmit" class="btn btn-primary">Đăng nhập</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="./assets/js/login.js"></script>

<?php
include('./footer.php')
?>