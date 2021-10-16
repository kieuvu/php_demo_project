<?php
include("./header.php");

if ($_SESSION['loginData']['userPerm'] != 1) {
  echo "<script>window.top.location='index.php';</script>";
}


include("./function/sqlconn.php");
?>

<?php
$target = "";
$prd_name = "";
$prd_price = "";
$prd_saled = "";
$prd_desc = "";
$prd_cate = "";
$prd_brand = "";
$prd_quantity = "";

if (!empty($_GET['target'])) {
  $target = $_GET['target'];

  $query = "SELECT * FROM products WHERE prd_id LIKE '$target'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);

  $prd_name = $row['prd_name'];
  $prd_price = $row['prd_price'];
  $prd_saled = $row['prd_priceSaled'];
  $prd_desc = $row['prd_desc'];
  $prd_cate = $row['prd_cate'];
  $prd_brand = $row['prd_brand'];
  $prd_quantity = $row['prd_quantity'];
}
if (!empty($_POST)) {

  $prd_name       = $_POST['prd_name'];
  $prd_price      = $_POST['prd_price'];
  $prd_quantity   = $_POST['prd_quantity'];
  $prd_saled      = $_POST['prd_priceSaled'];
  $prd_desc       = $_POST['prd_desc'];
  $prd_cate       = $_POST['prd_cate'];
  $prd_brand      = $_POST['prd_brand'];
  $prd_err        = [];

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

  if (empty($prd_err)) {
    $query = "UPDATE products SET prd_name='$prd_name',prd_price='$prd_price',prd_priceSaled='$prd_saled',prd_cate='$prd_cate',prd_brand='$prd_brand',prd_quantity='$prd_quantity',prd_desc='$prd_desc',prd_timeUpdated=now() WHERE prd_id ='$target' ";
    if (mysqli_query($conn, $query)) {
      if (isset($_FILES['prd_stImg'])) {
        move_uploaded_file($_FILES['prd_stImg']["tmp_name"], "./data/upload/img/" . $target);
      }
      if (isset($_FILES['prd_ndImg'])) {
        move_uploaded_file($_FILES['prd_ndImg']["tmp_name"], "./data/upload/img/" . $target . "_1");
      }
      if (isset($_FILES['prd_rdImg'])) {
        move_uploaded_file($_FILES['prd_rdImg']["tmp_name"], "./data/upload/img/" . $target . "_2");
      }
      if (isset($_FILES['prd_thImg'])) {
        move_uploaded_file($_FILES['prd_thImg']["tmp_name"], "./data/upload/img/" . $target . "_3");
      }
      mysqli_close($conn);
      echo "<script>window.top.location='prd_manage.php';</script>";
    }
  }
}
?>
<div class="container">
  <span style="font-size: 25px; font-weight:bold;" class="d-block text-center text-secondary">SỬA SẢN PHẨM</span>
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
      <div class="col-md-4">
        <label for="prd_price">2a. Giá sản phẩm:</label>
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
      <!-- Giá SALE -->
      <div class="col-md-4">
        <label for="prd_priceSaled">2b. Sale còn (Để 0 nếu không SALE):</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Giá</span>
          </div>
          <input value="<?php echo $prd_saled ?>" id=" prd_priceSaled" name="prd_priceSaled" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
        </div>
      </div>
      <!-- Số lượng -->
      <div class=" col-md-4 ">
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
            <option <?php echo ($prd_cate == 0) ? "selected" : "" ?> value="0"></option>
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
            <option <?php echo ($prd_brand == '0') ? "selected" : "" ?> value="0"></option>
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
          <input type="file" class="form-control-file" id="prd_stImg" name="prd_stImg">
        </div>
        <div id="img_preview1">
          <img src="./data/upload/img/<?php echo $row['prd_id'] ?>" class=" img-thumbnail" alt="" id="img_preview-img1" style="object-fit: cover;height:100px;width:100px;">
        </div>
      </div>
      <!-- Ảnh liên quan 1 -->
      <div class="col-6">
        <div class="form-group">
          <label for="prd_ndImg">8. Ảnh liên quan 1:</label>
          <input type="file" class="form-control-file" id="prd_ndImg" name="prd_ndImg">
        </div>
        <div id="img_preview2">
          <img src="./data/upload/img/<?php echo $row['prd_id'] ?>_1" class=" img-thumbnail" alt="" id="img_preview-img2" style="object-fit: cover;height:100px;width:100px;">
        </div>
      </div>
      <!-- Ảnh liên quan 2 -->
      <div class="col-6">
        <div class="form-group">
          <label for="prd_rdImg">9. Ảnh liên quan 2:</label>
          <input type="file" class="form-control-file" id="prd_rdImg" name="prd_rdImg">
        </div>
        <div id="img_preview3">
          <img src="./data/upload/img/<?php echo $row['prd_id'] ?>_2" class=" img-thumbnail" alt="" id="img_preview-img3" style="object-fit: cover;height:100px;width:100px;">
        </div>
      </div>
      <!-- Ảnh liên quan 3 -->
      <div class="col-6">
        <div class="form-group">
          <label for="prd_thImg">10. Ảnh liên quan 3:</label>
          <input type="file" class="form-control-file" id="prd_thImg" name="prd_thImg">
        </div>
        <div id="img_preview4">
          <img src="./data/upload/img/<?php echo $row['prd_id'] ?>_3" class=" img-thumbnail" alt="" id="img_preview-img4" style="object-fit: cover;height:100px;width:100px;">
        </div>
      </div>
    </div>
    <!-- Submit Form -->
    <div class="mt-3 mb-3">
      <button type="submit" class="btn btn-primary w-100">Hoàn tất</button>
    </div>
  </form>
</div>

<script>
  const imgFile1 = document.getElementById('prd_stImg');
  const previewContainer1 = document.getElementById('img_preview1');
  const imgPreview1 = document.getElementById("img_preview-img1");


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