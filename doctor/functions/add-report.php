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
	if(!empty($rname)){
	    $rphone=empty($rphone)?0:$rphone;
	    $sqlr="insert into referring_doc(name,mobile) values('$rname','$rphone')";
	    //echo($sqlr);
	    mysqli_query($conn,$sqlr);
	$r_doc_id=mysqli_insert_id($conn);
	}
	$r_doc_id=empty($r_doc_id)?0:$r_doc_id;
	$doc_present = isset($_POST['other']) ? 0 : 1;
	$other=isset($_POST['other']) ? 1 : 0;
	$query = "INSERT INTO reports(p_id,base_treatment,treatments,r_doc_id,doc_id,doc_present,other,covid) VALUES($p_id,'$base','$treatments',$r_doc_id,$doc_id,$doc_present,'$other',10)";
	//var_dump($query);
	if(mysqli_query($conn,$query)){
		$q1="select * from patients where id=".$p_id;
		$r1=mysqli_query($conn,$q1);
		$rw1=mysqli_fetch_assoc($r1);
		$q2="select * from users where id=".$doc_id;
		$r2=mysqli_query($conn,$q2);
		$rw2=mysqli_fetch_assoc($r2);
		$pname=$rw1['fname']." ".$rw1['lname'];
		// $textMessage="Respected / Dear Doctor\n
		// 				Thank You for referring your patient Mr./Ms. $p for the treatment to our physiotherapy centre.\n
		// 				If any suggestions, get back to us on our email: / phone:\n
		// 				-Attending physiotherapist Dr.".$rw2['name'];
		if($_SESSION['doctor_name']=="attented"){
		    $dr=$_POST['other'];
		}else{
						$dr="Dr. ".$rw2['name'];
		}
						$e="sayhello@sgsphysiotherapycentre.com";
						$p="9619682244";
		$q3="select mobile from referring_doc where id=".$r_doc_id;
		$r3=mysqli_query($conn,$q3);
		$rw3=mysqli_fetch_assoc($r3);
		$mobileNumber=$rw3['mobile'];
		//echo $mobileNumber;
		$apiKey = urlencode('37fE7BNgQVg-J4YbtGOZwUy2IG3zLvFKTml3Gjygmz');

		   // Message details
		   $numbers = array($mobileNumber);
		   $sender = urlencode('SGUPHY');
			 $message = rawurlencode("Respected/Dear Doctor,
Thank you for referring your patient Mr./Ms. $pname to our physiotherapy centre. If any suggestion get back to us on our email: $e and phone: $p .
Attending physiotherapist $dr");
//echo $dr;
		   $numbers = implode(',', $numbers);
		   // Prepare data for POST request
		   $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
		   // Send the POST request with cURL
		   $ch = curl_init('https://api.textlocal.in/send/');
		   curl_setopt($ch, CURLOPT_POST, true);
		   curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		   $response = curl_exec($ch);
		   curl_close($ch);
		$success = true;
		$msg = "Report was successfully added";

		   // Process your response here
		   ///echo $response;
	}
	else{
	    $success = false;
        $msg = "There was problem";
	}
}else{
	$msg = "Invalid Session";
}
display($success,$msg);
function display($success, $msg){
	die(json_encode(array("success"=>$success, "msg"=>$msg)));
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
