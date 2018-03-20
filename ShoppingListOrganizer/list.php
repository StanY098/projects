<?php
    session_start();
    require_once('function.php');
    //check if user already loginned
    loginned();
    require_once('header.php');
    require_once('footer.php');
    connectDB();
    head("YOUR LIST");
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //get target email
        if($_POST['transfer'] || $_POST['copy']){
            if($_POST['transfer']){
                $email = $_POST['transfer'];
            }
            else {
                $email = $_POST['copy'];
            }
            $result_transfer = mysql_query("SELECT * FROM user WHERE email='$email'");
            if(mysql_num_rows($result_transfer) == 1){
                //transfer or copy item to target user
                $item = $_POST['item_id'];
                $user_id = mysql_fetch_assoc($result_transfer)['user_id'];
                $item_cp = mysql_fetch_assoc(mysql_query("SELECT * FROM itemlist WHERE item_id='$item';"));
                $name = $item_cp['item_name'];
                $amount = $item_cp['item_amount'];
                $brand = $item_cp['item_brand'];
                $date = $item_cp['due_date'];
                if($_POST['transfer']){
                    
                    $result_transfer = mysql_query("UPDATE itemlist SET user_id='$user_id' WHERE item_id='$item'");
                }
                else {
                    
                    $query = "INSERT INTO itemlist (item_name,item_amount,item_brand,due_date,user_id) VALUES ('$name','$amount','$brand','$date','$user_id');";
                    $result_transfer = mysql_query($query);
                }
            }
            else {
                $_SESSION['message'] = "The target email does not exist.<br>";
            }
        }
    }
    //show all items which the user owns
    $id = $_SESSION['id'];
    $query = "SELECT * FROM itemlist WHERE user_id='$id' ORDER BY due_date";
    $result = mysql_query($query);
    echo $_SESSION['message'];
    $_SESSION['message'] = "";
?>
<div id="item_list">
    <table>
        <thead class="black_title">
            <td>
                NAME
            </td>
            <td>
                AMOUNT
            </td>
            <td>
                BRAND
            </td>
            <td>
                DUE DATE
            </td>
            <td>
                &nbsp;
            </td>
            <td>
                TRANSFER or COPY Item to...
            </td>
        </thead>
    <?php
            $count = 0;
            while($row=mysql_fetch_array($result, MYSQL_ASSOC)){
                if($count%2 == 1){
                    $style = "grey_background";
                }
                else {
                    $style = "white_background";
                }
                $count++;
    ?>
        <tr class='<?php echo $style ?>'>
            <td>
                <?php
                    echo $row['item_name'];
                ?>
            </td>
            <td>
                <?php
                    echo $row['item_amount'];
                ?>
            </td>
            <td>
                <?php
                    echo $row['item_brand'];
                ?>
            </td>
            <td>
                <?php
                    echo $row['due_date'];
                ?>
            </td>
            <td>
                <a class="small_padding" id="item_edit_button" href="item_update.php?id=<?php echo $row['item_id'] ?>">EDIT</a> <a class="small_padding" id="item_delete_button" href="item_delete.php?id=<?php echo $row['item_id'] ?>">DELETE</a>
            </td>
            <td>
                <form action="list.php" method="post" class="small_padding">
                    <input type="email" name="transfer" />
                    <input type="hidden" name="item_id" value="<?php echo $row['item_id'] ?>">
                    <input id="submit" class="transfer_or_copy" type="submit" value="Transfer" />
                </form>
                <form action="list.php" method="post" class="small_padding">
                    <input type="email" name="copy" />
                    <input type="hidden" name="item_id" value="<?php echo $row['item_id'] ?>">
                    <input id="submit" class="transfer_or_copy" type="submit" value="Copy to..." />
                </form>
            </td>
        </tr>
    <?php
            }
    ?>
        <tr>
            <td colspan="6">
                <a id="new_item" href="item_new.php">+New Item</a>
            </td>
        </tr>
    </table>
</div>
<?php
    //footer
    footer();
?>