
<?php

include("./function/sqlconn.php");
include("./function/stringfn.php");


$cate_name = "";
$cate_slug  = "";
$err = [];
$stt = false;
if (isset($_POST["cateValue"])) {
  $cate_name = $_POST["cateValue"];
  if (empty($cate_name)) {
    $err['error'] = "Không được để trống !";
  } else {
    $query = "SELECT * FROM categories WHERE cate_name LIKE '$cate_name'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result)) {
      $err['error'] = "Danh mục đã tồn tại !";
    }
  }
  if (empty($err)) {
    $cate_slug = convert_name($cate_name);
    $query = "INSERT INTO categories(cate_name,cate_slug) VALUES('$cate_name','$cate_slug')";
    $result = mysqli_query($conn, $query);
    if ($result) {
      $stt = true;
      mysqli_close($conn);
    }
  }

  $finalResult = array(
    "err" => $err,
    "stt" => $stt,
  );
  echo json_encode($finalResult);
}
