<?php
    session_start();
    $_SESSION['billing_id'] = null;
    $_SESSION['billing_name'] = null;
    $_SESSION['billing'] = false;
    $msg = "You are successfully logged out";
    header("location:index.php?msg=$msg");
?>