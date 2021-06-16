<?php


    include '../../includes/db.php';

    $date = $_POST["date"];
    $name = $_POST["name"];
    $amount = $_POST["amount"];
    $amount_word = $_POST["amount_word"];
    $mode = '{"mode":"cash"}';
    $id=$_POST["id"];

    $query = "UPDATE ad SET name='$name', amount='$amount', mode='$mode', date='$date' WHERE id=$id";

    
    if (mysqli_query($conn,$query)) {
        header("Location:".$app_url."billing/edit_ad_voucher.php?id=$id");
    } else {
        echo $conn -> error;
        echo 'not done';
    }