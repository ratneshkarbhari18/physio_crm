<?php

$opening = $_GET["opening"];
$balance = $_GET["balance"];
$credit = $_GET["credit"];
$debit = $_GET["debit"];
$date = $_GET["date"];

$query="INSERT INTO `cashbook` (`opening`, `balance`,`credit`,`debit`, `date`) VALUES ('$opening', '$balance','$credit','$debit', '$date')";
if(mysqli_query($conn,$query)){
    return TRUE;
}