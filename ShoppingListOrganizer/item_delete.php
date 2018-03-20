<?php
    session_start();
    require_once('function.php');
    //check if already loginned
    loginned();
    connectDB();
    $id = $_GET['id'];
    //authenticate, allow to delete the item
    if(authenticate($_SESSION['id'],$id)){
        add_item_history($id,"delete");
        $query = "DELETE FROM itemlist WHERE item_id='$id'";
        $_SESSION['message'] = "Item Deleted<br>";
        header('location: list.php');
    }
?>