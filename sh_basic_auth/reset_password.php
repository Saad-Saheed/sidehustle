<?php
session_start();

$errmessage = [];

if (!empty($_POST) && $_POST['authreset']) {
    validate_reset();
}

function validate_reset()
{
    global $errmessage;
    $errmessage = [];

    $data = [
        "email" => FILTER_VALIDATE_EMAIL,
        "password" => FILTER_SANITIZE_STRING
    ];

    // filter all input
    if ($s_data = filter_input_array(INPUT_POST, $data)) {

        $found = false;
        // Testing each input
        foreach ($s_data as $key => $input) {

            if (empty($input))
                $errmessage[$key] = "Invalid input, Your $key is required";
        }

        // if their is no error message
        if (empty($errmessage)) {
            // if user database has been created
            if (isset($_SESSION['users'])) {

                $users = $_SESSION['users'];

                //loop through each line in our database
                foreach ($users as $key => $user) {
                    $user = json_decode(base64_decode($user), true);

                    if (isset($user) && trim($s_data["email"]) == trim($user["email"])) {

                        // change Password
                        $user["password"] = $s_data["password"];
                        
                        // update the info in the database
                        $_SESSION['users'][$key] = base64_encode(json_encode($user));
                        
                        //success message
                        $errmessage['general'] = "Password change successfully, kindly login with your new password! " . '<a href="login.php">here</a>';
                        
                    }else {
                        // no match
                        $errmessage['general'] = "Invalid email, try again!";
                    }
                }
               
            } else {

                die("Data Not Found!");
            }
        }
    } else {
        echo "<h1>Make sure you supplied all data!</h1>";
    }
    $_SESSION['errmessage'] = $errmessage;
}
include('header.php');
?>

<main>
    <h1 align="center">Reset Password</h1>
    <h1>
        <?php
        echo (isset($_SESSION['errmessage']['general']) ? $_SESSION['errmessage']['general'] : "");
        unset($_SESSION['errmessage']['general']);
        ?>
    </h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">

        <div>
            <label for="email">Email</label><br>
            <input type="email" name="email" id="email" required>
            <h3><?php echo isset($_SESSION['errmessage']) ? (isset($_SESSION['errmessage']['email']) ? $_SESSION['errmessage']['email'] : "") : "" ?></h3>
        </div>
        <br>
        <div>
            <label for="password">New Password</label><br>
            <input type="password" name="password" id="password" required>
            <h3><?php echo isset($_SESSION['errmessage']) ? (isset($_SESSION['errmessage']['password']) ? $_SESSION['errmessage']['password'] : "") : "" ?></h3>
        </div>
        <br>
        <div>
            <input type="submit" name="authreset" value="Change Password"><br>
        </div>

    </form>
</main>


</body>

</html>