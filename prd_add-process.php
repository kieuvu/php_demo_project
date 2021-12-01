<?php

include("./function/sqlconn.php");
include("./function/stringfn.php");

$err = [];
$stt = false;

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

$allowedTypes = [
  'image/png' => 'png',
  'image/jpeg' => 'jpg'
];

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
    $err['name'] = "Chưa nhập tên !";
  }
  if (empty($prd_price)) {
    $err['price'] = "Chưa nhập giá !";
  }
  if (empty($prd_desc)) {
    $err['desc'] = "Chưa nhập mô tả !";
  }
  if ($prd_cate == "0") {
    $err['cate'] = "Chưa chọn danh mục !";
  }
  if ($prd_brand == "0") {
    $err['brand'] = "Chưa chọn thương hiệu !";
  }

  if (empty($prd_imgst['name'])) {
    $err['img1'] = "Chưa chọn ảnh !";
  } else {
    $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
    $filetype = finfo_file($fileinfo, $prd_imgst["tmp_name"]);
    if (!in_array($filetype, array_keys($allowedTypes))) {
      $err['img1'] = "Không đúng định dạng ảnh !";
    }
  }
  if (empty($prd_imgnd['name'])) {
    $err['img2'] = "Chưa chọn ảnh !";
  } else {
    $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
    $filetype = finfo_file($fileinfo, $prd_imgnd["tmp_name"]);
    if (!in_array($filetype, array_keys($allowedTypes))) {
      $err['img2'] = "Không đúng định dạng ảnh !";
    }
  }
  if (empty($prd_imgrt['name'])) {
    $err['img3'] = "Chưa chọn ảnh !";
  } else {
    $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
    $filetype = finfo_file($fileinfo, $prd_imgrt["tmp_name"]);
    if (!in_array($filetype, array_keys($allowedTypes))) {
      $err['img3'] = "Không đúng định dạng ảnh !";
    }
  }
  if (empty($prd_imgth['name'])) {
    $err['img4'] = "Chưa chọn ảnh !";
  } else {
    $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
    $filetype = finfo_file($fileinfo, $prd_imgth["tmp_name"]);
    if (!in_array($filetype, array_keys($allowedTypes))) {
      $err['img4'] = "Không đúng định dạng ảnh !";
    }
  }

  if (empty($err)) {
    $prd_id = randomName(10);
    $query = "INSERT INTO products(prd_name,prd_price,prd_cate,prd_brand,prd_desc,prd_id,prd_quantity,prd_timeCreated) VALUES('$prd_name','$prd_price','$prd_cate','$prd_brand','$prd_desc','$prd_id','$prd_quantity',now())";
    $result = mysqli_query($conn, $query);
    if ($result) {
      move_uploaded_file($prd_imgst["tmp_name"], "./data/upload/img/" . $prd_id);
      move_uploaded_file($prd_imgnd["tmp_name"], "./data/upload/img/" . $prd_id . "_1");
      move_uploaded_file($prd_imgrt["tmp_name"], "./data/upload/img/" . $prd_id . "_2");
      move_uploaded_file($prd_imgth["tmp_name"], "./data/upload/img/" . $prd_id . "_3");
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
