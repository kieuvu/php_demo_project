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

<!-- Category Add Controller -->
<?php
$cate_name = "";
$cate_slug  = "";
$cate_err = [];
if (isset($_POST["prd_add_cate"])) {
  $cate_name = $_POST["prd_add_cate"];
  if (empty($cate_name)) {
    $cate_err['error'] = "*Nhập lại";
  } else {
    $query = "SELECT * FROM categories WHERE cate_name LIKE '$cate_name'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result)) {
      $cate_err['error'] = "*Danh mục đã tồn tại";
    }
  }
  if (empty($cate_err)) {
    $cate_slug = convert_name($cate_name);
    $query = "INSERT INTO categories(cate_name,cate_slug) VALUES('$cate_name','$cate_slug')";
    $result = mysqli_query($conn, $query);
    if ($result) {
      $cate_name = "";
      mysqli_close($conn);
      echo "<script>window.top.location='prd-add.php';</script>";
    }
  }
}
?>

<!-- Brand Add Controller -->
<?php
$brand_name = "";
$brand_err = [];
$brand_slug  = "";
if (isset($_POST["prd_add_brand"])) {
  $brand_name = $_POST["prd_add_brand"];
  if (empty($brand_name)) {
    $brand_err['error'] = "*Nhập lại";
  } else {
    $query = "SELECT * FROM brands WHERE brd_name LIKE '$brand_name'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result)) {
      $brand_err['error'] = "*Danh mục đã tồn tại";
    }
  }
  if (empty($brand_err)) {
    $brand_slug = convert_name($brand_name);
    $query = "INSERT INTO brands(brd_name,brd_slug) VALUES('$brand_name','$brand_slug')";
    $result = mysqli_query($conn, $query);
    if ($result) {
      $brand_name = "";
      mysqli_close($conn);
      echo "<script>window.top.location='prd-add.php';</script>";
    }
  }
}
?>

<!-- DELETE BRANDS & CATEGORIES CONTROLLER -->

<?php
if (isset($_GET['brandDeleteTarget']) || isset($_GET['cateDeleteTarget'])) {
  $query;
  $target;
  if (!empty($_GET['brandDeleteTarget'])) {
    $target = $_GET['brandDeleteTarget'];
    $query = "DELETE FROM brands WHERE id = $target; set @autoid :=0; UPDATE brands SET id = @autoid := (@autoid+1);ALTER TABLE brands Auto_Increment = 1; ";
  }
  if (!empty($_GET['cateDeleteTarget'])) {
    $target = $_GET['cateDeleteTarget'];
    $query = "DELETE FROM categories WHERE id = $target; set @autoid :=0; UPDATE categories SET id = @autoid := (@autoid+1);ALTER TABLE categories Auto_Increment = 1; ";
  }
  $result = mysqli_multi_query($conn, $query);
  if ($result) {
    mysqli_close($conn);
    echo "<script>window.top.location='prd-add.php';</script>";
  }
}
?>

<!-- Products ADD Controller -->
<?php
$prd_name       = "";
$prd_price      = "";
$prd_quantity   = 0;
$prd_desc       = "";
$prd_cate       = "";
$prd_brand      = "";
$prd_imgst      = "";
$prd_imgnd      = "";
$prd_imgrt      = "";
$prd_imgth      = "";

$prd_err = [];

if (!empty($_POST)) {
  $prd_name       = $_POST['prd_name'];
  $prd_price      = $_POST['prd_price'];
  $prd_quantity   = $_POST['prd_quantity'];
  $prd_desc       = $_POST['prd_desc'];
  $prd_cate       = $_POST['prd_cate'];
  $prd_brand      = $_POST['prd_brand'];
  $prd_imgst      = $_FILES['prd_stImg'];
  $prd_imgnd      = $_FILES['prd_ndImg'];
  $prd_imgrt      = $_FILES['prd_rdImg'];
  $prd_imgth      = $_FILES['prd_thImg'];
  $prd_id = "";

  if (empty($prd_name)) {
    $prd_err['name'] = "*Chưa nhập tên";
  }
  if (empty($prd_price)) {
    $prd_err['price'] = "*Chưa nhập giá";
  }
  if (empty($prd_desc)) {
    $prd_err['desc'] = "*Chưa nhập mô tả";
  }
  if ($prd_cate == "0") {
    $prd_err['cate'] = "*Chưa chọn danh mục";
  }
  if ($prd_brand == "0") {
    $prd_err['brand'] = "*Chưa chọn thương hiệu";
  }

  if (empty($prd_imgst['name'])) {
    $prd_err['img1'] = "*Chưa chọn ảnh";
  }
  if (empty($prd_imgnd['name'])) {
    $prd_err['img2'] = "*Chưa chọn ảnh";
  }
  if (empty($prd_imgrt['name'])) {
    $prd_err['img3'] = "*Chưa chọn ảnh";
  }
  if (empty($prd_imgth['name'])) {
    $prd_err['img4'] = "*Chưa chọn ảnh";
  }

  if (empty($prd_err)) {
    $prd_id = randomName(10);
    $query = "INSERT INTO products(prd_name,prd_price,prd_cate,prd_brand,prd_desc,prd_id,prd_quantity,prd_timeCreated) VALUES('$prd_name','$prd_price','$prd_cate','$prd_brand','$prd_desc','$prd_id','$prd_quantity',now())";
    $result = mysqli_query($conn, $query);
    if ($result) {
      move_uploaded_file($prd_imgst["tmp_name"], "./data/upload/img/" . $prd_id);
      move_uploaded_file($prd_imgnd["tmp_name"], "./data/upload/img/" . $prd_id . "_1");
      move_uploaded_file($prd_imgrt["tmp_name"], "./data/upload/img/" . $prd_id . "_2");
      move_uploaded_file($prd_imgth["tmp_name"], "./data/upload/img/" . $prd_id . "_3");
      mysqli_close($conn);
      echo "<script>window.top.location='prd-add.php';</script>";
    }
  }
}
?>

