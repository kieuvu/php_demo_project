<?php
include("./function/sqlconn.php");

$query;
$target;
if (!empty($_POST['id'])) {
  $target = $_POST['id'];
  $query = "DELETE FROM categories WHERE id = $target; set @autoid :=0; UPDATE categories SET id = @autoid := (@autoid+1);ALTER TABLE categories Auto_Increment = 1; ";
}
$result = mysqli_multi_query($conn, $query);

if ($result) {
  mysqli_close($conn);
} else {
  echo mysqli_error($conn);
}
