<?php
include("./header.php")
?>
<?php
include('./function/sqlconn.php');
$prd_name = "";
$prd_price = "";
$prd_quantity = "";
$prd_brand = "";
$prd_cate = "";
$prd_desc = "";
$prd_id = "";
$cate_name = "";
$brd_name = "";

$target = $_GET['target'];

$query = "SELECT * FROM products WHERE prd_id = '$target'";
$result = mysqli_query($conn, $query);
if ($result) {
  $row = mysqli_fetch_assoc($result);

  $prd_name     = $row['prd_name'];
  $prd_price    = $row['prd_price'];
  $prd_quantity = $row['prd_quantity'];
  $prd_brand    = $row['prd_brand'];
  $prd_cate     = $row['prd_cate'];
  $prd_desc     = $row['prd_desc'];
  $prd_id       = $row['prd_id'];

  $getCateName = mysqli_query($conn, "SELECT * FROM categories WHERE cate_slug ='$prd_cate'");
  $getBrdName  = mysqli_query($conn, "SELECT * FROM brands WHERE brd_slug ='$prd_brand'");

  $rs1 = mysqli_fetch_assoc($getCateName);
  $rs2 = mysqli_fetch_assoc($getBrdName);

  $cate_name = $rs1['cate_name'];
  $brd_name = $rs2['brd_name'];
}

?>
<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0 pl-0 pr-0 pb-0" style="background: white;">
      <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
      <li class="breadcrumb-item active"><a href="#">Sản phẩm</a></li>
      <li class="breadcrumb-item active d-inline-block text-truncate" style="max-width:calc(100% - 170px);" aria-current="page"><?php echo $prd_name ?></li>
    </ol>
  </nav>
  <div class="row mt-2">
    <div class="col-md-6 col-lg-5">
      <div id="main_img" style="
              position: relative;
              width: 100%;
              padding-top:100%;
              ">
        <img id="bigImg" src="./data/upload/img/<?php echo $prd_id ?>" alt="" class="img-thumbnail d-block" style="
                position:absolute;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
                height: 100%;
                width: 100%;
                object-fit:cover;
                ">
      </div>
      <div id="relative_img" class=" mt-2 d-flex justify-content-between align-content-stretch flex-nowrap">
        <?php
        for ($i = 0; $i <= 3; $i++) {
        ?>
          <div id="" style="
              position: relative;
              width: 24%;
              padding-top:24%;
              ">
            <img id="" src="./data/upload/img/<?php echo $prd_id ?><?php echo ($i != 0) ? "_$i" : "" ?>" alt="" class="img-thumbnail d-block" style="
                position:absolute;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
                height: 100%;
                width: 100%;
                object-fit:cover;
                cursor:pointer;
                ">
          </div>
        <?php
        }
        ?>
      </div>
    </div>
    <div class="col-md-6 col-lg-7">
      <div class="d-block d-md-none" style="height: 10px;"></div>
      <div class="prd_dt-name border-bottom">
        <h5 class="font-weight-normal pb-1"><?php echo $prd_name ?></h5>
      </div>
      <table style="width:100%;" class="prd_dt-table">
        <tr>
          <th>Giá bán: </th>
          <td>
            <div>
              <?php
              if ($row['prd_priceSaled'] == 0) {
              ?>
                <span class="text-danger" style="font-weight:600;font-size:19px;">₫<?php echo number_format($row["prd_price"], '0', '3', '.') ?></span>
              <?php
              } else {
              ?>
                <span class="text-danger" style="font-weight:600;font-size:19px;">₫<?php echo number_format($row["prd_priceSaled"], '0', '3', '.') ?></span>
                <span class="text-muted" style="font-size:12px;"><del>₫<?php echo number_format($row["prd_price"], '0', '3', '.') ?></del></span>
              <?php
              }
              ?>
            </div>
          </td>
        </tr>
        <tr>
          <th>Tình trạng: </th>
          <td><?php echo ($prd_quantity == 0) ? "Hết hàng" : "Còn hàng ($prd_quantity)" ?></td>
        </tr>
        <tr>
          <th>Danh mục: </th>
          <td><?php echo $cate_name ?></td>
        </tr>
        <tr>
          <th>Thương hiệu: </th>
          <td><?php echo $brd_name ?></td>
        </tr>
        <tr>
          <th>Mô tả: </th>
          <td><a href="#prd_dt-para">Xem chi tiết sản phẩm <i style="position:relative; top:3px;" class='bx bxs-chevrons-down'></i></a></td>
        </tr>
      </table>
      <div class="row mt-3">
        <div class="col-md-6 d-flex justify-content-center">
          <a href="" class="buy-now">
            <b class="d-block text-center">Mua ngay</b>
            <small class="d-block text-center">Giao hàng tận nhà</small>
          </a>
        </div>
        <div class="d-block d-md-none" style="height:5px; width:100%;"></div>
        <div class="col-md-6 d-flex justify-content-center">
          <a href="" class="buy-now buy-now-nobg" data-toggle="modal" data-target="#inputQuantity">
            <b class="d-block text-center">Thêm vào giỏ</b>
            <small class="d-block text-center">Cho vào giỏ để mua tiếp</small>
          </a>
        </div>
        <div class="col-12 mt-3">
          <div class="need-help">
            <b class="d-block">Cần hỗ trợ ?</b>
            <small class="d-block">Để lại số điện thoại, sẽ có nhân viên gọi giải đáp !</small>
            <form action="" class="d-flex justify-content-center">
              <div class="need-help-input">
                <input type="number">
                <button style="background: orange;" class="btn text-white">Xác nhận</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12">
      <div id="prd_dt-para" style="scroll-margin-top: 90px" class="border-md-top mt-4">
        <div class="prd_dt-para-heading mt-2 mb-2">
          <span style="font-size: 20px;" class="d-block border-bottom pb-2">CHI TIẾT SẢN PHẨM</span>
        </div>
        <div class="prd_dt-para-content">
          <?php echo $prd_desc ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Show when click add to cart -->