<!-- UI -->

<div class="container">
  <div class="text-right mt-3">
    <u><a href="./prd_manage.php" class="">Quản lí sản phẩm</a></u>
  </div>
  <div class="row">
    <!--Form Thêm sản phẩm -->
    <div class="col-md-8 mt-3 order-md-2">
      <span style="font-size: 25px; font-weight:bold;" class="d-block text-center text-secondary">THÊM SẢN PHẨM</span>
      <form method="POST" action="#" enctype="multipart/form-data">
        <!-- Tên sản phẩm -->
        <div>
          <label for="prd_name">1. Tên sản phẩm:</label>
          <span class="has-err text-danger">
            <?php echo (isset($prd_err['name'])) ?  $prd_err['name'] : "" ?>
          </span>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default">Tên</span>
            </div>
            <input value="<?php echo $prd_name ?>" id="prd_name" name="prd_name" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
          </div>
        </div>
        <div class="row">
          <!-- Giá sản phẩm -->
          <div class="col-6">
            <label for="prd_price">2. Giá sản phẩm:</label>
            <span class="has-err text-danger">
              <?php echo (isset($prd_err['price'])) ?  $prd_err['price'] : "" ?>
            </span>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Giá</span>
              </div>
              <input value="<?php echo $prd_price ?>" id=" prd_price" name="prd_price" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
            </div>
          </div>
          <!-- Số lượng -->
          <div class=" col-6 ">
            <label for="prd_quantity">3. Số lượng:</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Số lượng</span>
              </div>
              <input value="<?php echo $prd_quantity ?>" id="prd_quantity" name="prd_quantity" type="number" class="form-control" aria-label="Default" value="0" aria-describedby="inputGroup-sizing-default">
            </div>
          </div>
        </div>
        <!-- Mô tả sản phẩm -->
        <div class="form-group">
          <label for="prd_desc">4. Mô tả sản phẩm: </label>
          <span class="has-err text-danger">
            <?php echo (isset($prd_err['desc'])) ?  $prd_err['desc'] : "" ?>
          </span>
          <textarea id="prd_desc" name="prd_desc" class="form-control" id="exampleFormControlTextarea1" rows="3"><?php echo $prd_desc ?></textarea>
        </div>
        <div class="row">
          <!--Chọn Danh mục -->
          <div class=" col-6 ">
            <label for="prd_category">5. Danh mục:</label>
            <span class="has-err text-danger">
              <?php echo (isset($prd_err['cate'])) ?  $prd_err['cate'] : "" ?>
            </span>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <label class="input-group-text" for="prd_category">Danh mục</label>
              </div>
              <select class="custom-select" id="prd_category" name="prd_cate">
                <option <?php echo (empty($prd_brand)) ? "selected" : "" ?> value="0"></option>
                <?php
                $query = "SELECT * FROM categories";
                $sql = mysqli_query($conn, $query);
                if (mysqli_num_rows($sql) > 0) {
                  while ($result = mysqli_fetch_assoc($sql)) {
                ?>
                    <option <?php echo ($prd_cate == $result["cate_slug"]) ? "selected" : "" ?> value="<?php echo $result["cate_slug"] ?>"><?php echo $result["cate_name"] ?></option>
                <?php
                  }
                }
                ?>
              </select>
            </div>
          </div>
          <!--Chọn Thương hiệu -->
          <div class="col-6">
            <label for="prd_brand">6. Thương hiệu:</label>
            <span class="has-err text-danger">
              <?php echo (isset($prd_err['brand'])) ?  $prd_err['brand'] : "" ?>
            </span>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <label class="input-group-text" for="prd_brand">Thương hiệu</label>
              </div>
              <select class="custom-select" id="prd_brand" name="prd_brand">
                <option <?php echo (empty($prd_brand)) ? "selected" : "" ?> value="0"></option>
                <?php
                $query = "SELECT * FROM brands";
                $sql = mysqli_query($conn, $query);
                if (mysqli_num_rows($sql) > 0) {
                  while ($result = mysqli_fetch_assoc($sql)) {
                ?>
                    <option <?php echo ($prd_brand == $result["brd_slug"]) ? "selected" : "" ?> value="<?php echo $result["brd_slug"] ?>"><?php echo $result["brd_name"] ?></option>
                <?php
                  }
                }
                ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- Ảnh đại diện -->
          <div class="col-6">
            <div class="form-group">
              <label for="prd_stImg">7. Chọn ảnh đại diện:</label>
              <span class="has-err text-danger">
                <?php echo (isset($prd_err['img1'])) ?  $prd_err['img1'] : "" ?>
              </span>
              <input type="file" class="form-control-file" id="prd_stImg" name="prd_stImg">
            </div>
            <div id="img_preview1">
              <img class="mt-3 img-thumbnail" alt="" id="img_preview-img1" style="object-fit: cover;height:100px;width:100px;">
            </div>
          </div>
          <!-- Ảnh liên quan 1 -->
          <div class="col-6">
            <div class="form-group">
              <label for="prd_ndImg">8. Ảnh liên quan 1:</label>
              <span class="has-err text-danger">
                <?php echo (isset($prd_err['img2'])) ?  $prd_err['img2'] : "" ?>
              </span>
              <input type="file" class="form-control-file" id="prd_ndImg" name="prd_ndImg">
            </div>
            <div id="img_preview2">
              <img class="mt-3 img-thumbnail" alt="" id="img_preview-img2" style="object-fit: cover;height:100px;width:100px;">
            </div>
          </div>
          <!-- Ảnh liên quan 2 -->
          <div class="col-6">
            <div class="form-group">
              <label for="prd_rdImg">9. Ảnh liên quan 2:</label>
              <span class="has-err text-danger">
                <?php echo (isset($prd_err['img3'])) ?  $prd_err['img3'] : "" ?>
              </span>
              <input type="file" class="form-control-file" id="prd_rdImg" name="prd_rdImg">
            </div>
            <div id="img_preview3">
              <img class="mt-3 img-thumbnail" alt="" id="img_preview-img3" style="object-fit: cover;height:100px;width:100px;">
            </div>
          </div>
          <!-- Ảnh liên quan 3 -->
          <div class="col-6">
            <div class="form-group">
              <label for="prd_thImg">10. Ảnh liên quan 3:</label>
              <span class="has-err text-danger">
                <?php echo (isset($prd_err['img4'])) ?  $prd_err['img4'] : "" ?>
              </span>
              <input type="file" class="form-control-file" id="prd_thImg" name="prd_thImg">
            </div>
            <div id="img_preview4">
              <img class="mt-3 img-thumbnail" alt="" id="img_preview-img4" style="object-fit: cover;height:100px;width:100px;">
            </div>
          </div>
        </div>
        <!-- Submit Form -->
        <div class="mt-3 mb-3">
          <button type="submit" class="btn btn-primary w-100">Thêm sản phẩm</button>
        </div>
      </form>
    </div>
    <!-- Hiển thị/Thêm/Sửa Danh mục, Thương hiệu -->
    <div class="col-md-4 mt-3  order-md-1">
      <span style="font-size: 25px; font-weight:bold;" class="d-block text-center text-secondary">DANH MỤC
      </span>
      <!-- Thêm/Sửa danh mục -->
      <div id="add_category">
        <form action="#" method="POST">
          <div class="form-group">
            <label for="prd_add_cate">1. Thêm danh mục:</label>
            <span class="has-err text-danger">
              <?php echo (isset($cate_err['error'])) ?  $cate_err['error'] : "" ?>
            </span>
            <input type="text" name="prd_add_cate" class="form-control" value="<?php echo $cate_name ?>" id="prd_add_cate">
          </div>
          <button type="submit" class="btn btn-primary w-100">Thêm</button>
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
                <?php
                $query = "SELECT * FROM categories ORDER BY cate_slug ASC";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result)) {
                  $i = 1;
                  while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                      <th scope="row"><?php echo $i ?></th>
                      <td><?php echo $row["cate_name"] ?></td>
                      <td>
                        <a data-toggle="modal" data-target="#deleteCate" href="" data-id=<?php echo $row['id'] ?> class="btn btn-warning mt mb-1">Xoá</a>
                      </td>
                    </tr>
                <?php
                    $i++;
                  }
                } else {
                  echo "Không có kết quả.";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- Thêm/Sửa thương hiệu -->
      <div id="add_brand">
        <form action="#" method="POST" class="mt-3">
          <div class="form-group">
            <label for="prd_add_brand">2. Thêm thương hiệu:</label>
            <span class="has-err text-danger">
              <?php echo (isset($brand_err['error'])) ?  $brand_err['error'] : "" ?>
            </span>
            <input type="text" name="prd_add_brand" class="form-control" id="prd_add_brand">
          </div>
          <button type="submit" class="btn btn-primary w-100">Thêm</button>
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
                <?php
                $query = "SELECT * FROM brands ORDER BY brd_slug ASC";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result)) {
                  $i = 1;
                  while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                      <th scope="row"><?php echo $i ?></th>
                      <td><?php echo $row["brd_name"] ?></td>
                      <td>
                        <a data-toggle="modal" data-target="#deleteBrand" href="" data-id=<?php echo $row['id'] ?> class="btn btn-warning mt mb-1">Xoá</a>
                      </td>
                    </tr>
                <?php
                    $i++;
                  }
                } else {
                  echo "Không có kết quả.";
                }
                ?>
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
        <a id="deleteCateBTN" type="button" class="btn btn-danger text-white">Xoá</a>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Huỷ</button>
      </div>
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
        <a id="deleteBrandBTN" type="button" class="btn btn-danger text-white">Xoá</a>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Huỷ</button>
      </div>
    </div>
  </div>
