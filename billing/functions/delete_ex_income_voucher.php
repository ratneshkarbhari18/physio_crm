<?php

    echo $id = $_POST["id"];


    include '../../includes/db.php';

    $query="Delete from ex_income where id=$id";

    $done = mysqli_query($conn,$query);

    if ($done) {
        header("Location:".$app_url."/ex-income-vouchers.php");
    }else {
        echo $conn->error;
    }