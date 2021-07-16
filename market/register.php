<?php
session_start();
require_once('./controllers/UserController.php');

$user = new UserController();

$title = "Sign Up";
$links = '<link rel="stylesheet" type="text/css" href="./assets/css/register.css">';
$message = $old_data = [];

//Little Routing Here... 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['authregister']) {

    list($old_data, $message) = $user->c_create($_POST);
}

include('header2.php');
?>

<h1 align="center">Registration Page</h1>
<section class="section clearfix">
    <h3 class="error">
        <?php

        if (isset($message)) {
            echo (isset($message['general']) ? $message['general'] : (isset($message['success']) ? $message['success'] : ""));
        }

        ?>
    </h3>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">

        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" placeholder="Full name" value="<?php echo isset($old_data['name']) ? $old_data['name'] : "" ?>">
            <h3 class="error"><?php
                                echo (isset($message['name']) ? $message['name'] : "");
                                ?></h3>

        </div>

        <div>
            <label for="phone">Phone Number</label>
            <input type="tel" pattern="0[7-9]{1}[0,1]{1}[0-9]{8}" id="phone" name="phone" placeholder="E.g 08130447717" value="<?php echo isset($old_data['phone']) ? $old_data['phone'] : "" ?>">
            <h3 class="error"><?php echo (isset($message['phone']) ? $message['phone'] : "") ?></h3>
        </div>

        <div>
            <h3>Gender</h3>
            <input type="radio" name="gender" id="male" <?php echo (isset($old_data['gender']) && $old_data['gender'] == 'male') ? "checked" : "" ?> value="male" required>
            <label for="male" style="display: inline;">Male</label>

            <input type="radio" name="gender" id="female" <?php echo (isset($old_data['gender']) && $old_data['gender'] == 'female') ? "checked" : "" ?> value="female" required>
            <label for="female" style="display: inline;">Female</label>
            <h3 class="error"><?php echo (isset($message['gender']) ? $message['gender'] : "") ?></h3>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo isset($old_data['email']) ? $old_data['email'] : "" ?>">
            <h3 class="error"><?php echo (isset($message['email']) ? $message['email'] : "") ?></h3>
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            <h3 class="error"><?php echo (isset($message['password']) ? $message['password'] : "") ?></h3>
        </div>

        <div class="action clearfix">
            <span>Already have an account? <a href="login.php">Login</a></span>
            <input type="submit" name="authregister" value="Register">
        </div>

    </form>
</section>
<?php

include_once('./footer.php');

?>