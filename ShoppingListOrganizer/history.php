<?php
    session_start();
    require_once('function.php');
    loginned();
    require_once('header.php');
    require_once('footer.php');
    connectDB();
    //print header
    head("HISTORY");
    $id = $_SESSION['id'];
    //show user history from newest to oldest
    $query = "SELECT * FROM history WHERE user_id='$id'ORDER BY datetime DESC";
    $result = mysql_query($query);
?>
<div id="history">
    <table>
        <thead class="black_title">
            <td>
                USER EMAIL
            </td>
            <td>
                ITEM ID
            </td>
            <td>
                ITEM NAME
            </td>
            <td>
                ITEM AMOUNT
            </td>
            <td>
                ITEM BRAND
            </td>
            <td>
                DUE DATE
            </td>
            <td>
                STATUS
            </td>
            <td>
                UPDATE DATE & TIME
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
                    echo $row['user_email'];
                ?>
            </td>
            <td>
                <?php
                    echo $row['item_id'];
                ?>
            </td>
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
                <?php
                    echo $row['status'];
                ?>
            </td>
            <td>
                <?php
                    echo $row['datetime'];
                ?>
            </td>
        </tr>
    <?php
            }
    ?>
    </table>
</div>
<?php
    footer();
?>