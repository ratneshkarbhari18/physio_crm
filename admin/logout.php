<?php
    session_start();
    $_SESSION['admin_id'] = null;
    $_SESSION['admin_name'] = null;
    $_SESSION['admin'] = false;
    $msg = "You are successfully logged out";
    header("location:index.php?msg=$msg");
?>