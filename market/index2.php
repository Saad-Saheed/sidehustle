<?php
session_start();

$title = "Dashboard";
$links = '<link rel="stylesheet" type="text/css" href="./assets/css/dashboard.css">';


if (!isset($_SESSION['current_user']))
    header("location: index.php");

include('header.php');


$auth_user = (isset($_SESSION['current_user'])) ? $_SESSION['current_user'] : null;
$auth_user = (object) json_decode(base64_decode($auth_user));

include('./controllers/ProductController.php');
$p_control = new ProductController();

$myproducts  = $p_control->my_product();

?>
<h1>Dashboard</h1>
<section class="contain">
    <div class="box">
        <p>Total product Uploaded: </p>
        <h2><?php echo ($myproducts) ? count($myproducts) : 0 ?></h2>
    </div>
    <div class="box">
        <p>Last Profile Update: </p>
        <h2><?php echo $auth_user->updated_at?></h2>
    </div>
    <div class="box">
        <p>Contact: </p>
        <h2><?php echo $auth_user->phone?></h2>
    </div>
    <div class="box">
        <p>Others: </p>
        <h2><?php echo $auth_user->email?></h2>
    </div>
</section>

<?php

include_once('./footer.php');

?>