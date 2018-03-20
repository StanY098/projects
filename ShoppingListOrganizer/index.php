<?php
    session_start();
    require_once('function.php');
    //check if loginned already
    has_Session();
    require_once('header.php');
    require_once('footer.php');
    connectDB();
    $valid = true;
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        //check if valid
        $email = $_POST['email'];
        $password = sha1($_POST['password']);
        $query = "SELECT * FROM user WHERE email = '$email' AND user_password = '$password'";
        $result = mysql_query($query);
        //check if there is not exactly one user in the data meet the criteria
        if(mysql_num_rows($result) != 1){
            $login_fail = true;
            $valid = false;
        }
        else {
            //login user
            $user = mysql_fetch_assoc($result);
            $id = $user['user_id'];
            add_user_history($id,"login");
            login($user['user_id'],$user['email']);
        }
    }
    else {
        $valid = false;
    }
    if($valid){
        $_SESSION['message'] = "login";
        header('location: home.php');
    }
    //print header
    head("Login");
    //if not valid
    if($login_fail){
?>
        <div id="erro_message">
            email or password is not correct. Please try again.
        </div>
<?php
        $login_fail = false;
    }
    //form
    user_form($email,$emailError,$passwordError,$confirmError,'login');
    //footer
    footer();
?>