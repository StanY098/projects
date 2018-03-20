<?php
    session_start();
    require_once('function.php');
    //check if user already loginned
    loginned();
    connectDB();
    $id = $_SESSION['id'];
    //delete user
    $query = "DELETE FROM user WHERE user_id='$id'";
    $result = mysql_query($query);
    $history_query = "DELETE FROM history WHERE user_id='$id'";
    $history_result = mysql_query($history_query);
    logout();
?>