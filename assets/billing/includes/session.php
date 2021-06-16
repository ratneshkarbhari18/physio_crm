<?php
    session_start();
    function redirect(){
        if(!isset($_SESSION['billing_id']) || !isset($_SESSION['billing_name']) || !$_SESSION['billing']){
            $msg = "You must login first"; 
            header("location:index.php?msg=$msg");
        }
    }
    function check(){
        if(isset($_SESSION['billing_id']) && isset($_SESSION['billing_name']) && $_SESSION['billing']){
            return true;
        }else{
            return false;
        }
    }
?>