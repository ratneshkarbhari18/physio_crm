<?php
    session_start();
    $_SESSION['reports_id'] = null;
    $_SESSION['reports_name'] = null;
    $_SESSION['reports'] = false;
    $msg = "You are successfully logged out";
    header("location:index.php?msg=$msg");
?>