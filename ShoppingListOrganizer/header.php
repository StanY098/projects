<?php
    //setup header
    require_once('function.php');
    function head($subtitle){
?>
<!DOCTYPE html>
<html lang="en" xml:lang="en">
    <head>
        <title>Shopping List - Your Shopping Organizer</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="main.css">
        <link rel="shortcut icon" href="cart.ico">
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
        <script language="javascript">
            /*$(function() {
                $("#account").hover(function(){
                    $('.submenu').slideToggle();
                });
            });*/
            $(function() {
                $("#account").click(function(){
                    $('.submenu').slideToggle();
                });
            });
            /*$(function() {
                $("#list").hover(function(){
                    $('.second_menu').slideToggle();
                });
            });*/
        </script>
    </head>
        <?php
            if($subtitle == "Login" || $subtitle == "Sign Up" || $subtitle == "Email Requirement" || $subtitle == "Reset Password" || $subtitle == ""){
        ?>
        <body id="not_loginned">
            <div id="outsider">
                <div id="big_header" name="big_header">
                    SHOPPING LIST<br><span id="sub_title">YOUR SHOPPING ORGANIZER</span>
                    <footer>
                        Copyright &copy; 2018 Stanley Hung
                    </footer>
        <?php
            }
            else {
        ?>
        <body id="loginned">
            <div id="insider">
                <div id="big_header" name="big_header">
                    SHOPPING LIST ORGANIZER <span id="normal_footer">Copyright &copy; 2018 Stanley Hung</span>
        <?php
            }
        ?>
            
        </div>
        
        <nav id="user_nav">
            <?php
                user_nav($subtitle);
            ?>
        </nav>
        <nav id="nav">
            <?php
                nav($subtitle);
            ?>
        </nav>
        <div id="sub_header" name="sub_header">
            <?php echo $subtitle ?>
        </div>
<?php 
    }
?>