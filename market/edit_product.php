<?php
session_start();
require_once('./controllers/ProductController.php');

$product = new ProductController();

$title = "Edit Product";
$links = '<link rel="stylesheet" type="text/css" href="./assets/css/add_edit_product.css">';
$message = $old_data = [];

//Little Routing Here... 
if (isset($_REQUEST['action']) &&  $_REQUEST['action'] == 'edit') {

    $prod = (object) $product->c_show($_REQUEST['id']);
    $_SESSION['this_product'] = $prod;
}

$this_product = isset($_SESSION['this_product']) ? $_SESSION['this_product'] : "";

if (isset($_POST['product_update']) &&  $_POST['product_update'] == 'Update') {

    list($old_data, $message) = $product->c_update($_POST, $this_product);
}

include('header.php');
?>

<h1>Update Product</h1>
<section class="section clearfix">
    <h3 class="error">
        <?php

        if (isset($message)) {
            echo (isset($message['general']) ? $message['general'] : (isset($message['success']) ? $message['success'] : ""));
        }

        ?>
    </h3>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">

        <div>
            <label for="name">Product Name</label>
            <input type="text" name="name" id="name" placeholder="Product name" value="<?php echo isset($old_data['name']) ? $old_data['name'] :  $this_product->name ?>">
            <h3 class="error"><?php
                echo (isset($message['name']) ? $message['name'] : "");
                ?></h3>

        </div>

        <div>
            <label for="price">Price</label>
            <input type="number" id="price" name="price" placeholder="1000" min="0" value="<?php echo isset($old_data['price']) ? $old_data['price'] :  number_format($this_product->price, 0, "", "") ?>">
            <h3 class="error"><?php echo (isset($message['price']) ? $message['price'] : "") ?></h3>
        </div>

        <div>
            <label for="desc">Description</label>
            <textarea name="description" id="desc" cols="30" rows="10"><?php echo isset($old_data['description']) ? $old_data['description'] :  $this_product->description ?></textarea>
            <h3 class="error"><?php echo (isset($message['description']) ? $message['description'] : "") ?></h3>
        </div>

        <div>
            <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
            <label for="image">Update Product Image</label>
            <input type="file" name="image" id="image">
            <h3 class="error"><?php echo (isset($message['image']) ? $message['image'] : "") ?></h3>
        </div>


        <div>
            <input type="submit" name="product_update" value="Update"><br><br>
        </div>

    </form>
</section>

<?php

include_once('./footer.php');

?>