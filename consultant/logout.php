<?php
    session_start();
    $_SESSION['doctor_id'] = null;
    $_SESSION['doctor_name'] = null;
    $_SESSION['doctor'] = false;
	session_destroy();
    $msg = "You are successfully logged out";
    header("location:index.php?msg=$msg");
?>