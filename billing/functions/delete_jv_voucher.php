<?php

    echo $id = $_POST["id"];


    include '../../includes/db.php';

    $query="Delete from jv where id=$id";

    $done = mysqli_query($conn,$query);

    if ($done) {
        header("Location:".$app_url."billing/jv-vouchers.php");
    }else {
        echo $conn->error;
    }
