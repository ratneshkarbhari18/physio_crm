<?php


    include '../../includes/db.php';



    $name = $_POST["name"];
    $id = $_POST["id"];
    $amount = $_POST["amount"];
    $month = $_POST["month"];
    $date = $_POST["date"];
    $mode = '{"mode":"cash"}';

     $query = "UPDATE docsal SET name='$name', nop='0', amount='$amount', mode='$mode', month='$month' , date='$date' WHERE id='$id'";

    
    if (mysqli_query($conn,$query)) {
        header("Location:".$app_url."billing/edit_docsal_voucher.php?id='$id'");
    } else {
        echo $conn -> error;
        echo 'not done';
    }