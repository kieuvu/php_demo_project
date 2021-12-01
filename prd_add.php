<?php
include("./header.php");

if ($_SESSION['loginData']['userPerm'] != 1) {
  echo "<script>window.top.location='index.php';</script>";
}

?>

<?php
include("./function/sqlconn.php");
include("./function/stringfn.php");
?>

<!-- UI -->

<div class="container">
  <div class="text-right mt-3">
    <u><a href="./prd_manage.php" class="">Quản lí sản phẩm</a></u>
  </div>
  <div class="row">
    <!--Form Thêm sản phẩm -->
    <div class="col-md-8 mt-3 order-md-2">
      <span style="font-size: 25px; font-weight:bold;" class="d-block text-center text-secondary mb-4">THÊM SẢN PHẨM</span>
      <form enctype="multipart/form-data" id="add_prdForm">
        <!-- Tên sản phẩm -->
        <div>
          <label id="name" for="prd_name">1. Tên sản phẩm:</label>
          <div class="input-group mb-3 ">
            <div class="input-group-prepend ">
              <span class="input-group-text" id="inputGroup-sizing-default">Tên</span>
            </div>
            <input value="" id="prd_name" name="prd_name" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
          </div>
        </div>
        <div class="row">
          <!-- Giá sản phẩm -->
          <div class="col-6">
            <label id="price" for="prd_price">2. Giá sản phẩm:</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Giá</span>
              </div>
              <input value="" id="prd_price" name="prd_price" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
            </div>
          </div>
          <!-- Số lượng -->
          <div class=" col-6 ">
            <label for="prd_quantity">3. Số lượng:</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Số lượng</span>
              </div>
              <input min="0" id="prd_quantity" name="prd_quantity" type="number" class="form-control" aria-label="Default" value="0" aria-describedby="inputGroup-sizing-default">
            </div>
          </div>
        </div>
        <!-- Mô tả sản phẩm -->
        <div class="form-group">
          <label id="desc" for="prd_desc">4. Mô tả sản phẩm: </label>
          <textarea id="prd_desc" name="prd_desc" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <div class="row">
          <!--Chọn Danh mục -->
          <div class=" col-6 ">
            <label id="cate" for="prd_category">5. Danh mục:</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <label class="input-group-text" for="prd_category">Danh mục</label>
              </div>
              <select class="custom-select" id="prd_category" name="prd_cate">
                <!-- Render all cate choosen here -->
              </select>
            </div>
          </div>
          <!--Chọn Thương hiệu -->
          <div class="col-6">
            <label id="brand" for="prd_brand">6. Thương hiệu:</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <label class="input-group-text" for="prd_brand">Thương hiệu</label>
              </div>
              <select class="custom-select" name="prd_brand" id="prd_brand">
                <!-- Render all brand choosen here -->
              </select>
            </div>
          </div>
        </div>
        <!-- IMG Choosing -->
        <div class="row">
          <!-- Ảnh đại diện -->
          <div class="col-6">
            <div class="form-group">
              <label id="img1" for="prd_stImg">7. Ảnh đại diện:</label>
              <input type="file" class="form-control-file" id="prd_stImg" name="prd_stImg">
            </div>
            <div id="img_preview1">
              <img class="mt-3 img-thumbnail" alt="" id="img_preview-img1" style="object-fit: cover;height:100px;width:100px;">
            </div>
          </div>
          <!-- Ảnh liên quan 1 -->
          <div class="col-6">
            <div class="form-group">
              <label id="img2" for="prd_ndImg">8. Ảnh liên quan 1:</label>
              <input type="file" class="form-control-file" id="prd_ndImg" name="prd_ndImg">
            </div>
            <div id="img_preview2">
              <img class="mt-3 img-thumbnail" alt="" id="img_preview-img2" style="object-fit: cover;height:100px;width:100px;">
            </div>
          </div>
          <!-- Ảnh liên quan 2 -->
          <div class="col-6">
            <div class="form-group">
              <label id="img3" for="prd_rdImg">9. Ảnh liên quan 2:</label>
              <input type="file" class="form-control-file" id="prd_rdImg" name="prd_rdImg">
            </div>
            <div id="img_preview3">
              <img class="mt-3 img-thumbnail" alt="" id="img_preview-img3" style="object-fit: cover;height:100px;width:100px;">
            </div>
          </div>
          <!-- Ảnh liên quan 3 -->
          <div class="col-6">
            <div class="form-group">
              <label id="img4" for="prd_thImg">10. Ảnh liên quan 3:</label>
              <input type="file" class="form-control-file" id="prd_thImg" name="prd_thImg">
            </div>
            <div id="img_preview4">
              <img class="mt-3 img-thumbnail" alt="" id="img_preview-img4" style="object-fit: cover;height:100px;width:100px;">
            </div>
          </div>
        </div>
        <!-- Submit Form -->
        <div class="mt-3 mb-3">
          <button id="add_prd" type="submit" class="btn btn-primary w-100">Thêm sản phẩm</button>
        </div>
      </form>
    </div>

    <!-- Hiển thị/Thêm/Sửa Danh mục, Thương hiệu -->
    <div class="col-md-4 mt-3 order-md-1">
      <span style="font-size: 25px; font-weight:bold;" class="d-block text-center text-secondary mb-4">DANH MỤC
      </span>
      <!-- Thêm/Sửa danh mục -->
      <div id="add_category">
        <form>
          <div class="form-group">
            <label for="prd_add_cate">1. Thêm danh mục:</label>
            <input type="text" class="form-control" id="prd_add_cate">
          </div>
          <button type="submit" id="add_cate" class="btn btn-primary w-100">Thêm</button>
        </form>
        <div class="cate_list">
          <span class="mt-2 mb-2 d-block">Danh sách danh mục: </span>
          <div style="max-height:309px;overflow-y:scroll;">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Tên</th>
                  <th scope="col">Hành động</th>
                </tr>
              </thead>
              <tbody>
                <!-- Data will be display here -->
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Thêm/Sửa thương hiệu -->
      <div id="add_brand">
        <form class="mt-4">
          <div class="form-group">
            <label for="prd_add_brand" class="mt-4">2. Thêm thương hiệu:</label>
            <input type="text" class="form-control" id="prd_add_brand">
          </div>
          <button type="submit" id="add_brd" class="btn btn-primary w-100">Thêm</button>
        </form>
        <div class="brand_list">
          <span class="mt-2 mb-2 d-block">Danh sách thương hiệu: </span>
          <div style="max-height:309px;overflow-y:scroll;">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Tên</th>
                  <th scope="col">Hành động</th>
                </tr>
              </thead>
              <tbody>
                <!-- Data will be display here -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Confirm Cate Delete Modal -->
<div class="modal fade" id="deleteCate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cảnh báo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Có chắc chắn muốn xoá danh mục này ?
      </div>
      <div class="modal-footer">
        <button id="deleteCateBTN" type="button" class="btn btn-danger text-white">Xoá</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Huỷ</button>
      </div>
    </div>
  </div>
</div>

<!-- Confirm Brand Delete Modal -->
<div class="modal fade" id="deleteBrand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cảnh báo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Có chắc chắn muốn xoá
      </div>
      <div class="modal-footer">
        <button id="deleteBrandBTN" type="button" class="btn btn-danger text-white">Xoá</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Huỷ</button>
      </div>
    </div>
  </div>
</div>

<!-- CKEDITOR -->
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
<script src="./assets/js/addProduct.js"></script>
<?php
include("./footer.php")
?>