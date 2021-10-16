<?php
session_start();

if (!empty($_SESSION['loginData'])) {
  unset($_SESSION['loginData']);
  header("location: index.php");
} else {
  echo "<script>window.top.location='index.php';</script>";
}

unset($_SESSION['loginData']);
header("location: index.php");
