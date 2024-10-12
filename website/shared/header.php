<?php
session_start();
include "shared/config.php";
if (isset($_SESSION['username'])) {
    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    $sql_id = "SELECT id FROM sign_up WHERE Name = '$username'";
    $sql_result = mysqli_query($conn, $sql_id);

    if ($sql_result && mysqli_num_rows($sql_result) > 0) {
        $id = mysqli_fetch_array($sql_result);
        $userId = $id['id'];
    } else {
        $userId = null;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Build Your Dream - #1 The Fastest Virtual PC Build Website</title>
    <meta name="description" content="Description">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">
    <link rel="icon" href="assets/img/logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/bootstrap-grid.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preload" href="assets/fonts/source-sans-pro-v21-latin/source-sans-pro-v21-latin-regular.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="assets/fonts/source-sans-pro-v21-latin/source-sans-pro-v21-latin-700.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="assets/fonts/montserrat-v25-latin/montserrat-v25-latin-700.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="assets/fonts/montserrat-v25-latin/montserrat-v25-latin-600.woff2" as="font" type="font/woff2" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preload" href="assets/fonts/material-icons/material-icons.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="assets/fonts/material-icons/material-icons-outlined.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
<main class="main">
    <div class="main-inner">
        <!-- Begin mobile main menu -->
        <nav class="mmm">
            <div class="mmm-content">
                <ul class="mmm-list">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about-us.php">About us</a></li>
                    <li><a href="PreBuild.php">Pre-Build PCs</a></li>
                    <li><a href="custombuild.php">Custom Build</a></li>
                    <li><a href="tabs-and-accordions.php">Tabs & Accordions</a></li>
                    <li><a href="contacts.php">Contacts</a></li>
                  
                    <?php if (isset($_SESSION['username'])) : ?>
                        <li><a href="orderhistory.php">Order History</a></li>
                        <li><a href="#">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
                        <li><a href="logout.php">Logout</a></li>
                        <li><a href="userprofile.php?id=<?php echo $userId; ?>" data-title="My Profile"><span>My Profile</span></a></li>
                    <?php else : ?>
                        <li><a href="loginsign.php" data-title="Login/Sign Up"><span>Login/Sign Up</span></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav><!-- End mobile main menu -->

        <header class="header header-minimal">
            <nav class="header-fixed">
                <div class="container">
                    <div class="row flex-nowrap align-items-center justify-content-between">
                        <div class="col-auto header-fixed-col logo-wrapper">
                            <a href="index.php" class="logo" title="PathSoft">
                                <img src="assets/img/logo1.png" width="1000" alt="logo">
                            </a>
                        </div>
                        <div class="col-auto col-xl col-static header-fixed-col d-none d-xl-block">
                            <div class="row flex-nowrap align-items-center justify-content-end">
                                <div class="col header-fixed-col d-none d-xl-block col-static">
                                    <!-- Begin main menu -->
                                    <nav class="main-mnu">
                                        <ul class="main-mnu-list">
                                            <li><a href="index.php" data-title="Home"><span>Home</span></a></li>
                                            <li><a href="about-us.php" data-title="About us"><span>About us</span></a></li>
                                            <li><a href="PreBuild.php" data-title="Pre-Build PCs"><span>Pre-Build PCs</span></a></li>
                                            <li><a href="custombuild.php" data-title="Custom Build"><span>Custom Build</span></a></li>
                                            <li><a href="contacts.php" data-title="Contact"><span>Contact</span></a></li>
                                            
                                            <?php if (isset($_SESSION['username'])) : ?>
                                                <li><a href="orderhistory.php" data-title="Order History"><span>Order History</span></a></li>
                                                <li><a href="#">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
                                                <li><a href="logout.php" data-title="Logout"><span>Logout</span></a></li>
                                                <li><a href="userprofile.php?id=<?php echo $userId; ?>" data-title="My Profile"><span>My Profile</span></a></li>
                                            <?php else : ?>
                                                <li><a href="loginsign.php" data-title="Login/Sign Up"><span>Login/Sign Up</span></a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </nav><!-- End main menu -->
                                </div>
                            </div>
                        </div>
                        <div class="col-auto d-block d-xl-none header-fixed-col">
                            <div class="main-mnu-btn">
                                <span class="bar bar-1"></span>
                                <span class="bar bar-2"></span>
                                <span class="bar bar-3"></span>
                                <span class="bar bar-4"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
