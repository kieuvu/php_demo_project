<?php
include("./header.php");
?>
<?php
include('./function/sqlconn.php');
?>

<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0 pl-0 pr-0 pb-0" style="background: white;">
      <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
      <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
    </ol>
  </nav>
  <div class="row mt-2">
    <div class="col-md-3 pl-0 pr-0 d-none d-md-block">
      <div class="col-12">
        <div class="list-group">
          <div class="list-group-item disabled mb-3 text-center text-dark" aria-disabled="true">--- Danh mục ---</div>
          <a href="" data-slug="all" class="list-group-item list-group-item-action active cate-item">Tất cả sản phẩm</a>
          <?php
          $query = "SELECT * FROM categories";
          $result = mysqli_query($conn, $query);
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
          ?>
              <a href="" data-slug="<?php echo $row['cate_slug'] ?>" class="list-group-item list-group-item-action cate-item"><?php echo $row['cate_name'] ?></a>
          <?php
            }
          }
          ?>
        </div>
      </div>
      <div class="col-12 mt-5">
        <div class="list-group">
          <div class="list-group-item disabled mb-3 text-center text-dark" aria-disabled="true">--- Thương hiệu ---</div>
          <a href="" data-slug="all" class="list-group-item list-group-item-action brand-item active">Tất cả thương hiệu</a>
          <?php
          $query = "SELECT * FROM brands";
          $result = mysqli_query($conn, $query);
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
          ?>
              <a href="" data-slug="<?php echo $row['brd_slug'] ?>" class="list-group-item list-group-item-action brand-item"><?php echo $row['brd_name'] ?></a>
          <?php
            }
          }
          ?>
        </div>
      </div>
    </div>
    <div class="col-md-9 col-12">
      <div class="list-group-item disabled  d-none d-md-block" aria-disabled="true">Sản phẩm</div>
      <div id="product_show">
        <div class="row">
        </div>
      </div>
      <div id="pagi" class="mt-5">
        <nav aria-label="Page navigation">
          <ul class="pagination justify-content-center">
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>
<script src="./assets/js/allProduct.js"></script>
<?php
include("./footer.php");
?>