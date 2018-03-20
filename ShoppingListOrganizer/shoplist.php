<?php
    session_start();
    require_once('function.php');
    //check if user already loginned
    loginned();
    require_once('header.php');
    require_once('footer.php');
    
    head("SHOP LINKS");
?>

<?php
    footer();
?>