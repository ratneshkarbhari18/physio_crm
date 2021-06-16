<?php
include '../includes/session.php';
include '../../includes/db.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql="select * from reports where id=$id";
    $r1=mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($r1);
    $p_id=$row['p_id'];
    $r_doc_id=$row['r_doc_id'];
    $doc_id=$_SESSION['doctor_id'];
    $doc_present=$row['doc_present'];
    $base=$row['base_treatment'];
    $treatments=$row['treatments'];
    $covid=$row['covid'];
    $other=$row['other'];
    $query = "INSERT INTO reports(p_id,base_treatment,treatments,r_doc_id,doc_id,doc_present,other,covid) VALUES($p_id,'$base','$treatments',$r_doc_id,$doc_id,$doc_present,'$other',$covid)";
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
      header("Location:../view-history.php");
  		   // Process your response here
  		   ///echo $response;
  	}
  }
 ?>
