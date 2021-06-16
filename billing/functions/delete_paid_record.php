<?php

    $record_id = $_POST["record_id"];


    include '../../includes/db.php';

    $query="Delete from reports where id=$record_id";

    $done = mysqli_query($conn,$query);

    if ($done) {
        header("Location:".$app_url."billing/paid.php");
    }
