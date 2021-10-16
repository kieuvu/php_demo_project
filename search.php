<?php
include('./header.php');
include("./function/sqlconn.php");
?>

<?php
$target = "";
if (isset($_GET['search'])) {
  $target = $_GET['search'];
  $query = "SELECT * FROM products WHERE prd_name LIKE '%$target%'";
  $result = mysqli_query($conn, $query);
  $resultQuantity = mysqli_num_rows($result);
}
?>

<div class="container">
  <span class="d-block mt-2 mb-2">Có <b><?php echo $resultQuantity ?> </b> sản phẩm trùng với từ khoá <b><?php echo $target ?></b>.</span>
  <div class="row">
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
      <div class="col-6 col-md-4 col-lg-3">
        <div class="card">
          <a class="d-block" href="prd_detail.php?target=<?php echo $row['prd_id'] ?>" style="position: relative;width: 100%;padding-top:75%;">
            <img style=" position:absolute;top: 0;left: 0;bottom: 0;right: 0;height: 100%; width: 100%;object-fit:cover;" class="card-img-top d-block img-fluid" src="./data/upload/img/<?php echo $row['prd_id'] ?>" alt="prd_image">
          </a>
          <div class="card-body pl-1 pr-1 pt-0 pb-1">
            <a class="d-block " style=" height:38px;" href="prd_detail.php?target=<?php echo $row['prd_id'] ?>">
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
    ?>
  </div>
</div>
<?php
include("./footer.php");
?>