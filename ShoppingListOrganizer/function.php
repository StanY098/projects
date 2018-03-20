<?php
    function navMade($link, $navName, $subtitle){
?>
<?php
        if($navName == $subtitle){
            if($navName == "Update Account" || $navName == "Delete Account" || $navName == "Logout"){
                ?>
                <li id="nav_normal" class="submenu">
                <a><?php echo $navName ?></a>
                </li>
                <?php
            }
            else {
            ?>
            <li id="nav_normal" class="on_the_page">
            <a><?php echo $navName ?></a>
            </li>
            <?php
            }
        }
        else if($link == ""){
            ?>
            <li id="bigger"><a><?php echo $navName ?></a></li>
            <?php
        }
        else {
            if($navName == "Update Account" || $navName == "Delete Account" || $navName == "Logout"){
                ?>
                <li id="nav_normal" class="submenu">
                <a href=<?php echo $link ?>><?php echo $navName ?></a>
                </li>
                <?php
            }
            else {
            ?>
            <li id="nav_normal" class="second_menu"><a href=<?php echo $link ?>><?php echo $navName ?></a></li>
            <?php
            }
        }
?>
        
<?php
    }
    function nav($subtitle){
        if(isset($_SESSION['id'])){
?>
        
        <ul id="list">
            <li id="second_nav_description">Go To:</li>
<?php
            navMade("home.php", "HOME", $subtitle);
            navMade("list.php", "YOUR LIST", $subtitle);
            navMade("shoplist.php", "SHOP LINKS", $subtitle);
            navMade("history.php", "HISTORY", $subtitle);
?>
        </ul>
<?php
        }
    }
    function user_nav($subtitle){
        if(isset($_SESSION['id'])){
?>
        <ul id="account">
<?php
            navMade("","ACCOUNT", $subtitle);
            navMade("user_update.php","Update Account", $subtitle);
            navMade("user_delete.php","Delete Account", $subtitle);
            navMade("logout.php", "Logout", $subtitle);
?>
        </ul>
<?php
        }
    }
    function connectDB(){
        mysql_connect("localhost","dastan","zgmfx10a2056118");
        mysql_select_db("dastan_shoppinglist");
    }
    function login($id,$email){
        $_SESSION['id'] = $id;
        $_SESSION['email'] = $email;
        header('location: home.php');
    }
    function logout(){
        unset($_SESSION['id']);
        unset($_SESSION['email']);
        header('location: index.php');
    }
    function loginned(){
        if(!isset($_SESSION['id'])){
            $_SESSION['flash'] = "You haven't loginned yet. Please login first.";
            header('location: index.php');
        }
    }
    function has_Session(){
        if(isset($_SESSION['id'])){
            header('location: home.php');
        }
    }
    function authenticate($user_id,$item_id){
        $query = "SELECT * FROM itemlist WHERE item_id='$item_id'";
        $result = mysql_query($query);
        $user = mysql_fetch_assoc($result);
        $admin_id = 1;
        if($user_id != $user['user_id'] && $user_id != $admin_id){
            $_SESSION['message'] = "The item you requested does not belong to you.<br>";
            header('location: list.php');
            return false;
        }
        return true;
    }
    function welcome(){
        if($_SESSION['message'] == "signup"){
            //if signup, show instruction
            ?>
            <div id="message" name="message">
                <div id="instruction_title">
                    What You Can Do Here
                </div>
                <div id="instruction_list">
                    list (under Your List) - a list of your wanted items<br>
                    possible shops (under Shop Link) - a list of possible shop links<br>
                    transfer (under Your List -> Transfer button) - transfer your items to another user<br>
                    copy (under Your List -> Copy to... buttion) - copy your items' information to another user<br>
                    reminder (under Home) - remind you those items needed to do in a week<br>
                </div>
            </div>
            <?php
        }
        else {
            //if not, welcome user coming back
            ?>
            <div id="message" name="message">
                <div id="instruction_title">
                    Welcome back!
                </div>
            </div>
            <?php
        }
        $_SESSION['message'] = "";
    }
    function user_form($email,$emailError,$passwordError,$confirmError,$status){
        $value = "";
        if($status == "login"){
            $value = "Login";
            $action = "index.php";
        }
        elseif($status == "Sign Up"){
            $value = "Sign Up";
            $action = "signup.php";
        }
        else {
            $value = "Update Account";
            $action = "user_update.php";
        }
    ?>
    <div id="user_form">
        <form action='<?php echo $action ?>' method="post">
            <?php
                if($status == "Sign Up"){
            ?>
            <div class="form_fill">
            <?php
                 echo "Password Minimum requirement:<br>a number<br>a lowercase letter<br>at least 5 characters long<br><br>";
            ?>
                <span id="special_note_on_sign_up">
                <?php
                    echo "***NOTE: we strongly recommend you to choose a strong password (at least 8 characters long, including a uppercase letter, a lowercase letter, a number, a symbol).<br>We WILL NOT HOLD ACCOUNTABLE if your account gets hacked.***<br><br><br>";
                ?>
                </span>
            </div>
            <?php
                }
            ?>
            <div class="form_fill">
                 <label class="<?php echo ($emailError) ? bold : normal ?>">
                    Email:
                </label>
                <input type="email" name="email" placeholder="1234@example.com" value='<?php echo $email ?>' >
            </div>
            <div class="form_fill">
                <label class="<?php echo ($passwordError) ? bold : normal ?>">
                    Password:
                </label>
                <input type="password" name="password">
            </div>
                <?php
                if($status != "login"){
                ?>
                    <div class="form_fill">
                        <label class="<?php echo ($confirmError) ? bold : normal ?>">
                            Reconfirm Password:
                        </label>
                        <input type="password" name="reconfirm" >
                    </div>
                <?php
                }
                ?>
            <div class="form_fill">
                <input id="submit" type="submit" value='<?php echo $value ?>'>
            </div>
            <?php
            if($status == "login"){
            ?>
            <div id="forgot_password">
                <a href="email_requirement.php">Forgot Password?</a> <a href="signup.php">Need An Account?</a>
            </div>
            <?php
            }
            else {
                if($status != "update"){
            ?>
            <div id="forgot_password">
                <a href="index.php">Already Have An Account?</a>
            </div>
            <?php
                }
            }
            ?>
        </form>
    </div>
    <?php
    }
    function item_form($id,$name,$nameError,$amount,$numberError,$brand,$date,$dateError,$dateSelectionError,$status){
        $value = "";
        if($status == "new"){
            $value = "CREATE";
            $action = "item_new.php";
        }
        else {
            $value = "UPDADTE";
            $action = "item_update.php?id=".$id;
        }
?>
        <div id="item_form">
            <form action='<?php echo $action ?>' method="post">
                <div class="form_fill">
                    <label>
                        ITEM NAME
                    </label>
                    <input type="text" name="name" value='<?php echo $name ?>' placeholder="e.g. Apple" class="<?php echo ($nameError) ? bold : normal; ?>" />
                </div>
                <div class="form_fill">
                    <label>
                        AMOUNT
                    </label>
                    <input type="number" name="number" step="0.0001" min="0.0001" value='<?php echo $amount ?>' class="<?php echo ($numberError) ? bold : normal; ?>" placeholder="Up to 4 decimal digits" />
                </div>
                <div class="form_fill">
                    <label>
                        BRAND
                    </label>
                    <input type="text" name="brand" value='<?php echo $brand ?>' placeholder="The brand (if unknown, type unknown)" />
                </div>
                <div class="form_fill">
                    <label>
                        DUE DATE
                    </label>
                    <input type="date" name="due_date" value='<?php echo $date ?>' class="<?php echo ($dateError || $dateSelectionError) ? bold : normal; ?>" />
                </div>
                <div class="form_fill">
                    <input id="submit" type="submit" value='<?php echo $value ?>' />
                </div>
            </form>
        </div>
<?php
    }
    function add_item_history($id,$state){
        $item_query = "SELECT * FROM itemlist WHERE item_id='$id'";
        $result = mysql_query($item_query);
        $item = mysql_fetch_assoc($result);
        $name = $item['item_name'];
        $amount = $item['item_amount'];
        $brand = $item['item_brand'];
        $date = $item['due_date'];
        $now = date('Y-m-d H:i:s');
        $user_id = $_SESSION['id'];
        $status = "";
        if($state == "delete"){
            $status = "Item Deleted";
        }
        elseif($state == "update"){
            $status = "Item Updated";
        }
        else {
            $status = "Item Created";
        }
        $history_query = "INSERT INTO history (item_id,item_name,item_amount,item_brand,due_date,status,user_id,datetime) VALUES ('$id','$name','$amount','$brand','$date','$status','$user_id','$now');";
        $history_result = mysql_query($history_query);
    }
    function add_user_history($id,$state){
        $user_query = "SELECT * FROM user WHERE user_id='$id'";
        $result = mysql_query($user_query);
        $user = mysql_fetch_assoc($result);
        $email = $user['email'];
        $now = date('Y-m-d H:i:s');
        $status = "";
        if($state == "login"){
            $status = "User login";
        }
        elseif($state == "signup"){
            $status = "User signup and login";
        }
        elseif($state == "logout"){
            $status = "User logout";
        }
        elseif($state == "email") {
            $status = "User email changed";
        }
        else {
            $status = "User password changed";
        }
        $history_query = "INSERT INTO history (status,user_id,user_email,datetime) VALUES ('$status','$id','$email','$now');";
        $history_result = mysql_query($history_query);
    }
    function token_generator(){
        $char = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","1","2","3","4","5","6","7","8","9","0");
        $char_count = count($char);
        $pass = false;
        while(!$pass){
            $wc = 0;
            $token = "";
            while($wc < $char_count){
                $rand_num = rand(0,$char_count-1);
                $token .= $char[$rand_num];
                $wc++;
            }
            $token_check = "SELECT * FROM reset_token WHERE token='$token'";
            $check_result = mysql_query($token_check);
            if(!$check_result){
                echo mysql_error();
                exit();
            }
            if(mysql_num_rows($check_result) == 0){
                $pass = true;
            }
        }
        return $token;
    }
    function notification(){
    ?>
        <script language="javascript">
            Notification.requestPermission();
            if (!("Notification" in window)) {
                alert("This browser does not support system notifications");
              }
            
              // Let's check whether notification permissions have already been granted
              else if (Notification.permission === "granted") {
                // If it's okay let's create a notification
                var notification = new Notification("Hi there!");
                alert("Hi there");
              }
            
              // Otherwise, we need to ask the user for permission
              else if (Notification.permission !== 'denied') {
                Notification.requestPermission(function (permission) {
                  // If the user accepts, let's create a notification
                  if (permission === "granted") {
                    var notification = new Notification("Hi there!");
                    alert("Hi there");
                  }
                });
              }
            }
        </script>
<?php
    }
?>