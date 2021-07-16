<?php
session_write_close();
session_start();

if (isset($_SESSION['current_user']))
    header("location: ./index2.php");

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>MARKIFY || <?php echo $title ?></title>

	<link rel="stylesheet" type="text/css" href="./assets/css/style.css">

	<?php echo $links ? $links : ""?>

    <script src="./assets/js/index.js" defer></script>

</head>
<body>
	<header>
		
		<div class="logo">
        <!-- <img src="images/clipart999521.png"> -->
			<span class="c-name"><a href="<?php echo (isset($_SESSION['current_user'])) ? './index2.php' : './index.php'?>">Markify</a></span>
			<span class="btn-toggle" style="margin-top: 10px;">
                <span style="border: 1px solid white; display: block; margin: 10px 3px; width:30px"></span>
				<span style="border: 1px solid white; display: block; margin: 10px 3px; width:30px"></span>
				<span style="border: 1px solid white; display: block; margin: 10px 3px; width:30px"></span>
            </span>
		</div>

		<nav class="nav hide">
			<ul>
				<li><a href="./index.php">Products</a></li>

				<li><a href="./register.php">Register</a></li>

				<li><a href="./login.php">Login</a></li>

				<li><a href="https://saadsaheed.com.ng/portfolio">Contact Us</a></li>
			</ul>
		</nav>

	</header>

	<main class="main-content">