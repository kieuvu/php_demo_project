
<?php

include("./function/sqlconn.php");
include("./function/stringfn.php");


$brand_name = "";
$brand_slug  = "";
$stt = false;
$err = [];

if (isset($_POST["brandValue"])) {
  $brand_name = $_POST["brandValue"];
  if (empty($brand_name)) {
    $err['error'] = "Không được để trống !";
  } else {
    $query = "SELECT * FROM brands WHERE brd_name LIKE '$brand_name'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result)) {
      $err['error'] = "Thương hiệu đã tồn tại !";
    }
  }
  if (empty($err)) {
    $brand_slug = convert_name($brand_name);
    $query = "INSERT INTO brands(brd_name,brd_slug) VALUES('$brand_name','$brand_slug')";
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
?>