<?php
include '../includes/session.php';
include '../../includes/db.php';
$success = false;
$msg = "There was problem";
if(check()){
	$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	$p_id = $_POST['id'];
	$base = json_encode(array("id"=>(int)$_POST['base-treatment'],"bed"=>(int)$_POST['base-bed'],"time"=>(int)$_POST['base-time']));
	$treatments = array();
	if( isset($_POST['bed']) && isset($_POST['time'])){
		
		$t = array_keys($_POST['bed']);
		foreach($t as $i){
			$tmp = array("id"=>(int)$i,"bed"=>(int)$_POST['bed'][$i],"time"=>(int)$_POST['time'][$i]);
			array_push($treatments,$tmp);
		}
	}
	$treatments = json_encode($treatments);
	$doc_id = $_SESSION['doctor_id'];
	$r_doc_id = $_POST['doc-id'];
	$doc_present = isset($_POST['doc_present']) ? 1 : 0;
	$query = "INSERT INTO reports(p_id,base_treatment,treatments,r_doc_id,doc_id,doc_present) VALUES($p_id,'$base','$treatments',$r_doc_id,$doc_id,$doc_present)";
	if(mysqli_query($conn,$query)){
		$success = true;
		$msg = "Report was successfully added";
	}
}else{
	$msg = "Invalid Session";
}
display($success,$msg);
function display($success, $msg){
	die(json_encode(array("success"=>$success, "msg"=>$msg)));
}
?>