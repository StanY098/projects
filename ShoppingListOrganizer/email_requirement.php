<?php
    require_once('function.php');
    require_once('header.php');
    require_once('footer.php');
    connectDB();
    head('Email Requirement');
    $valid = true;
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        //check if email is valid
        if(!$_POST['email']){
            $valid = false;
            $emailError = true;
            $error_message = "Please put in your email.";
        }
        else {
            $email = $_POST['email'];
            $query = "SELECT * FROM user WHERE email='$email'";
            $result = mysql_query($query);
            if(!$result){
                echo mysql_error();
                exit();
            }
            if(mysql_num_rows($result) != 1){
                $valid = false;
                $emailError = true;
                $error_message = "The email you put does not exist.";
            }
        }
    }
    else {
        $valid = false;
    }
    if($valid){
        //setting up and send email message
        $token = token_generator();
        $subject = "Reset Password On Your Shopping List Account";
        $message = "We received a request to reset the password associated with this e-mail address. If you made this request, please follow the instructions below.\n";
        $message .= "Click the link below to reset your password using our secure server:\n\n";
        $message .= "http://dastan.is3.byuh.edu/shoppinglist/forgot_password.php?token=$token\n\n\n\n";
        $message .= "If you did not request to have your password reset you can safely ignore this email. Rest assured your customer account is safe.\n";
        $message .= "If clicking the link doesn't seem to work, you can copy and paste the link into your browser's address window, or retype it there.\n";
        $header = "Shopping List Reset Password";
        $res = mail($email,$subject,$message,$header);
        if(!$res){
            echo "problems on sending";
            exit();
        }
        $date_a_week = date("Y-m-d", strtotime("+1 week"));
        $token_query = "INSERT INTO reset_token (email,token,expire_date) VALUES ('$email','$token','$date_a_week')";
        $token_result = mysql_query($token_query);
        if(!$token_result){
?>
        <p>
            An email has been sent to this address: <span class="bold_italic"><?php echo $email ?></span>.
        </p>
<?php
            exit();
        }
        else {
?>
        <p class="form_fill">
            An email has sent to you. Please check the email to reset password.
        </p>
<?php
        }
    }
    else {
?>
        <form action="email_requirement.php" method="post">
            <div class="form_fill">
                <label>
                    Your Email: 
                </label>
                <input type="email" name="email" />
                <input type="submit" name="submit" />
            </div>
        </form>
<?php
    }
    //footer
    footer();
?>