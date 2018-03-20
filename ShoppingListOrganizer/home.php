<?php
    session_start();
    require_once('function.php');
    //check if user already loginned
    loginned();
    connectDB();
    require_once('header.php');
    require_once('footer.php');
    //notification
    notification();
    //print header
    head("HOME");
    //print welcome message
    welcome();
    //reminder
    $id = $_SESSION['id'];
    $date_now = date("Y-m-d");
    $date_a_week = date("Y-m-d", strtotime("+1 week"));
    $reminder_query = "SELECT * FROM itemlist WHERE user_id='$id' AND due_date<='$date_a_week' ORDER BY due_date";
    $reminder_result = mysql_query($reminder_query);
    if(!$reminder_result){
        echo mysql_error();
        exit();
    }
?>
    <div id="reminder" name="reminder">
        <div id="reminder_title">
            WEEKLY REMINDER
        </div>
        <div id="reminder_table">
            <table>
                <tr class="black_title">
                    <td>
                        ITEM NAME
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
                </tr>
                <?php
                    $count = 0;
                    $at_least_one = false;
                    while($row=mysql_fetch_array($reminder_result, MYSQL_ASSOC)){
                        if($count%2 == 1){
                            $style = "grey_background";
                        }
                        else {
                            $style = "white_background";
                        }
                        if($row['due_date'] == $date_now){
                            $now = true;
                        }
                        else {
                            $now = false;
                        }
                        if($now){
                        $at_least_one = true;
                ?>
                <tr class='<?php echo $style ?>' >
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
                </tr>
                <?php
                        }
                        $count++;
                    }
                    if(!$at_least_one){
                ?>
                <tr>
                    <td id="no_item_reminder" colspan="4">
                        No Item has to be done in a week...
                    </td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>
    </div>
<?php
    //footer
    footer();
?>