<?php
    session_start();

    //When a user logs out, seeion info is erased here and the user is redirected to the home page.
    if(isset($_SESSION["uid"])){
        echo "You are being logged out<br>";
        session_unset();
        session_destroy();
        echo "Logged out successfully<br>";
        header("Location: ../index.php");
    }
    else{
        header("Location: ../index.php");
    }
?>