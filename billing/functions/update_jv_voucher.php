<?php


    include '../../includes/db.php';

    $date = $_POST["date"];
    $payee = $_POST["payee"];
    $purpose = $_POST["purpose"];
    $amount = $_POST["amount"];
    $amount_word = $_POST["amount_word"];

    $mode = '{"mode":"cash"}';
    $id=$_POST["id"];

    $query = "UPDATE jv SET payee='$payee',purpose='$purpose', amount='$amount', amount_word='$amount_word', mode='$mode', date='$date' WHERE id=$id";

    
    if (mysqli_query($conn,$query)) {
        header('Location: '.$app_url.'billing/edit_jv_voucher.php?id='.$id);
    } else {
        echo $conn -> error;
        echo 'not done';
    }