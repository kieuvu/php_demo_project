<?php
include('./function/sqlconn.php');

$cate = $_GET['currentCategory'];
$brd = $_GET['currentBrand'];

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
$finalResult = array();
while ($row = mysqli_fetch_assoc($result)) {
  $finalResult[] = $row;
}
echo json_encode($finalResult);
