<?php

    echo $id = $_POST["id"];


    include '../../includes/db.php';

    $query="Delete from ad where id=$id";

    $done = mysqli_query($conn,$query);

    if ($done) {
        header("Location:".$app_url."billing/ad-vouchers.php");
    }else {
        echo $conn->error;
    }
