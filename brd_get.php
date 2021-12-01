<?php

include("./function/sqlconn.php");
$finalResult = array();
$query = "SELECT * FROM brands ORDER BY brd_slug ASC";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result)) {
  $i = 1;
  while ($row = mysqli_fetch_assoc($result)) {
    $finalResult[] = $row;
  }
}

echo json_encode($finalResult);
