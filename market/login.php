<?php
session_start();
require_once('./controllers/UserController.php');

$user = new UserController();

$title = "Login";
$links = '<link rel="stylesheet" type="text/css" href="./assets/css/login.css">';
$message = $old_data = [];

//Little Routing Here... 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['authlogin']) {

    list($old_data, $message, $userdata) = $user->c_login($_POST);

    if ($userdata) {
        $_SESSION['current_user'] = base64_encode(json_encode($userdata));
        header("refresh:3; url=index2.php");
    }
}

include('header2.php');
?>

<h1 align="center">Login Page</h1>

<section class="section clearfix">
    <h3 class="error">
        <?php
        echo (isset($message['general']) ? $message['general'] : "");
        ?>
    </h3>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo isset($old_data['email']) ? $old_data['email'] : "" ?>">
            <h3 class="error"><?php echo (isset($message['email']) ? $message['email'] : "") ?></h3>
        </div>
        <br>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            <h3 class="error"><?php echo (isset($message['password']) ? $message['password'] : "") ?></h3>
        </div>
        <br>
        <div class="action">
            <div class="log">
                <span>I am new here? <a href="register.php">Register</a></span>
                <input type="submit" name="authlogin" value="Login">
            </div>

            <span>Forget Password? <a href="reset_password.php">forget Password</a></span>
        </div>

    </form>
</section>
<?php

include_once('./footer.php');

?>