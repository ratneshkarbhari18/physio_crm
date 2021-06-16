<?php

    $id = $_POST["id"];


    include '../../includes/db.php';

    $query="Delete from docsal where id=$id";

    $done = mysqli_query($conn,$query);

    if ($done) {
        header("Location:".$app_url."/docsal-vouchers.php");
    }else {
        echo $conn->error;
    }
