<?php
include '../includes/session.php';
include '../../includes/db.php';
$success = false;
$msg = "There was a problem";
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(check()){
	$name=$_POST['name'];
	$nop=$_POST['nod'];
	$gs=$_POST['gs'];
	$ns=$_POST['ns'];
	$ad=$_POST['adm'];
	$mode = $_POST["mode"];
	$payment_details['mode'] = $mode;
	if($mode=="cheque"){
    $payment_details['bank'] = $_POST['bname'];
    $payment_details['branch'] = $_POST['branch'];    
    $payment_details['cheque_no'] = $_POST['cheque_no']; 
    $payment_details['cheque_date'] = $_POST['cheque_date']; 
}
	$pd = json_encode($payment_details);

    $success = false;
    $msg = "There was a problem";
    $id=0;
	$date=date("M");
	$date1=date("Y/m/d");
    $query = "INSERT INTO staffsal(name,nod,gs,ns,advan,mode,month,date) VALUES('$name','$nop','$gs','$ns','$ad','$pd','$date','$date1');";
	//var_dump($query);
	//var_dump(mysqli_query($conn,$query));
    if(mysqli_query($conn,$query)){
        $success = true;
        $msg = "Details was successfully added";
        $id = mysqli_insert_id($conn);
    }   
}else{	
    $msg = "Invalid Session";
}
display($success,$msg);
function display($success, $msg){
	die(json_encode(array("success"=>$success, "msg"=>$msg)));
}
?>