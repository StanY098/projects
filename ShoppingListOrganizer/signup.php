<?php
    session_start();
    require_once('function.php');
    require_once('header.php');
    require_once('footer.php');
    connectDB();
    $valid = true;
    $emailError = false;
    $passwordError = false;
    $confirmError = false;
    $error_message = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //validate each part
        if(!$_POST['email']){
            $valid = false;
            $emailError = true;
            $error_message .= "Email is empty. Please put in your email address.<br>";
        }
        elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$_POST['email'])){
            $valid = false;
            $emailError = true;
            $error_message .= "Email format requirement does not match. Please try again.";
        }
        else {
            $email = $_POST['email'];
        }
        if(!$_POST['password']){
            $valid = false;
            $passwordError = true;
            $error_message .= "Password is empty. Please put in your password.<br>";
        }
        elseif($_POST['password']){
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
            $error_message .= "Reconfirm Password is empty. Please reconfirm password.<br>";
        }
        elseif($_POST['reconfirm'] != $_POST['password']){
            $valid = false;
            $passwordError = true;
            $confirmError = true;
            $error_message .= "Reconfirm Password does not match. Please try again.<br>";
        }
        
    }
    else {
        $valid = false;
    }
    if($valid){
        //add new user information into database
        $password = sha1($_POST['password']);
        $query = "INSERT INTO user (email, user_password) VALUES ('$email', '$password')";
        $result = mysql_query($query);
        //automatically login user
        $result = mysql_query("SELECT * FROM user WHERE email='$email'");
        $user = mysql_fetch_assoc($result);
        $_SESSION['message'] = "signup";
        $id = $user['user_id'];
        add_user_history($id,"signup");
        login($user['user_id'],$user['email']);
        header('location: home.php');
    }
    //print header
    head("Sign Up");
    //print message
    if($error_message != ""){
        echo $error_message;
        $error_message = "";
    }
    //form
    user_form($email,$emailError,$passwordError,$confirmError,'Sign Up');
    //footer
    footer();
?>