<div class="modal fade" id="inputQuantity" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">
          <?php
          if (!empty($_SESSION['loginData'])) {
            echo ($prd_quantity > 0) ? "Nhập số lượng (còn $prd_quantity):" : "Thông báo !!!";
          } else {
            echo "Yêu cầu !!!";
          }
          ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addToCartForm">
        <div class="modal-body">
          <div class="d-flex align-items-center justify-content-center flex-column">
            <?php
            if (!empty($_SESSION['loginData'])) {
            ?>
              <?php
              if ($prd_quantity == 0) {
                echo "<span class='font-weight-bold text-danger'>Sản phẩm hiện đang hết hàng.</span>";
              ?>
              <?php
              } else {
                $userName = $_SESSION['loginData']['userAccount'];
                $findQuery = "SELECT * FROM carts WHERE prd_id='$prd_id' AND userName='$userName'";
                $findRs = mysqli_query($conn, $findQuery);
                $currentQtt = 1;
                if (mysqli_num_rows($findRs) > 0) {
                  $findRow = mysqli_fetch_assoc($findRs);
                  $currentQtt = $findRow['prd_quantity'];
                }
              ?>
                <?php
                echo ($currentQtt > 1) ? "<span class='mb-3'>Bạn đã thêm $currentQtt sản phẩm vào giỏ hàng trước đó.</span>" : "";
                ?>
                <div class="numInput">
                  <input type="text" name="id" id="prdId" readonly hidden value="<?php echo $prd_id ?>">
                  <input type="text" name="userName" id="userName" readonly hidden value="<?php echo $userName ?>">
                  <button type="button" id="numDn"><i class='bx bx-minus'></i></button>
                  <input id="numIn" name="quantity" id="prd_quantity" type="number" min="1" max="<?php echo $prd_quantity ?>" value="<?php echo $currentQtt ?>">
                  <button type="button" id="numUp"><i class='bx bx-plus'></i></button>
                </div>
              <?php
              }
              ?>
            <?php
            } else {
            ?>
              <span class="text-danger font-weight-bold">Đăng nhập để tiếp tục !</span>
            <?php
            }
            ?>
          </div>
        </div>
        <div class="modal-footer">
          <?php
          if (!empty($_SESSION['loginData'])) {
          ?>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Thoát</button>
            <?php
            if ($prd_quantity > 0) {
            ?>
              <button id="addSubmit" class="btn btn-primary">
                Thêm vào giỏ
              </button>
            <?php
            }
            ?>
          <?php
          } else {
          ?>
            <a href="login.php" type="button" class="btn btn-primary">Đăng nhập</a>
          <?php
          }
          ?>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="./assets/js/productDetail.js"></script>
<?php
include("./footer.php")
?>