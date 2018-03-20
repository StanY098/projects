<?php
    session_start();
    require_once('function.php');
    loginned();
    require_once('header.php');
    require_once('footer.php');
    connectDB();
    $valid = true;
    $id = $_GET['id'];
    authenticate($_SESSION['id'],$id);
    $error_message = "";
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        //validate each part
        if(!$_POST['name']){
            $error_message .= "Item name is empty.<br>";
            $nameError = true;
            $valid = false;
        }
        if(!$_POST['number']){
            $error_message .= "Item amount is empty.<br>";
            $numberError = true;
            $valid = false;
        }
        elseif($_POST["number"] < 0.0001){
            $error_message .= "Item amount is invalid. It must be greater than 0.0001.<br>";
            $numberError = true;
            $valid = false;
        }
        if(!$_POST['due_date']){
            $error_message .= "Item Due Date is empty.<br>";
            $dateError = true;
            $valid = false;
        }
    }
    else {
        $valid = false;
        $query = "SELECT * FROM itemlist WHERE item_id='$id'";
        $result = mysql_query($query);
        $item = mysql_fetch_assoc($result);
        $name = $item['item_name'];
        $amount = $item['item_amount'];
        $brand = $item['item_brand'];
        $date = $item['due_date'];
    }
    //update item details
    if($valid){
        $date_now = date("Y-m-d");
        if(($_POST['name'] != $name || $_POST['number'] != $amount || $_POST['brand'] != $brand || $_POST['due_date'] != $date) && $_POST['due_date'] >= $date_now){
            $name = $_POST['name'];
            $amount = $_POST['number'];
            $brand = $_POST['brand'];
            $date = $_POST['due_date'];
            $query = "UPDATE itemlist SET item_name='$name', item_amount='$amount', item_brand='$grand', due_date='$date' WHERE item_id='$id'";
            $result = mysql_query($query);
            add_item_history($id,"update");
            $error_message = "Item Updated<br>";
        }
    }
    //print header
    head("Update Item");
    //print message
    if($error_message != ""){
        echo $error_message;
        $error_message = "";
    }
    //form
    item_form($id,$name,$nameError,$amount,$numberError,$brand,$date,$dateError,$dateSelectionError,"update");
    //footer
    footer();
?>