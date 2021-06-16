<?php


    include '../../includes/db.php';



    $id = $_POST["id"];
    $name = $_POST["name"];
    $id = $_POST["id"];
    $type = $_POST["type"];
    $vdate = $_POST["vdate"];
    $amount = $_POST["amount"];
    $purpose = $_POST["purpose"];
    $date = $_POST["date"];
    $mode = '{"mode":"cash"}';

    $query = "UPDATE bank SET name='$name', bank_name='$bank_name' , type='$type', vdate='$vdate', amount='$amount', purpose='$purpose', mode='$mode', date='$date', vdate='$vdate' WHERE id='$id'";

    
    if (mysqli_query($conn,$query)) {
        header("Location:".$app_url."billing/edit_bank_voucher.php?id='$id'");
    } else {
        echo $conn -> error;
        echo 'not done';
    }