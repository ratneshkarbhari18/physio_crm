<?php
    session_start();
    function redirect(){
        if(!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']) || !$_SESSION['admin']){
            $msg = "You must login first"; 
            header("location:index.php?msg=$msg");
        }
    }
    function check(){
        if(isset($_SESSION['admin_id']) && isset($_SESSION['admin_name']) && $_SESSION['admin']){
            return true;
        }else{
            return false;
        }
    }
?>