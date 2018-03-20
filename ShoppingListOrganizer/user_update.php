<?php
    session_start();
    require_once('function.php');
    //check if user already loginned
    loginned();
    require_once('header.php');
    require_once('footer.php');
    connectDB();
    $valid = true;
    $emailError = false;
    $passwordError = false;
    $confirmError = false;
    $error_message = "";
    $id = $_SESSION['id'];
    $email = $_SESSION['email'];
    $now = date('Y-m-d H:i:s');
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        //validate each part
        if($_POST['email'] && $_POST['email'] != $email){
            $email = $_POST['email'];
            $query = "UPDATE user SET email='$email' WHERE user_id='$id'";
            $result = mysql_query($query);
            $_SESSION['email'] = $email;
            //add to history for the update
            add_user_history($id,"email");
        }
        elseif (!$_POST['email']) {
            $valid = false;
            $error_message .= "Email is empty<br>";
        }
        if($_POST['password'] && $_POST['reconfirm'] == $_POST['password']){
            $password = sha1($_POST['password']);
            $query = "UPDATE user SET user_password='$password' WHERE user_id='$id'";
            $result = mysql_query($query);
            //add to history for the update
            add_user_history($id,"password");
        }
        elseif($_POST['reconfirm'] != $_POST['password']){
            $valid = false;
            $error_message .= "Password reconfirm does not match<br>";
        }
    }
    else {
        $valid = false;
    }
    if($valid){
        $error_message = "User updated";
    }
    //print header
    head("User Update");
    //print message
    if($error_message != ""){
        echo $error_message;
        $error_message = "";
    }
    //form
    user_form($email,$emailError,$passwordError,$confirmError,'update');
    //footer
    footer();
?>