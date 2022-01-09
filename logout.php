<?php
    session_start();
    session_destroy();
    session_unset();
    unset($_SESSION['username']);
    header("Location:index.php");
?>