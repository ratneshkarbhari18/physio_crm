<?php
include '../includes/session.php';
include '../../includes/db.php';
$query = "SELECT id FROM reports WHERE paid=b'0'";
$res = mysqli_query($conn,$query);
echo (mysqli_num_rows($res));
?>