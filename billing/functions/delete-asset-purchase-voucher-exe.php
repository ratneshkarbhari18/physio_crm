<?php

    echo $id = $_POST["id"];


    include '../../includes/db.php';

    $query="Delete from asset_purchase_vouchers where id=$id";

    $done = mysqli_query($conn,$query);

    if ($done) {
        header("Location:".$app_url."billing/asset-purchase-vouchers.php");
    }else {
        echo $conn->error;
    }
