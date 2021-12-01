<?php
include('./header.php');

if (!empty($_SESSION['loginData'])) {
  echo "<script>window.top.location='index.php';</script>";
}

include("./function/sqlconn.php");
?>
<div id="main_registry">
  <div class="container">
    <div class="logForm">
      <div class="registry log_logo">
        <img src="./assets/img/user.png" alt="">
      </div>
      <span class="log_heading text-dark mb-3">ĐĂNG KÝ</span>
      <form>
        <div class="form-group">
          <label for="account" id="userAccount">Tài khoản:</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default ">Nhập tài khoản</span>
            </div>
            <input id="account" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
          </div>
        </div>
        <div class="form-group">
          <label for="password" id="userPassword">Mật khẩu:</label>
          <div class=" input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default">Nhập mật khẩu</span>
            </div>
            <input id="password" type="password" autocomplete="new-password" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
          </div>
        </div>
        <div class="form-group">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default rePass">Nhập lại mật khẩu</span>
            </div>
            <input id="rePass" type="password" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
          </div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <a href="">Đã có tài khoản</a>
          <a href="">Quên mật khẩu</a>
        </div>
        <div class="text-center">
          <button type="submit" id="reg_submit" class="btn btn-primary">Đăng ký</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="regSucc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Đăng kí thành công</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="mt-2 mb-2">Bạn có muốn chuyển hướng tới trang đăng nhập ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Không</button>
        <a type="button" href="./login.php" class="btn btn-primary text-white">Đăng nhập</a>
      </div>
    </div>
  </div>
</div>
<script src="./assets/js/registry.js"></script>
<?php
include('./footer.php')
?>