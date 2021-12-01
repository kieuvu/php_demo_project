<?php
include("./header.php");

if ($_SESSION['loginData']['userPerm'] != 1) {
  echo "<script>window.top.location='index.php';</script>";
}

include("./function/sqlconn.php");
?>


<div class="container">
  <div class="text-right mt-3 mb-3">
    <u><a href="./prd_add.php" class="">Thêm sản phẩm</a></a></u>
  </div>
  <div id="admin_getCateBrand" class="mb-2">
    <label for="admin_getCate">Danh mục: </label>
    <select id="admin_getCate"></select>
    <span class="d-inline-block" style="width: 10px;"></span>
    <label for="admin_getBrand">Thương hiệu: </label>
    <select id="admin_getBrand"></select>
  </div>
  <div id="prbmngTable">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Tên</th>
          <th scope="col">Giá</th>
          <th scope="col">Số lượng</th>
          <th scope="col">Loại</th>
          <th scope="col">Thương hiệu</th>
          <th scope="col">Ảnh</th>
          <th scope="col">Hành động</th>
        </tr>
      </thead>
      <tbody>
        <!-- Product Will Be Rendered Here -->
      </tbody>
    </table>
  </div>
  <div id="pagi">
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
      </ul>
    </nav>
  </div>
</div>

<div class="modal fade" id="deleteBTN" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cảnh báo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Có chắc chắn muốn xoá
      </div>
      <div class="modal-footer">
        <button id="deleteAcceptBTN" type="button" class="btn btn-danger text-white">Xoá</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Huỷ</button>
      </div>
    </div>
  </div>
</div>

<script src="./assets/js/productManage.js"></script>

<?php
include("./footer.php");
?>