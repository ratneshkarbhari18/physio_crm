<?php

    $record_id = $_POST["id"];


    include '../includes/db.php';

    $query="Delete from consultant where id=$record_id";

    $done = mysqli_query($conn,$query);

    if ($done) {
        header("Location:cons_bills.php");
    }
