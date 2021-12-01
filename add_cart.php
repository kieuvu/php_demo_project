<?php
include("./function/sqlconn.php");
$stt = false;
if (isset($_POST['id'])) {
  $userName = $_POST['userName'];
  $quantity = $_POST['quantity'];
  $id = $_POST['id'];
  $query = "SELECT * FROM carts WHERE userName ='$userName' AND prd_id ='$id'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $newQtt = $quantity;
    $updateQuery = "UPDATE carts SET prd_quantity = '$newQtt', updated_at = now() WHERE userName ='$userName' AND prd_id ='$id'";
    if (mysqli_query($conn, $updateQuery)) {
      mysqli_close($conn);
      $stt = true;
    } else {
      echo mysqli_error($conn);
    }
  } else {
    $addQuery = "INSERT INTO carts(userName,prd_id,prd_quantity,created_at)VALUES('$userName','$id',$quantity,now())";
    if (mysqli_query($conn, $addQuery)) {
      mysqli_close($conn);
      $stt = true;
    }
  }
}

echo $stt;
