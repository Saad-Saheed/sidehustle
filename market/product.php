<?php
session_write_close();
session_start();

include('./controllers/ProductController.php');
include('./controllers/UserController.php');


$title = "Product";
$links = '<link rel="stylesheet" type="text/css" href="./assets/css/product.css">';
$message = [];
// $upd = null;

$p_control = new ProductController();
$u_control = new UserController();

//My little Routing

$data = (object)$p_control->c_show($_GET['id'] ?? null);


if (!isset($_SESSION['current_user']))
    include_once('./header2.php');
else
    include_once('./header.php');
?>

<h1>Product details</h1>
<!-- available task -->
<?php
if ($data) { 
    $user = (object)$u_control->c_show($data->user_id);
    ?>
    <div class="flex-con">
        <section>

            <div class="title">
                <span><?php echo $p_control->name ?></span>
                <small><?php echo $p_control->updated_at ?></small>
            </div>

            <div class="img">
                <img height="250" width="100%" src="<?php echo (($p_control->image) ? "./assets/images/products/" . $p_control->image : "") ?>" alt="">
            </div>

            <div class="body">
                <p>
                    <?php echo $p_control->description ?>
                </p>
            </div>
            <hr>
            <div class="foot">
                <span>
                    <?php echo "&#8358;" . number_format($p_control->price, 2, ".", ",") ?>
                </span>
                <span>
                    <a href="tel:+<?php echo $user->phone ?>">contact seller</a>
                </span>
            </div>
        </section>
    </div>
<?php  } else {
    echo "<h3>Product Not Found!</h3>";
}

include_once('./footer.php');

?>