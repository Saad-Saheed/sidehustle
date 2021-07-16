<?php
session_start();
require_once('./controllers/UserController.php');

$user = new UserController();

$title = "Reset Password";
$links = '<link rel="stylesheet" type="text/css" href="./assets/css/login.css">';
$message = $old_data = [];

//Little Routing Here... 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['authreset']) {

    list($old_data, $message) = $user->c_passwordReset($_POST);
}

include('header2.php');
?>
<h1 align="center">Reset Password</h1>
<section class="section clearfix">
    <h3 class="error">
        <?php
        echo (isset($message['general']) ? $message['general'] : "");
        ?>
    </h3>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" style="padding-top:  30px;">

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo isset($old_data['email']) ? $old_data['email'] : "" ?>">
            <h3 class="error"><?php echo (isset($message['email']) ? $message['email'] : "") ?></h3>
        </div>

        <br>
        <div>
            <label for="password">New Password</label>
            <input type="password" name="password" id="password">
            <h3 class="error"><?php echo (isset($message['password']) ? $message['password'] : "") ?></h3>
        </div>

        <br>
        <div class="clearfix">
            <input type="submit" name="authreset" value="Change Password" style="float: right;">
        </div>

    </form>
</section>

<?php

include_once('./footer.php');

?>