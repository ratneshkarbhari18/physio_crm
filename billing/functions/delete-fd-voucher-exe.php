<?php

    echo $id = $_POST["id"];


    include '../../includes/db.php';

    $query="Delete from fd_vouchers where id=$id";

    $done = mysqli_query($conn,$query);

    if ($done) {
        header("Location:".$app_url."billing/fd-vouchers.php");
    }else {
        echo $conn->error;
    }
