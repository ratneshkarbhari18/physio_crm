<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include '../includes/session.php';
include '../../includes/db.php';

$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if(is_not_empty($_REQUEST['from']) && is_not_empty($_REQUEST['to'])){
  $from = date_format(date_create_from_format("d/m/Y",$_REQUEST['from']),'Y-m-d H:i:s');
  $to = date_format(date_create_from_format("d/m/Y",$_REQUEST['to']),'Y-m-d H:i:s');
  $query = "SELECT r.id, p.fname, p.lname, r.time_stamp, DATEDIFF(NOW(), r.time_stamp) AS age FROM reports r, patients p WHERE paid=0 AND r.p_id=p.id  AND r.time_stamp>='$from' AND r.time_stamp<='$to'";
}else{
  die("Please select both dates");
}

$result = mysqli_query($conn, $query);  


if(isset($_GET['action']) && $_GET['action']=="download"){
  require "../../vendor/autoload.php";
  $spreadsheet = new Spreadsheet();
  
  $sheet = $spreadsheet->getActiveSheet();
  $sheet->getColumnDimension('A')->setWidth(20);
  $sheet->getColumnDimension('B')->setWidth(40);
  $sheet->getColumnDimension('C')->setWidth(20);
  $sheet->getColumnDimension('D')->setWidth(10);
  $sheet->setTitle('Donations');
  $sheet->setCellValue('A5', 'Receipt No.');
  $sheet->setCellValue('B5', 'Patient Name');
  $sheet->setCellValue('C5', 'Date');
  $sheet->setCellValue('D5', 'Ageing');
  $sheet->setCellValue('A1', 'Report Type: ');
  $sheet->setCellValue('B1', 'Outstanding Report');
  $sheet->setCellValue('A2', 'From Date: ');
  $sheet->setCellValue('B2', $_REQUEST['from']);
  $sheet->setCellValue('A3', 'To Date: ');
  $sheet->setCellValue('B3', $_REQUEST['to']);
    $c = 6;

    while($row = mysqli_fetch_assoc($result)) {
      $sheet->setCellValue('A'.$c, $row['id']);
      $sheet->setCellValue('B'.$c, $row['fname']." ".$row["lname"]);
      $sheet->setCellValue('C'.$c, $row['time_stamp']);
      $sheet->setCellValue('D'.$c, $row['age']);
      $c++;
    }

    $sheet->getStyle('A1:A3')->getFont()->setBold(true);
    $sheet->getStyle('A5:D5')->getFont()->setBold(true);
  $writer = new Xlsx($spreadsheet);
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="Outstanding.xlsx"');
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
    $url = "functions/export-outstanding.php?action=download&from=".$_REQUEST['from']."&to=".$_REQUEST['to'];
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
  return isset($str) && $str!="";
}
?>