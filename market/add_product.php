<?php
session_start();
require_once('./controllers/ProductController.php');

$product = new ProductController();

$title = "Add Product";
$links = '<link rel="stylesheet" type="text/css" href="./assets/css/add_edit_product.css">';
$message = $old_data = [];

//Little Routing Here... 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['productreg']) {

    list($old_data, $message) = $product->c_create($_POST);
}

include('header.php');
?>

<h1>Add New Product</h1>
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
            <input type="text" name="name" id="name" placeholder="Product name" value="<?php echo isset($old_data['name']) ? $old_data['name'] : "" ?>">
            <h3 class="error"><?php
                                echo (isset($message['name']) ? $message['name'] : "");
                                ?></h3>

        </div>

        <div>
            <label for="price">Price</label>
            <input type="number" id="price" name="price" placeholder="1000" min="1" value="<?php echo isset($old_data['price']) ? $old_data['price'] : "" ?>">
            <h3 class="error"><?php echo (isset($message['price']) ? $message['price'] : "") ?></h3>
        </div>

        <div>
            <label for="desc">Description</label>
            <textarea name="description" placeholder="Product description" id="desc" cols="30" rows="10"><?php echo isset($old_data['description']) ? $old_data['description'] : "" ?></textarea>
            <h3 class="error"><?php echo (isset($message['description']) ? $message['description'] : "") ?></h3>
        </div>

        <div>
            <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
            <label for="image">Choose Product Image</label>
            <input type="file" name="image" id="image">
            <h3 class="error"><?php echo (isset($message['image']) ? $message['image'] : "") ?></h3>
        </div>


        <div>
            <input type="submit" name="productreg" value="Add"><br><br>
        </div>

    </form>
</section>

<?php
include_once('./footer.php');
?>