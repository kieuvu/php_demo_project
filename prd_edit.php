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

?>
<div class="container">
  <span style="font-size: 25px; font-weight:bold;" class="d-block text-center text-secondary">SỬA SẢN PHẨM</span>
  <form id="edit_prdForm" enctype="multipart/form-data">
    <input type="text" name="target" readonly hidden value="<?php echo $target ?>">
    <!-- Tên sản phẩm -->
    <div>
      <label id="name" for="prd_name">1. Tên sản phẩm:</label>
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
        <label id="price" for="prd_price">2a. Giá sản phẩm:</label>
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
      <label id="desc" for="prd_desc">4. Mô tả sản phẩm: </label>
      <textarea id="prd_desc" name="prd_desc" class="form-control" id="exampleFormControlTextarea1" rows="3"><?php echo $prd_desc ?></textarea>
    </div>
    <div class="row">
      <!--Chọn Danh mục -->
      <div class=" col-6 ">
        <label id="category" for="prd_category">5. Danh mục:</label>
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
        <label id="brand" for="prd_brand">6. Thương hiệu:</label>
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
      <button type="submit" id="edit-submit" class="btn btn-primary w-100">Hoàn tất</button>
    </div>
  </form>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
<script src="./assets/js/editProduct.js"></script>

<?php
include("./footer.php")
?>