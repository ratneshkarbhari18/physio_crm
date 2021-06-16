<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include '../includes/session.php';
include '../../includes/db.php';

$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
//echo $_REQUEST['from'];
if(is_not_empty($_REQUEST['from'])){
  $from =$_REQUEST['from'];
  //echo $from;
  //$to = date_format(date_create_from_format("d/m/Y",$_REQUEST['to']),'Y-m-d');
  $query = "select SUM(amount)as am,type from vouchers where YEAR(date)=".$from." group by type";
}else{
    //echo "ff";
  //die("Please select both dates");
}

$result = mysqli_query($conn, $query);  


if(isset($_GET['action']) && $_GET['action']=="download"){
    //echo "ff";
  require "../../vendor/autoload.php";
  $spreadsheet = new Spreadsheet();
  $ly=$_REQUEST['from']-1;
  $d=$_REQUEST['from'];
  $ft=0;
    $ftly=0;
    $fti=0;
    $ftlyi=0;
  $op=array("Printing and stationary",
                                "Electricity Bill",
                                "Other Expense",
                                "Repairing",
                                "Medicine",
                                "Traveling",
                                "Clothes washing and buying",
                                "Snacks",
                                "Cleaning",
                                "Telephone",
                                "Accounting Charge",
                                "Rent",
                               "Advertisement",
                                "Festivals / Programs",
                                "Insurance Policies / Taxes",
                                "BankOverDraft");
  $sheet = $spreadsheet->getActiveSheet();
  $sheet->getColumnDimension('A')->setWidth(20);
  $sheet->getColumnDimension('B')->setWidth(40);
  $sheet->getColumnDimension('C')->setWidth(20);
  $sheet->getColumnDimension('D')->setWidth(20);
  $sheet->getColumnDimension('E')->setWidth(40);
  $sheet->getColumnDimension('F')->setWidth(20);
  $sheet->setTitle('Balance Sheet');
  $sheet->setCellValue('A5', $ly);
  $sheet->setCellValue('B5', 'Expences');
  $sheet->setCellValue('C5', $_REQUEST['from']);
  $sheet->setCellValue('D5', $ly);
  $sheet->setCellValue('E5', 'Income');
  $sheet->setCellValue('F5', $_REQUEST['from']);
  $sheet->setCellValue('A1', 'Report Type: ');
  $sheet->setCellValue('B1', 'Balance Sheet');
  $sheet->setCellValue('A2', 'Year: ');
  $sheet->setCellValue('B2', $_REQUEST['from']);
      
    $queryly="select * from docsal where  YEAR(date)=".$ly."";
	$resly=mysqli_query($conn,$queryly);
	$salydly=0;
	$salysly=0;
	$n=mysqli_num_rows($resly);
	//echo $n;
	while($rly=mysqli_fetch_array($resly)){
		 $payd=json_decode($rly['mode'],true);
		$salydly=$salydly + $rly['amount'];
	}
	$ftly=$salydly;
	$query1ly="select * from staffsal where  YEAR(date)=".$ly."";
	$res1ly=mysqli_query($conn,$query1ly);
	while($r1ly=mysqli_fetch_array($res1ly)){
			 $payd=json_decode($r1ly['mode'],true);
		
		$salysly=$salysly + $r1ly['ns'];

	}
	$ftly=$ftly+$salysly;
	$query="select * from docsal where  YEAR(date)=".$d;
	$res=mysqli_query($conn,$query);
	$salyd=0;
	$salys=0;
	$n=mysqli_num_rows($res);
	//echo $n;
	while($r=mysqli_fetch_array($res)){
		 $payd=json_decode($r['mode'],true);
		$salyd=$salyd + $r['amount'];
	}
	$ft+=$salyd;
	$query1="select * from staffsal where  YEAR(date)=".$d;
	$res1=mysqli_query($conn,$query1);
	while($r1=mysqli_fetch_array($res1)){
			 $payd=json_decode($r1['mode'],true);
		
		$salys=$salys + $r1['ns'];

	}
	$ft+=$salys;
	
      $c = 6;
      $sheet->setCellValue('A'.$c, $salydly.' Rs');
      $sheet->setCellValue('B'.$c, 'Doctor Salary');
      $sheet->setCellValue('C'.$c, $salyd.' Rs');
      
      $c = 7;
      $sheet->setCellValue('A'.$c, $salysly.' Rs');
      $sheet->setCellValue('B'.$c, 'Staff Salary');
      $sheet->setCellValue('C'.$c, $salys.' Rs');
      
        $c=8;
    foreach($op as $i){
                                   
        $query5="select SUM(amount)as am,type from vouchers where YEAR(date)=".$ly." and type='".$i."' group by type";
	    $res5=mysqli_query($conn,$query5);
	    $r5=mysqli_fetch_array($res5);
	                                           
	    $query6="select SUM(amount)as am,type from vouchers where  YEAR(date)=".$d." and type='".$i."' group by type";
        $res6=mysqli_query($conn,$query6);
        $r6=mysqli_fetch_array($res6);
	    if($r5==null){
	    $sheet->setCellValue('A'.$c, '0 Rs');
	     }
	     else{
	      $sheet->setCellValue('A'.$c, $r5['am'].' Rs');
	    }
	    $sheet->setCellValue('B'.$c, $i);;
	    if($r6==null){
	        $sheet->setCellValue('C'.$c, '0 Rs');
	    }
	    else{
	        $sheet->setCellValue('C'.$c, $r6['am'].' Rs');
	    }
	    $ftly=$ftly + $r5['am'];
	    $ft=$ft + $r6['am'];
	    $c++;
    }
      $sheet->setCellValue('A'.$c, $ftly.' Rs');
      $sheet->setCellValue('C'.$c, $ft.' Rs');                              
      
      
      
      	$dony=0;
	$query2="select * from donations where  YEAR(payment_time)=".$d;
	$res2=mysqli_query($conn,$query2);
	while($r2=mysqli_fetch_array($res2)){
		$dony=$dony + $r2['amount'];
	
	}
    $fti+=$dony;
		$totaly=0;
		$q="select * from reports where  YEAR(pay_time)=".$d;
		$r=mysqli_query($conn,$q);
		$n=mysqli_num_rows($r);
		//echo $q;
		while($rw=mysqli_fetch_array($r)){
		$t = array(json_decode($rw['base_treatment'],true)['id']);
		$b = $t[0];
		if($rw['covid']==10){
		    $totaly+=10;
		}
		$array = json_decode($rw['treatments'],true);
		foreach($array as $i){
			array_push($t,$i['id']);
		}
		foreach($t as $i){
        $query = "SELECT * FROM treatments WHERE id=$i";
        
        $r2 = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($r2);
        if($b == $i){
            $a = $row["amount"];}
        else{
            $a = 10;}
        $first = true;    
        $totaly+=$a;
    }
    $totaly += 25;
    }
    $nf=0;
    $query = "select DISTINCT(p_id) from reports where  YEAR(pay_time)=".$d;
    $r1 = mysqli_query($conn,$query);
    if(mysqli_affected_rows($conn)>0){
        while($row = mysqli_fetch_array($r1)){
            $nf +=10;
		}
		}
		$fti+=$nf;
		$q10="select * from consultant where YEAR(date)=".$d;
		$r10=mysqli_query($conn,$q10);
		while($rw10=mysqli_fetch_array($r10)){
				$totaly=$totaly+$rw10['cost'];
				if($rw10['covid']==10){
		    $totaly+=10;
		}
		}
    $fti+=$totaly;
    $donly=0;
	$query2ly="select * from donations where  YEAR(payment_time)=".$ly."";
	$res2ly=mysqli_query($conn,$query2ly);
	while($r2ly=mysqli_fetch_array($res2ly)){
		$donly=$donly + $r2ly['amount'];
	
	}
    $ftlyi+=$donly;
		$totalyly=0;
		$qly="select * from reports where  YEAR(pay_time)=".$ly."";
		$rly=mysqli_query($conn,$qly);
		$nly=mysqli_num_rows($rly);
		//echo $q;
		while($rw=mysqli_fetch_array($rly)){
		$t = array(json_decode($rw['base_treatment'],true)['id']);
		if($rw['covid']==10){
		    $totalyly+=10;
		}
		$b = $t[0];
		$array = json_decode($rw['treatments'],true);
		foreach($array as $i){
			array_push($t,$i['id']);
		}
		foreach($t as $i){
        $query = "SELECT * FROM treatments WHERE id=$i";
        
        $r2 = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($r2);
        if($b == $i){
            $a = $row["amount"];}
        else{
            $a = 10;}
        $first = true;    
        $totalyly+=$a;
    }
    $totalyly += 25;
    }
    $nfly=0;
    $queryly = "select DISTINCT(p_id) from reports where  YEAR(pay_time)=".$ly."";
    $r1ly = mysqli_query($conn,$queryly);
    if(mysqli_affected_rows($conn)>0){
        while($row = mysqli_fetch_array($r1ly)){
            $nfly +=10;
		}
		}
		$ftlyi+=$nfly;
		$q10ly="select * from consultant where YEAR(date)=".$ly."";
		$r10ly=mysqli_query($conn,$q10);
		while($rw10=mysqli_fetch_array($r10ly)){
				$totalyly=$totalyly+$rw10['cost'];
					if($rw10['covid']==10){
		    $totalyly+=10;
		}
		}
	$ftlyi+=$totalyly;
      $c1=$c;
      $c=6;
      $sheet->setCellValue('D'.$c, $totalyly.' Rs');
      $sheet->setCellValue('E'.$c, 'Patient Collection');
      $sheet->setCellValue('F'.$c, $totaly.' Rs');
      
      $c=7;
      $sheet->setCellValue('D'.$c, $nfly.' Rs');
      $sheet->setCellValue('E'.$c, 'New Patient Fee');
      $sheet->setCellValue('F'.$c, $nf.' Rs');
      
      $c=8;
      $sheet->setCellValue('D'.$c, $donly.' Rs');
      $sheet->setCellValue('E'.$c, 'Donations');
      $sheet->setCellValue('F'.$c, $dony.' Rs');
     
      $sheet->setCellValue('D'.$c1, $ftlyi.' Rs');
      $sheet->setCellValue('F'.$c1, $fti.' Rs');                              
      

    
    $sheet->getStyle('A1:A3')->getFont()->setBold(true);
    $sheet->getStyle('A5:F5')->getFont()->setBold(true);
    // $sheet->getStyle('C'.$c)->getFont()->setBold(true);
  $writer = new Xlsx($spreadsheet);
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="balancesheet.xlsx"');
  header('Cache-Control: max-age=0');
  header('Expires: Fri, 11 Nov 2011 11:11:11 GMT');
  header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
  header('Cache-Control: cache, must-revalidate');
  header('Pragma: public');
  $writer->save('php://output');
}else{
  $resp = array();
  $success = false;
  if(mysqli_affected_rows($conn)>0){
    $url = "functions/export-bal.php?action=download&from=".$_REQUEST['from'];
    $resp['url'] = $url;
    $success = true;
  }
  $resp['success']=$success;
  die(json_encode($resp));
}

function calculate($id, $pid, $base, $other){
  $total = 0;
  $res = "";
  $data = array();
  global $conn;
  $t = array(json_decode($base,true)['id']);
  $b = $t[0];
  $array = json_decode($other,true);
  foreach($array as $i){
      array_push($t,$i['id']);
  }
  $first = false;
  foreach($t as $i){
      $query = "SELECT * FROM treatments WHERE id=$i";
      
      $r = mysqli_query($conn,$query);
      $row = mysqli_fetch_assoc($r);
      if($b == $i)
          $a = $row["amount"];
      else
          $a = 10;
      if($first){
          $res .= ", ";
      }
      $first = true;    
      $res .= $row["name"];
      $total+=$a;
  }
  $total += 25;
  $query = "SELECT MIN(id) FROM reports WHERE p_id=$pid";
  $r = mysqli_query($conn,$query);
  if(mysqli_affected_rows($conn)>0){
      $row = mysqli_fetch_array($r);
      if($id==$row[0]){
          $total +=10;
      }
  }
  $data['amount'] = $total;
  $data['treatments'] = $res;
  return $data;
}
function is_not_empty($str){
    //echo $str;
  return isset($str) && $str!="";
}
?>