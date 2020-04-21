
<?php

    if(!isset($_SESSION['login_user'])){
       header("location:index.php");
       $login_session = ":(";
       die();
    }
    
     $login_session = $_SESSION['login_user'];
?>