</div>
</div>

<!-- CKEDITOR -->
<script src="https://cdn.ckeditor.com/ckeditor5/29.2.0/classic/ckeditor.js"></script>

<script>
  ClassicEditor
    .create(document.querySelector('#prd_desc'))
    .catch(error => {
      console.error(error);
    });
</script>

<!-- GET BRAND TARGET ID -->
<script>
  document.addEventListener('DOMContentLoaded', function() {

    var id;
    var deleteBrandBTN = document.getElementById('deleteBrandBTN');

    $('#deleteBrand').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      id = button.data('id');
      deleteBrandBTN.href = "prd-add.php?brandDeleteTarget=" + id;
    });
  });
</script>

<!-- GET BRAND TARGET ID -->
<script>
  document.addEventListener('DOMContentLoaded', function() {

    var id;
    var deleteBrandBTN = document.getElementById('deleteCateBTN');

    $('#deleteCate').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      id = button.data('id');
      deleteBrandBTN.href = "prd-add.php?cateDeleteTarget=" + id;
    });
  });
</script>

<!-- SHOW IMAGE WHEN CHOOSE -->
<script>
  const imgFile1 = document.getElementById('prd_stImg');
  const previewContainer1 = document.getElementById('img_preview1');
  const imgPreview1 = document.getElementById("img_preview-img1");

  previewContainer1.style.display = "none";

  imgFile1.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      previewContainer1.style.display = "block";
      imgPreview1.style.display = "block";
      reader.addEventListener('load', function() {
        imgPreview1.setAttribute('src', this.result);
      })
      reader.readAsDataURL(file);
    }
  })

  const imgFile2 = document.getElementById('prd_ndImg');
  const previewContainer2 = document.getElementById('img_preview2');
  const imgPreview2 = document.getElementById("img_preview-img2");

  previewContainer2.style.display = "none";

  imgFile2.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      previewContainer2.style.display = "block";
      imgPreview2.style.display = "block";
      reader.addEventListener('load', function() {
        imgPreview2.setAttribute('src', this.result);
      })
      reader.readAsDataURL(file);
    }
  })


  const imgFile3 = document.getElementById('prd_rdImg');
  const previewContainer3 = document.getElementById('img_preview3');
  const imgPreview3 = document.getElementById("img_preview-img3");

  previewContainer3.style.display = "none";

  imgFile3.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      previewContainer3.style.display = "block";
      imgPreview3.style.display = "block";
      reader.addEventListener('load', function() {
        imgPreview3.setAttribute('src', this.result);
      })
      reader.readAsDataURL(file);
    }
  })


  const imgFile4 = document.getElementById('prd_thImg');
  const previewContainer4 = document.getElementById('img_preview4');
  const imgPreview4 = document.getElementById("img_preview-img4");

  previewContainer4.style.display = "none";

  imgFile4.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      previewContainer4.style.display = "block";
      imgPreview4.style.display = "block";
      reader.addEventListener('load', function() {
        imgPreview4.setAttribute('src', this.result);
      })
      reader.readAsDataURL(file);
    }
  })
</script>
<?php
include("./footer.php")
?>