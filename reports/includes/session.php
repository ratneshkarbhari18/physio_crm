<?php
    session_start();
    function redirect(){
        if(!isset($_SESSION['reports_id']) || !isset($_SESSION['reports']) || !$_SESSION['reports']){
            // $msg = "You must login first"; 
            // header("location:index.php?msg=$msg");
        }
    }
    function check(){
        if(isset($_SESSION['reports_id']) && isset($_SESSION['reports']) && $_SESSION['reports']){
            return true;
        }else{
            return false;
        }
    }
?>