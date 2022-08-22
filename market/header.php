<?php
session_write_close();
session_start();

if (!isset($_SESSION['current_user']))
    header("location: ./index.php");


$user = (isset($_SESSION['current_user'])) ? $_SESSION['current_user'] : null;
$user = (object) json_decode(base64_decode($user));

if (isset($_GET['action']) && $_GET['action'] == "logout")
    logout();

function logout()
{

    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), "", time() - 3600, "/");
    }
    $_SESSION  = [];
    session_destroy();

    header("location: ./login.php");
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MARKIFY || <?php echo $title ?></title>

    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <?php echo $links ? $links : "" ?>
    <script src="./assets/js/index.js" defer></script>

</head>

<body>
    <header>

        <div class="logo">
            <!-- <img src="images/clipart999521.png"> -->
            <span class="c-name"><a href="<?php echo (isset($_SESSION['current_user'])) ? './index2.php' : './index.php'?>">Markify</a></span>
            <span class="btn-toggle" style="margin-top: 12px;">
                <span style="border: 1px solid white; display: block; margin: 8px 3px; width:30px"></span>
                <span style="border: 1px solid white; display: block; margin: 8px 3px; width:30px"></span>
                <span style="border: 1px solid white; display: block; margin: 8px 3px; width:30px"></span>
            </span>
        </div>

        <nav class="nav hide">
            <ul>
                <!-- <li><a href="./register.php">Register</a></li> -->

                <li><a href="./add_product.php">Add Product</a></li>
                <li><a href="./my_product.php">My Products</a></li>
                <li><a href="./index.php">All Products</a></li>
                <li><a href="https://saadsaheed.com.ng/">Contact Us</a></li>
                <li><a href="?action=logout">Logout</a></li>
            </ul>
        </nav>

    </header>

    <main class="main-content clearfix">