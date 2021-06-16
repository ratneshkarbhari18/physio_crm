<?php

    include '../../includes/db.php';


    $bank_name = $_POST["bank_name"];
    $amount = $_POST["amount"];
    $date = $_POST["date"];
    $transaction = $_POST["transaction"];

    $query = "INSERT INTO fd_vouchers(transaction,amount,date,bank) VALUES('$transaction','$amount','$date','$bank_name')";

    $inserted = mysqli_query($conn,$query);

    if ($inserted) {
        header("Location:".$app_url."billing/add-new-fd-voucher.php");
    }