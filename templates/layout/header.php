<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Watchest</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo _WEB_HOST_TEMPLATES."/"; ?>assets/img/favicon.png" rel="icon">
  <link href="<?php echo _WEB_HOST_TEMPLATES."/"; ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo _WEB_HOST_TEMPLATES."/"; ?>assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="<?php echo _WEB_HOST_TEMPLATES."/"; ?>assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?php echo _WEB_HOST_TEMPLATES."/"; ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo _WEB_HOST_TEMPLATES."/"; ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo _WEB_HOST_TEMPLATES."/"; ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo _WEB_HOST_TEMPLATES."/"; ?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?php echo _WEB_HOST_TEMPLATES."/"; ?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo _WEB_HOST_TEMPLATES."/"; ?>assets/css/style.css" rel="stylesheet">
  <link href="<?php echo _WEB_HOST_TEMPLATES."/"; ?>css/myStyle.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Moderna
  * Template URL: https://bootstrapmade.com/free-bootstrap-template-corporate-moderna/
  * Updated: Mar 17 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/   header-transparent
  ======================================================== -->
</head>
<body>
<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center ">
    <div class="container d-flex justify-content-between align-items-center">
      <div class="logo">
        <h1 class="text-light"><a href="?modules=home&action=dashboard"><span>Watchest</span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="active " href="?modules=home&action=dashboard">Home</a></li>
          <li><a href="?modules=home&action=about">About</a></li>
          <li><a href="services.html">Services</a></li>
          <li><a href="?modules=home&action=product">Product</a></li>
          <li><a href="?modules=home&action=team">Team</a></li>
          <li><a href="blog.html">Blog</a></li>
          <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li>
          <li><a href="contact.html">Contact Us</a></li>
          <div>
            <?php if(!isLogin()) { ?>
            <li><button type="button" class="btn btn-outline-light sign-dashboard" onclick="account()" >Account</button></li>
            <?php } else { ?>
            <li class="dropdown">
              <button type="button" class="btn btn-outline-light dropdown-toggle sign-dashboard signIn-button" data-bs-toggle="dropdown"><?php echo trim(strrchr(getUserLogin()['fullname'], ' ')); ?></button>
              <ul class="dropdown-menu signSubMenu">
                <li><a class="dropdown-item" href="?modules=users&action=profile">Profile</a></li>
                <li><a class="dropdown-item" href="?modules=cart_manage&action=list">My cart</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
                <li><hr class="dropdown-divider"></li>
                <?php if(permissionUser() == 1) { ?>
                  <li><a class="dropdown-item" href="?modules=product_manage&action=list">Inventory management</a></li>
                  <li><hr class="dropdown-divider"></li>
                <?php } elseif(permissionUser() == 2) { ?>
                  <li><a class="dropdown-item" href="?modules=user_manage&action=list">User management</a></li>
                  <li><a class="dropdown-item" href="?modules=product_manage&action=list">Inventory management</a></li>
                  <li><a class="dropdown-item" href="#">Admin page</a></li>
                  <li><hr class="dropdown-divider"></li>
                <?php } ?>
                <li><a class="dropdown-item" href="?modules=auth&action=signOut">Sign Out</a></li>
              </ul>
            </li>
            <?php } ?>
          </div>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
    </div>
  </header><!-- End Header -->