<?php
    session_start();
    require_once('function.php');
    connectDB();
    //check if user loginned
    loginned();
    $id = $_SESSION['id'];
    //add to history
    add_user_history($id,"logout");
    //logout user
    logout();
?>