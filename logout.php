<?php
    session_start();
    session_destroy();

    echo"You have logged out successfully";

    header("refresh: 2; url=login.php");
?>