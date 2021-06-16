<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include '../includes/session.php';
include '../../includes/db.php';

$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if(is_not_empty($_REQUEST['from']) && is_not_empty($_REQUEST['to'])){
  $from = date_format(date_create_from_format("d/m/Y",$_REQUEST['from']),"Y/m/d");
  $to = date_format(date_create_from_format("d/m/Y",$_REQUEST['to']),"Y/m/d");

}else{
  die("Please select both dates");
}

  
 $q = "SELECT * FROM bank WHERE  date>='$from' AND date<='$to'";
 $r = mysqli_query($conn, $q);

if(isset($_GET['action']) && $_GET['action']=="download"){
  require "../../vendor/autoload.php";
  $spreadsheet = new Spreadsheet();
  
  $sheet = $spreadsheet->getActiveSheet();
  $sheet->getColumnDimension('A')->setWidth(20);
  $sheet->getColumnDimension('B')->setWidth(25);
  $sheet->getColumnDimension('C')->setWidth(40);
  $sheet->getColumnDimension('D')->setWidth(20);
  $sheet->getColumnDimension('E')->setWidth(10);
  $sheet->setTitle('Bank Report');
  $sheet->setCellValue('A5', 'Sr no.');
  $sheet->setCellValue('B5', 'Name Of AC Holder');
  $sheet->setCellValue('C5', 'AC no.');
  $sheet->setCellValue('D5', 'Bank Name And Branch');
  $sheet->setCellValue('E5', 'IFSC Code');
  $sheet->setCellValue('F5', 'Ammount ');
   $sheet->setCellValue('A1', 'Report Type: ');
  $sheet->setCellValue('B1', 'Bank Report');
  $sheet->setCellValue('A2', 'From Date: ');
  $sheet->setCellValue('B2', $_REQUEST['from']);
  $sheet->setCellValue('A3', 'To Date: ');
  $sheet->setCellValue('B3', $_REQUEST['to']);
    $c = 6;

        
       
        $count = mysqli_num_rows($r);
        $amount = 0;
        while($rw = mysqli_fetch_assoc($r)){
           
        
      $sheet->setCellValue('A'.$c, $rw['id']);
      $sheet->setCellValue('B'.$c, $rw['name']);
      $sheet->setCellValue('C'.$c, $rw['acno']);
      $sheet->setCellValue('D'.$c, $rw['bname']);
      $sheet->setCellValue('E'.$c, $rw['ifsc']);
	  $sheet->setCellValue('E'.$c, $rw['amount']);
      $c++;
		}

    $sheet->getStyle('A1:A3')->getFont()->setBold(true);
    $sheet->getStyle('A5:E5')->getFont()->setBold(true);
  $writer = new Xlsx($spreadsheet);
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="Bank.xlsx"');
  header('Cache-Control: max-age=0');
  header('Expires: Fri, 11 Nov 2011 11:11:11 GMT');
  header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
  header('Cache-Control: cache, must-revalidate');
  header('Pragma: public');
  $writer->save('php://output');
   if (ob_get_contents()) {
            ob_clean();
        }
}else{
  $resp = array();
  $success = false;
  if(mysqli_affected_rows($conn)>0){
    $url = "functions/export-bank.php?action=download&from=".$_REQUEST['from']."&to=".$_REQUEST['to'];
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
        }
    }
    return $total;
  }

function is_not_empty($str){
  return isset($str) && $str!="";
}
?>