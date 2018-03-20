<?php
    session_start();
    require_once('function.php');
    loginned();
    require_once('header.php');
    require_once('footer.php');
    connectDB();
    $valid = true;
    $error_message = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //copy from post in order to show users' inputs when going back to the form if not valid
        $name = $_POST['name'];
        $amount = $_POST['number'];
        $brand = $_POST['brand'];
        $date = $_POST['due_date'];
        //validate each part
        if(!$_POST["name"]){
            $error_message .= "Item name is empty.<br>";
            $nameError = true;
            $valid = false;
        }
        if(!$_POST["number"]){
            $error_message .= "Item amount is empty.<br>";
            $numberError = true;
            $valid = false;
        }
        elseif($_POST["number"] < 0.0001){
            $error_message .= "Item amount is invalid. It must be greater than 0.0001.<br>";
            $numberError = true;
            $valid = false;
        }
        if(!$_POST["due_date"]){
            $error_message .= "Item Due date is empty.<br>";
            $dateError = true;
            $valid = false;
        }
        else {
            $date_now = date("Y-m-d");
            if($_POST["due_date"] < $date_now){
                $error_message .= "Due date is invalid. <br>";
                $dateSelectionError = true;
                $valid = false;
            }
        }
    }
    else {
        $valid = false;
    }
    if($valid){
        //add item into itemlist table
        $id = $_SESSION['id'];
        $query = "INSERT INTO itemlist (item_name,item_amount,item_brand,due_date,user_id) VALUES ('$name','$amount','$brand','$date','$id')";
        $result = mysql_query($query);
        $$_SESSION['message'] = "Item created<br>";
        //add to history
        $query = "SELECT * FROM itemlist ORDER BY item_id DESC LIMIT 1";
        $result = mysql_query($query);
        $item = mysql_fetch_assoc($result);
        $item_id = $item['item_id'];
        add_item_history($item_id,"create");
        header('location: list.php');
    }
    //print header
    head("Create New");
    //print message
    if($error_message != ""){
        echo $error_message;
        $error_message = "";
    }
    //form
    item_form($id,$name,$nameError,$amount,$numberError,$brand,$date,$dateError,$dateSelectionError,"new");
    //footer
    footer();
?>