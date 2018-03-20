<?php
    require_once('function.php');
    require_once('header.php');
    require_once('footer.php');
    connectDB();
    $valid = true;
    /*need a token to authorize user to come in*/
    $token = $_GET['token'];
    $token_query = "SELECT * FROM reset_token WHERE token='$token'";
    $token_result = mysql_query($token_query);
    if(!$token_result){
        echo $mysql_error();
        exit();
    }
    if(mysql_num_rows($token_result) != 1){
        $_SESSION['message'] = "The token is not valid";
        header('location: index.php');
    }
    else {
        $user_token = mysql_fetch_assoc($token_result);
        $date_now = date("Y-m-d");
        if($user_token['expire_date'] < $date_now){
            echo "The token has expired. Please go back to homepage to make a new reset request.\n";
            ?>
            <a href="index.php">Homepage</a>
            <?php
            exit();
        }
        $email = $user_token['email'];
    }
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(!$_POST['password']){
            $valid = false;
            $passwordError = true;
            $error_message .= "Please put in your new password.<br>";
        }
        else {
            $password_temp = $_POST['password'];
            $match = preg_match('([a-z0-9]*[a-z][a-z0-9]*[0-9][a-z0-9]*)',$password_temp);
            if(!$match){
                $match = preg_match('([a-z0-9]*[0-9][a-z0-9]*[a-z][a-z0-9]*)',$password_temp);
            }
            if(!$match || strlen($password_temp) < 5) {
                $valid = false;
                $passwordError = true;
                $error_message .= "Password is not strong enough. It must be at least 5 characters long and have a lowercase and a number.<br>";
            }
        }
        if(!$_POST['reconfirm']){
            $valid = false;
            $confirmError = true;
            $error_message .= "Please reconfirm password.";
        }
        else {
            if($_POST['reconfirm'] != $_POST['password']){
                $valid = false;
                $passwordError = true;
                $confirmError = true;
                $error_message .= "The password to reconfirm does not match with your new password. Please try Again.";
            }
        }
    }
    else {
        $valid = false;
    }
    if($valid){
        //update user password
        $password = sha1($_POST['password']);
        $query = "UPDATE user SET user_password='$password' WHERE email='$email'";
        $result = mysql_query($query);
        if(!$result){
            echo mysql_error();
            exit();
        }
        $delete_query = "DELETE FROM reset_token WHERE token = $token'";
        $delete_result = mysql_query($delete_query);
        if(!$result){
            echo mysql_error();
            exit();
        }
        header('location: success_reset.php');
    }
    head('Reset Password');
?>
<form action='<?php echo "forgot_password.php?token=".$token ?>' method="post">
    <div class="form_fill">
    <label>
        New Password
    </label>
    <input type="password" name="password" />
    </div>
    <div class="form_fill">
    <label>
        Reconfirm Password
    </label>
    <input type="password" name="reconfirm" />
    <div class="form_fill">
        <input type="submit" name="submit" value="Reset" />
    </div>
</form>

<?php
    //footer
    footer();
?>