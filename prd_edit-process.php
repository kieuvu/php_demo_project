<?php
include("./function/sqlconn.php");

if (!empty($_POST)) {

  $err = [];
  $stt = false;
  $target         = $_POST['target'];
  $prd_name       = $_POST['prd_name'];
  $prd_price      = $_POST['prd_price'];
  $prd_quantity   = $_POST['prd_quantity'];
  $prd_saled      = $_POST['prd_priceSaled'];
  $prd_desc       = $_POST['prd_desc'];
  $prd_cate       = $_POST['prd_cate'];
  $prd_brand      = $_POST['prd_brand'];

  if (empty($prd_name)) {
    $err['name'] = "Chưa nhập tên";
  }
  if (empty($prd_price)) {
    $err['price'] = "Chưa nhập giá";
  }
  if (empty($prd_desc)) {
    $err['desc'] = "Chưa nhập mô tả";
  }
  if ($prd_cate == "0") {
    $err['cate'] = "Chưa chọn danh mục";
  }
  if ($prd_brand == "0") {
    $err['brand'] = "Chưa chọn thương hiệu";
  }

  if (empty($err)) {
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
      $stt = true;
    }
  }
  $finalResult = array(
    'err' => $err,
    'stt' => $stt,
  );

  echo json_encode($finalResult);
}
