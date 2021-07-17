<?php
session_write_close();
session_start();

include('./controllers/ProductController.php');
include('./controllers/UserController.php');


$title = "All Product";
$links = '<link rel="stylesheet" type="text/css" href="./assets/css/products.css">';
$message = [];

$p_control = new ProductController();
$u_control = new UserController();


$list_data = $p_control->index();



if (!isset($_SESSION['current_user']))
    include_once('./header2.php');
else
    include_once('./header.php');
?>
<h2>Product details</h2>

<!-- available task -->
<div class="flex-con">
    <?php
    if (isset($list_data) and $list_data) {
        
        foreach ($list_data as $product) {
            
            $product = (object)$product;

            

            $user = (object)$u_control->c_show($product->user_id);
    ?>


            <section>
                <a href="./product.php?id=<?php echo $product->id ?>" style="text-decoration: none; color: unset; background: unset;">
                    <div class="title">
                        <span><?php echo $product->name ?></span>
                        <small><?php echo $product->updated_at ?></small>
                    </div>

                    <div class="img">
                        <img height="250" width="100%" src="<?php echo (($product->image) ? "./assets/images/products/" . $product->image : "") ?>" alt="">
                    </div>

                    <div class="body">
                        <p>
                            <?php echo substr(trim($product->description), 0, 40);
                            echo (strlen(trim($product->description) > 40)) ? "..." : ""; ?>
                        </p>
                    </div>
                </a>
                <hr>
                <div class="foot">
                    <span>
                        <?php echo "&#8358;" . number_format($product->price, 2, ".", ",") ?>
                    </span>
                    <span>
                        <a href="tel:<?php echo $user->phone ?>">contact seller</a>
                    </span>
                </div>
            </section>

    <?php  }
    } else {
        echo "<h3>Product Not Found!</h3>";
    } ?>
</div>
<?php
include_once('./footer.php');

?>