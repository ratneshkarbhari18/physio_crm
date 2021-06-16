<?php
include '../includes/session.php';
include '../../includes/db.php';
$success = false;
$msg = "There was problem";
//echo "haskj";
if(check()){
	$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	$p_id = $_POST['id'];
	$bid=$_POST['base-treatment'];
	//echo date('H:i:s');
	//var_dump ($_POST['add']);
	$q='select machines,max_time from treatments where id='.$bid;
	//echo $q.'<br>';
	$r=mysqli_query($conn,$q);
	$row=mysqli_fetch_array($r);
	$bedn=checkavail($row['machines'],$row['max_time']);
	//echo $bedn.'<br>';
	$base = json_encode(array("id"=>(int)$_POST['base-treatment'],"machine"=>(int)$bedn,"time"=>(int)$_POST['base-time']));
	//echo $base.'<br>';
	$treatments = array();
	/*if( isset($_POST['bed']) && isset($_POST['time'])){

		$t = array_keys($_POST['bed']);
		foreach($t as $i){
			$tmp = array("id"=>(int)$i,"bed"=>(int)$_POST['bed'][$i],"time"=>(int)$_POST['time'][$i]);
			array_push($treatments,$tmp);
		}
	}*/

	
	foreach ($_POST['add'] as $i)
	{
		$q='select machines,max_time from treatments where id='.$i;
		//echo $q.'<br>';
		$r=mysqli_query($conn,$q);
		$row=mysqli_fetch_array($r);
		$bedn=checkavail($row['machines'],$row['max_time']);
		$tmp = array("id"=>(int)$i,"machine"=>(int)$bedn,"time"=>(int)$_POST['time'][$i]);
			array_push($treatments,$tmp);
	}
	$treatments = json_encode($treatments);
	//echo $treatments;
	$doc_id = $_SESSION['doctor_id'];
	$r_doc_id = $_POST['doc-id'];
	$rname=$_POST['rdname'];
	$rphone=$_POST['rdphone'];
	$date = $_POST["date"];
	if(!empty($rname)){
	    $rphone=empty($rphone)?0:$rphone;
	    echo $sqlr="insert into referring_doc(name,mobile) values('$rname','$rphone')";
	    //echo($sqlr);
	    // mysqli_query($conn,$sqlr);
	$r_doc_id=mysqli_insert_id($conn);
	}
	$r_doc_id=empty($r_doc_id)?0:$r_doc_id;
	$doc_present = isset($_POST['other']) ? 0 : 1;
	$other=isset($_POST['other']) ? 1 : 0;
	$dateTimeStamp = $date.' '.date("H:i:s");
	$mode ='{"mode":"cash"}';
	$query = "INSERT INTO reports(p_id,base_treatment,treatments,r_doc_id,doc_id,doc_present,other,covid,time_stamp,paid,pay_time,payment_details) VALUES($p_id,'$base','$treatments','$r_doc_id','$doc_id','$doc_present','$other',10,'$dateTimeStamp','1','$date','$mode')";
	
	if(mysqli_query($conn,$query)){
		echo 'Success';
		// header('Location: add-report.php');
		echo '<script>window.location = "../search_patient.php";</script>';
	}else {
		echo 'Failure, Error: '.mysqli_error($conn);
	}

}else{
	$msg = "Invalid Session";
}
function checkavail($b,$mt){
	global $conn;
	$barr=explode(',',$b);
	//var_dump($barr);
	$k=array_rand($barr,1);
	$val=$barr[$k];
	return $val;
}
?>
