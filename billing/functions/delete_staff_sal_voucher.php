<?php

    $id = $_POST["id"];


    include '../../includes/db.php';

    $query="Delete from staffsal where id=$id";

    $done = mysqli_query($conn,$query);

    if ($done) {
        header("Location:".$app_url."billing/staff-sal-vouchers.php");
    }else {
        echo $conn->error;
    }
