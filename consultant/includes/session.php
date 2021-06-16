<?php
    session_start();
    function redirect(){
        if(!isset($_SESSION['doctor_id']) || !isset($_SESSION['doctor_name']) || !$_SESSION['doctor']){
            $msg = "You must login first"; 
            header("location:index.php?msg=$msg");
        }
    }
    function check(){
        if(isset($_SESSION['doctor_id']) && isset($_SESSION['doctor_name']) && $_SESSION['doctor']){
			//echo "true";
            return true;
        }else{
			//echo "false";
            return false;
        }
    }
?>