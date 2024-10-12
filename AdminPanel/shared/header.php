<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from demo.bootstrapdash.com/star-admin-free/jquery/src/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 01 Jul 2024 16:09:02 GMT -->
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Star Admin Premium Bootstrap Admin Dashboard Template</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.addons.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/shared/style.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/demo_1/style.css">
    <!-- End Layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.php -->
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
          <!-- <a class="navbar-brand brand-logo" href="index.php">
            <h4>Admin Panel</h4> </a> -->
          <a class="navbar-brand brand-logo-mini" href="index.php">
            <img src="assets/images/logo.png" alt="logo" /> </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">

          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.php -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="profile-image">
                  <img class="img-xs rounded-circle" src="https://img.freepik.com/premium-vector/human-symbol-3d-icon-user-business-symbology-website-profile_593228-130.jpg" alt="profile image">
                  <div class="dot-indicator bg-success"></div>
                </div>
                <div class="text-wrapper">
                  <p class="profile-name">Admin</p>
                  <p class="designation">Admin Panel</p>
                </div>
              </a>
            </li>
            <li class="nav-item nav-category">Main Menu</li>

            <li class="nav-item">
              <a class="nav-link" href="index.php">
                <i class="menu-icon typcn typcn-shopping-bag"></i>
                <span class="menu-title">Home Page</span>
              </a>
            </li>

            
            <li class="nav-item  text-center">
  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

   
      <span class="menu-title">Pre-Build PCs</span>
      

   
    <div class="dropdown-menu dropdown-menu-center scrollable-menu" aria-labelledby="navbarDropdown">
    <a class="dropdown-item" href="prebuild.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Add Pre-Build PCs</a>
   <a class="dropdown-item" href="showprebuild.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Edit Pre-Build PCs</a>
 <a class="dropdown-item" href="delprebuild.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Delete Pre-Build PCs</a>
 <a class="dropdown-item" href="orderprebuild.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Orders of Pre-Build PCs</a>
 <a class="dropdown-item" href="confirmprebuild.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Confirm Orders</a>
 <a class="dropdown-item" href="rejectprebuild.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Rejected Orders</a>
  </div>
  </a>
</li>

<li class="nav-item  text-center">
  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

   
      <span class="menu-title">Custom Build PCs</span>
      

   
    <div class="dropdown-menu dropdown-menu-center scrollable-menu" aria-labelledby="navbarDropdown">
 <a class="dropdown-item" href="ordercustombuild.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Orders of Pre-Build PCs</a>
 <a class="dropdown-item" href="confirmcustomorder.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Confirm Orders</a>
 <a class="dropdown-item" href="rejectcustomorder.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Rejected Orders</a>
  </div>
  </a>
</li>

<li class="nav-item  text-center">
  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

   
      <span class="menu-title">Add Components</span>
      

   
    <div class="dropdown-menu dropdown-menu-center scrollable-menu" aria-labelledby="navbarDropdown">
    <a class="dropdown-item" href="addcpu.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Add CPU</a>
    <a class="dropdown-item" href="addcooler.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Add Cooler</a>
    <a class="dropdown-item" href="addmotherboard.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Add MotherBoard</a>
    <a class="dropdown-item" href="addmemory.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Add Memory</a>
    <a class="dropdown-item" href="addstorage.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Add Storage</a>
    <a class="dropdown-item" href="addgpu.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Add GPU</a>
    <a class="dropdown-item" href="addcase.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Add Case</a>
    <a class="dropdown-item" href="addpsu.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Add PSU</a>
  </div>
  </a>
</li>

<li class="nav-item  text-center">
  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

   
      <span class="menu-title">Edit Components</span>
      

   
    <div class="dropdown-menu dropdown-menu-center scrollable-menu" aria-labelledby="navbarDropdown">
    <a class="dropdown-item" href="showcpu.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Edit CPU</a>
    <a class="dropdown-item" href="showcooler.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Edit Cooler</a>
    <a class="dropdown-item" href="showmb.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Edit MotherBoard</a>
    <a class="dropdown-item" href="showmem.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Edit Memory</a>
    <a class="dropdown-item" href="showstorage.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Edit Storage</a>
    <a class="dropdown-item" href="shwogpu.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Edit GPU</a>
    <a class="dropdown-item" href="showcase.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Edit Case</a>
    <a class="dropdown-item" href="showpsu.php"><i class="menu-icon typcn typcn-cog mr-2"></i>Edit PSU</a>
  </div>
  </a>
</li>

<style>
.nav-item .dropdown-menu.scrollable-menu {
  max-height: 200px; /* Adjust the height as needed */
  overflow-y: auto;
}


</style>

<li class="nav-item">
              <a class="nav-link" href="ContactData.php">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Contact Us</span>
              </a>
            </li>
            <li class="nav-item">
  <a class="nav-link" href="logout.php">
    <i class="menu-icon typcn typcn-user-outline"></i>
    <span class="menu-title">Sign Out</span>
  </a>
</li>

          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <!-- Page Title Header Starts-->
        