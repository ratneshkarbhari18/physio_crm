<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include '../includes/session.php';
include '../../includes/db.php';

$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if(is_not_empty($_REQUEST['from']) && is_not_empty($_REQUEST['to'])){
  $from = date_format(date_create_from_format("d/m/Y",$_REQUEST['from']),'Y-m-d');
  $to = date_format(date_create_from_format("d/m/Y",$_REQUEST['to']),'Y-m-d');
  $query = "SELECT * FROM users WHERE type='doctor'";
}else{
  die("Please select both dates");
}

$result = mysqli_query($conn, $query);  
$tef=0;
$new=0;
if(isset($_GET['action']) && $_GET['action']=="download"){
  require "../../vendor/autoload.php";
  $spreadsheet = new Spreadsheet();
  
  $sheet = $spreadsheet->getActiveSheet();
  $sheet->getColumnDimension('A')->setWidth(20);
  $sheet->getColumnDimension('B')->setWidth(35);
  $sheet->getColumnDimension('C')->setWidth(20);
  $sheet->getColumnDimension('D')->setWidth(20);
  $sheet->getColumnDimension('E')->setWidth(20);
  $sheet->getColumnDimension('F')->setWidth(20);
  $sheet->getColumnDimension('G')->setWidth(20);
  $sheet->getColumnDimension('H')->setWidth(25);
  $sheet->getColumnDimension('I')->setWidth(25);
  $sheet->getColumnDimension('J')->setWidth(25);
  $sheet->getColumnDimension('K')->setWidth(25);
  $sheet->getColumnDimension('L')->setWidth(25);
  $sheet->setTitle('Doctors');
  $sheet->setCellValue('A5', 'Doctor ID');
  $sheet->setCellValue('B5', 'Doctor Name');
  $sheet->setCellValue('C5', 'No. Of Patients');
  $sheet->setCellValue('D5', 'Total Enterance Fee');
  $sheet->setCellValue('E5', 'Patients Visit');
  $sheet->setCellValue('F5', 'Redevelopment Fee');
  $sheet->setCellValue('G5', 'COVID-19 Fee');
  $sheet->setCellValue('H5', 'Treatment Cost');
  $sheet->setCellValue('I5', 'Total Amount');
  $sheet->setCellValue('J5', 'Percentage');
  $sheet->setCellValue('K5', 'Doctor Shared Amount');
  $sheet->setCellValue('L5', 'Centre Shared Amount');
  $sheet->setCellValue('A1', 'Report Type: ');
  $sheet->setCellValue('B1', 'Summary Report');
  $sheet->setCellValue('A2', 'From Date: ');
  $sheet->setCellValue('B2', $_REQUEST['from']);
  $sheet->setCellValue('A3', 'To Date: ');
  $sheet->setCellValue('B3', $_REQUEST['to']);
    $c = 6;

    while($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $p=$row['doc_percent'];
        $per=$p/100;
        $covid=0;
        $q = "SELECT * FROM reports WHERE doc_id=$id AND paid=1 AND pay_time>='$from' AND pay_time<='$to'";
        $r = mysqli_query($conn, $q);
        $count = mysqli_num_rows($r);
        $np="SELECT * FROM `reports` where doc_id=$id AND paid=1 AND pay_time>='$from' AND pay_time<='$to' GROUP BY p_id";
        $nrp=mysqli_query($conn, $np);
        $count1 = mysqli_num_rows($nrp);
        //$tef=10*$count1;
        $red=25*$count;
        $amount = 0;
        while($rw = mysqli_fetch_assoc($r)){
            $amount+=calculate($rw['id'],$rw['p_id'],$rw['base_treatment'],$rw['treatments']);
            if($rw['covid']==10){
                       $covid+=10;
            }
        }
        $peram=$amount-$tef-$red;
      $sheet->setCellValue('A'.$c, $id);
      $sheet->setCellValue('B'.$c, $row['name']);
      $sheet->setCellValue('C'.$c, $new);
      $sheet->setCellValue('D'.$c, $tef);
      $sheet->setCellValue('E'.$c, $count);
      $sheet->setCellValue('F'.$c, $red);
      $sheet->setCellValue('G'.$c, $covid);
      $sheet->setCellValue('H'.$c, $peram);
      $sheet->setCellValue('I'.$c, $amount +$covid);
      $sheet->setCellValue('J'.$c, $p." %");
      $sheet->setCellValue('K'.$c, $peram*$per);
      $sheet->setCellValue('L'.$c, $peram -($peram*$per) +$covid+$tef+$red);
      $c++;
      $tef=0;
      $new=0;
      $covid=0;
    }
    $q1="select * from users where type='consultant'";
											$r1=mysqli_query($conn,$q1);
											$covid=0;
											while($rw=mysqli_fetch_array($r1)){
												$per=$rw['doc_percent']/100;
												 $id = $rw['id'];
												$q2 = "SELECT * FROM consultant WHERE doc_id=$id AND date>='$from' AND date<='$to' AND paid=1";
                                                    $r2 = mysqli_query($conn, $q2);
													 $count = mysqli_num_rows($r2);
													 $tef=25*$count;
													 $amount1 = 0;
													 while($rw2=mysqli_fetch_array($r2))
													 {
														 $amount1+=$rw2['cost'];
														   if($rw2['covid']==10){
                                                            $covid+=10;
                                                        }
													 }
													 $amount1 +=$tef;
													 $pera=$amount1-$tef;
													 $sheet->setCellValue('A'.$c, $id);
      $sheet->setCellValue('B'.$c, $rw['name']);
      $sheet->setCellValue('C'.$c, $count);
      $sheet->setCellValue('D'.$c, "0");
      $sheet->setCellValue('E'.$c, $count);
      $sheet->setCellValue('F'.$c, $tef);
      $sheet->setCellValue('G'.$c, $covid);
      $sheet->setCellValue('H'.$c, $pera);
      $sheet->setCellValue('I'.$c, $amount1 +$covid);
      $sheet->setCellValue('J'.$c, $rw['doc_percent']." %");
      $sheet->setCellValue('K'.$c, $pera*$per);
      $sheet->setCellValue('L'.$c, $pera -($pera*$per)+$covid+$tef);
      $c++;
     $covid=0; 
	}
    $sheet->getStyle('A1:A3')->getFont()->setBold(true);
    $sheet->getStyle('A5:L5')->getFont()->setBold(true);
  $writer = new Xlsx($spreadsheet);
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="Doctors.xlsx"');
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
    $url = "functions/export-doctor.php?action=download&from=".$_REQUEST['from']."&to=".$_REQUEST['to'];
    $resp['url'] = $url;
    $success = true;
  }
  $resp['success']=$success;
  die(json_encode($resp));
}

function calculate($id, $pid, $base, $other){
    $total = 0;
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
        $first = true;    
        $total+=$a;
    }
    $total += 25;
    $query = "SELECT MIN(id) FROM reports WHERE p_id=$pid";
    $r = mysqli_query($conn,$query);
    if(mysqli_affected_rows($conn)>0){
        $row = mysqli_fetch_array($r);
        if($id==$row[0]){
            $total +=10;
            $GLOBALS['tef'] +=10;
            $GLOBALS['new'] +=1;
        }
    }
    return $total;
  }

function is_not_empty($str){
  return isset($str) && $str!="";
}
?>