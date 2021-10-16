<?php
session_start();
$checkLogin = (isset($_SESSION['loginData'])) ? true : false;
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="./assets/img/favicon.png" type="image/x-icon" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="./assets/css/style.css">
  <title>V-Tech</title>
</head>

<body>
  <header>
    <!-- Header For Large Device & Higher, Hide on Medium Device & Lower -->
    <div id="PC__HEADER" class="d-none d-md-block">
      <div id="header__top">
        <div class="container">
          <div class="d-flex justify-content-between">
            <div id="header__top-social" class="d-flex align-items-center">
              <a href="" class="header__top-socialLink d-block">
                <i class='bx bxs-envelope d-block'></i>
              </a>
              <a href="" class="header__top-socialLink d-block">
                <i class='bx bxs-phone-call d-block'></i>
              </a>
              <a href="" class="header__top-socialLink d-block">
                <i class='bx bxl-facebook-square d-block'></i>
              </a>
              <a href="" class="header__top-socialLink d-block">
                <i class='bx bxl-instagram-alt d-block'></i>
              </a>
            </div>
            <div id="header__top-userOption">
              <ul class="d-flex align-items-center mb-0" style="font-size:14px;">
                <!-- Khi Đăng Nhập Thành Công -->

                <?php
                if ($checkLogin) {
                ?>
                  <?php
                  if ($_SESSION['loginData']['userPerm'] == 1) {
                  ?>
                    <li><a href="./prd_manage.php">Quản lý SP</a></li>
                    <span class="text-secondary pl-2 pr-2">&#x0007C</span>
                  <?php
                  }
                  ?>
                  <li><a href="">Cài đặt tài khoản (<span><?php echo $_SESSION['loginData']['userAccount'] ?></span>)</a></li>
                  <span class="text-secondary pl-2 pr-2">&#x0007C</span>
                  <li><a href="logout.php">Đăng xuất</a></li>
                <?php
                } else {
                ?>
                  <li><a href="login.php">Đăng nhập</a></li>
                  <span class="text-secondary pl-2 pr-2">&#x0007C</span>
                  <li><a href="registry.php">Đăng kí</a></li>
                <?php
                }
                ?>

              </ul>
            </div>
          </div>
        </div>
      </div>
      <div id="header__main">
        <div class="container h-100">
          <div class="row h-100">
            <div id="header__main-logo" class="col-4 d-flex justify-content-start align-items-center h-100">
              <a class="text-secondary" href="index.php" id="kmvlogo">kieuvu</a>
            </div>
            <div id="header__main-menu" class="col-8 d-flex justify-content-end align-items-center h-100">
              <ul class="mb-0 d-flex align-items-center h-100 pl-0">
                <li><a class="text-secondary" href="index.php">Trang chủ</a></li>
                <li><a class="text-secondary" href="prd.php">Sản phẩm</a></li>
                <li class="h-100">
                  <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="searchbar">
                      <form action="search.php" method="GET">
                        <input class="search_input" required type="text" name="search" placeholder="Tìm kiếm...">
                        <button type="submit" class="search_icon"><i class='bx bx-search-alt'></i></button>
                      </form>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="d-none d-md-block header__margin"></div>
    </div>
    <!-- End PC Header -->

    <!-- Header For Medium Device & Lower, Hide on Large Device & Higher -->
    <div id="MOBILE__HEADER" class="d-block d-md-none" style="min-height: 71px;">
      <nav class="navbar navbar-expand-lg navbar-light  " style="background:rgba(255,255,255,0.95);min-height: 71px; position:fixed;width:100%; z-index:9999999999;">
        <div class="container">
          <a class="navbar-brand text-secondary" style="font-family: Dancing Script, cursive; font-weight:bolder; font-size:30px;letter-spacing: -2px;" href="index.php">kieuvu</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item ">
                <a class="nav-link" href="index.php">Trang chủ</a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="prd.php">Sản phẩm</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="registry.php">Đăng kí</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="login.php">Đăng nhập</a>
              </li>
              <!-- Only Show When User Login -->
              <div class="d-none">
                <li class="nav-item">
                  <a class="nav-link" href="prd_manage.php">Quản lí SP</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="acc_setting.php">Cài đặt tài khoản</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="logout.php">Đăng xuất</a>
                </li>
              </div>
            </ul>
          </div>
        </div>
      </nav>
      <div class="d-block d-md-none" style="height: 71px;"></div>
    </div>
    <!-- End Mobile Header -->
  </header>
  <main>
    <div class="wrapper">