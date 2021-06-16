<?php

    echo $id = $_POST["id"];


    include '../../includes/db.php';

    $query="Delete from bank where id=$id";

    $done = mysqli_query($conn,$query);

    if ($done) {
        header("Location:".$app_url."billing/bank-vouchers.php");
    }else {
        echo $conn->error;
    }
