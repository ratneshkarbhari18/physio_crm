<?php


    include '../../includes/db.php';


    $name = $_POST["name"];
    $des = $_POST["des"];
    $date = $_POST["date"];
    $cost = $_POST["cost"];
    $mode = '{"mode":"cash"}';
    $id=$_POST["id"];

    $query = "UPDATE ex_income SET name='$name', des='$des', cost='$cost', mode='$mode', date='$date' WHERE id=$id";

    
    if (mysqli_query($conn,$query)) {
        header("Location:".$app_url."billing/edit_ex_income_voucher.php?id=$id");
    } else {
        echo $conn -> error;
        echo 'not done';
    }