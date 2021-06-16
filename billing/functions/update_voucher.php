<?php


    include '../../includes/db.php';



    $id = $_POST["id"];

    $type = $_POST["type"];
    $convection = $_POST["convection"];
    $narration = $_POST["narration"];
    $amount = $_POST["amount"];
    $amount_word = $_POST["amount_word"];
    
    $date = $_POST["date"];

    $mode = '{"mode":"cash"}';

    $query = "UPDATE vouchers SET type='$type', convection='$convection', narration='$narration', amount='$amount', amount_word='$amount_word', mode='$mode', date='$date' WHERE id='$id'";

    
    if (mysqli_query($conn,$query)) {
        header('Location: '.$app_url.'billing/edit_voucher.php?id='.$id);
    } else {
        echo 'not done';
    }
    