<?php
include("./header.php");
?>
<?php
include('./function/sqlconn.php')
?>
<?php
$cate = "all";
$brd = "all";

if (!empty($_GET)) {
  $cate = $_GET['cate'];
  $brd = $_GET['brd'];
}

?>
<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0 pl-0 pr-0 pb-0" style="background: white;">
      <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
      <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
    </ol>
  </nav>
  <div class="row mt-2">
    <div class="col-md-3  pl-0 pr-0 d-none d-md-block">
      <div class="col-12">
        <div class="list-group">
          <div class="list-group-item disabled mb-3 text-center text-dark" aria-disabled="true">--- Danh mục ---</div>
          <a href="prd.php?cate=all&brd=<?php echo $brd ?>" class="list-group-item list-group-item-action <?php echo ($cate == "all") ? " active" : "" ?>">
            Tất cả sản phẩm
          </a>
          <?php
          $query = "SELECT * FROM categories";
          $result = mysqli_query($conn, $query);
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
          ?>
              <a href="prd.php?cate=<?php echo $row['cate_slug'] ?>&brd=<?php echo $brd ?>" class="list-group-item list-group-item-action <?php echo ($cate == $row['cate_slug']) ? " active" : "" ?> "><?php echo $row['cate_name'] ?></a>
          <?php
            }
          }
          ?>
        </div>
      </div>
      <div class="col-12 mt-5">
        <div class="list-group">
          <div class="list-group-item disabled mb-3 text-center text-dark" aria-disabled="true">--- Thương hiệu ---</div>
          <a href="prd.php?cate=<?php echo $cate ?>&brd=all" class="list-group-item list-group-item-action <?php echo ($brd == "all") ? " active" : "" ?>">
            Tất cả thương hiệu
          </a>
          <?php
          $query = "SELECT * FROM brands";
          $result = mysqli_query($conn, $query);
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
          ?>
              <a href="prd.php?cate=<?php echo $cate ?>&brd=<?php echo $row['brd_slug'] ?>" class="list-group-item list-group-item-action <?php echo ($brd == $row['brd_slug']) ? " active" : "" ?> "><?php echo $row['brd_name'] ?></a>
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
          <?php
          $query = "SELECT * FROM products";
          if ($cate == "all" && $brd == "all") {
            $query = "SELECT * FROM products";
          }
          if ($cate != "all" && $brd == "all") {
            $query = "SELECT * FROM products WHERE prd_cate = '$cate' ";
          }
          if ($cate == "all" && $brd != "all") {
            $query = "SELECT * FROM products WHERE prd_brand = '$brd'";
          }
          if ($cate != "all" && $brd != "all") {
            $query = "SELECT * FROM products WHERE prd_brand = '$brd' AND prd_cate = '$cate'";
          }

          $result = mysqli_query($conn, $query);
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
          ?>
              <div class="col-xs-12 col-sm-6 col-lg-4 mt-3 ">
                <div class="card">
                  <a class="d-block" href="prd_detail.php?target=<?php echo $row['prd_id'] ?>" style="position: relative;width: 100%;padding-top:75%;">
                    <img style=" position:absolute;top: 0;left: 0;bottom: 0;right: 0;height: 100%; width: 100%;object-fit:cover;" class="card-img-top d-block img-fluid" src="./data/upload/img/<?php echo $row['prd_id'] ?>" alt="prd_image">
                  </a>
                  <div class="card-body pl-1 pr-1 pt-0 pb-1">
                    <a class="d-block " style=" height:38px;width:100%;" href="prd_detail.php?target=<?php echo $row['prd_id'] ?>">
                      <h6 class="card-title mt-2 mb-0 text-overfl-2line"><?php echo $row['prd_name'] ?></h6>
                    </a>
                    <div class=" mb-1 mt-1">
                      <?php
                      if ($row['prd_priceSaled'] == 0) {
                      ?>
                        <span class="text-danger" style="font-weight:600;font-size:15px;">₫<?php echo number_format($row["prd_price"], '0', '3', '.') ?></span>
                      <?php
                      } else {
                      ?>
                        <span class="text-danger" style="font-weight:600;font-size:15px;">₫<?php echo number_format($row["prd_priceSaled"], '0', '3', '.') ?></span>
                        <span class="text-muted" style="font-size:12px;"><del>₫<?php echo number_format($row["prd_price"], '0', '3', '.') ?></del></span>
                      <?php
                      }
                      ?>
                    </div>
                    <div class="d-flex flex-column pt-1 ">
                      <a href="prd_detail.php?target=<?php echo $row['prd_id'] ?>" class="btn btn-primary">Chi tiết</a>
                    </div>
                  </div>
                </div>
              </div>
          <?php
            }
            mysqli_close($conn);
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include("./footer.php");
?>