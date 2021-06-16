<?php

    include '../../includes/db.php';


    $asset = $_POST["asset"];
    $amount = $_POST["amount"];
    $date = $_POST["date"];

    $query = "INSERT INTO asset_purchase_vouchers(asset,amount,date) VALUES('$asset','$amount','$date')";

    $inserted = mysqli_query($conn,$query);

    if ($inserted) {
        header("Location:".$app_url."billing/add-new-asset-purchase-voucher.php");
    }