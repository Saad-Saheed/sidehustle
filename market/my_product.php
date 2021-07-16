<?php
include('./controllers/ProductController.php');

// use todolist\controllers\TodolistController;
$title = "My Products";
$message = [];
// $upd = null;

$p_control = new ProductController();

//My little Routing
if (isset($_REQUEST['action']) &&  $_REQUEST['action'] == 'delete') {

    $message = $p_control->c_delete($_REQUEST['id']);

}


$list_data = $p_control->my_product();

include_once('./header.php');
?>
<h2>My Products</h2>
<h4>
        <?php
        
        if(isset($message)){
            echo  (isset($message['general']) ? $message['general'] : (isset($message['success']) ? $message['success'] : ""));
        }
            
        ?>
    </h4>
<section>
    <!-- available task -->

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <th>S/N</th>
            <th>Name</th>
            <th>Description</th>
            <th>Image</th>
            <th>Created On</th>
            <th>Action</th>
        </thead>

        <tbody>
            <?php
            $i = 1;
            if (isset($list_data) and $list_data) {

                foreach ($list_data as $product) {
                    $product = (object)$product;
            ?>
                    <tr>
                        <td nowrap> <?php echo $i ?></td>
                        <td nowrap> <?php echo substr($product->name, 0, 40) ?></td>
                        <td nowrap> <?php echo substr($product->description, 0, 40);
                                    echo (strlen($product->description) > 40) ? "..." : "" ?></td>
                        <td nowrap align="center"><img height="40" width="80" src="<?php echo (($product->image) ? "./assets/images/products/" . $product->image : "") ?>" alt=""></td>
                        <td nowrap> <?php echo $product->created_at ?></td>
                        <td nowrap align="center">
                            <a class="btn view" href="./product.php?id=<?php echo $product->id ?>">view</a>
                            <a class="btn edit" href="./edit_product.php?action=edit&id=<?php echo $product->id ?>">edit</a>
                            <a class="btn delete" href="?action=delete&id=<?php echo $product->id ?>">delete</a>
                        </td>
                    </tr>
            <?php
                    $i += 1;
                }
            }
            ?>
        </tbody>
    </table>
</section>


<?php

include_once('./footer.php');

?>