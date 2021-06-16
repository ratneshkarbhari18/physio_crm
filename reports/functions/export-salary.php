<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include '../includes/session.php';
include '../../includes/db.php';

$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if(is_not_empty($_REQUEST['from']) && is_not_empty($_REQUEST['to'])){
  $from = date_format(date_create_from_format("d/m/Y",$_REQUEST['from']),'Y-m-d');
  $to = date_format(date_create_from_format("d/m/Y",$_REQUEST['to']),'Y-m-d');
  $query = "SELECT * FROM staffsal WHERE date>='$from' AND date<='$to'";
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
  $sheet->getColumnDimension('E')->setWidth(20);
  $sheet->getColumnDimension('F')->setWidth(20);
  $sheet->getColumnDimension('G')->setWidth(20);
  $sheet->getColumnDimension('H')->setWidth(20);
  $sheet->getColumnDimension('I')->setWidth(40);
  $sheet->setTitle('Donations');
  $sheet->setCellValue('A5', 'ID');
  $sheet->setCellValue('B5', 'Employee Name');
  $sheet->setCellValue('C5', 'Days');
  $sheet->setCellValue('D5', 'Month');
  $sheet->setCellValue('E5', 'Gross Salary');
  $sheet->setCellValue('F5', 'Net Salary');
  $sheet->setCellValue('G5', 'Advance');
  $sheet->setCellValue('H5', 'Payment Type');
  $sheet->setCellValue('I5', 'Payment Details');
  $sheet->setCellValue('A1', 'Report Type: ');
  $sheet->setCellValue('B1', 'Salary Report');
  $sheet->setCellValue('A2', 'From Date: ');
  $sheet->setCellValue('B2', $_REQUEST['from']);
  $sheet->setCellValue('A3', 'To Date: ');
  $sheet->setCellValue('B3', $_REQUEST['to']);
    $c = 6;

    while($row = mysqli_fetch_assoc($result)) {
        $p=json_decode($row['mode'],true);
      $sheet->setCellValue('A'.$c, $row['id']);
      $sheet->setCellValue('B'.$c, $row['name']);
      $sheet->setCellValue('C'.$c, $row['nod']);
      $sheet->setCellValue('D'.$c, $row['month']);
      $sheet->setCellValue('E'.$c, $row['gs']);
      $sheet->setCellValue('F'.$c, $row['ns']);
      $sheet->setCellValue('G'.$c, $row['advan']);
      $sheet->setCellValue('H'.$c, $p['mode']);
       if($p['mode']=='cheque'){
       
       $sheet->setCellValue('I'.$c, "Bank Name:".$p['bank']." Cheque no.:".$p['cheque_no']);
         }elseif($p['mode']=='card'){ 
        $sheet->setCellValue('I'.$c, "Card no:".$p['card_no']);
        } else{
           $sheet->setCellValue('i'.$c, "---");
        }
      $c++;
    }

    $sheet->getStyle('A1:A3')->getFont()->setBold(true);
    $sheet->getStyle('A5:I5')->getFont()->setBold(true);
    $writer = new Xlsx($spreadsheet);
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="Salary.xlsx"');
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
    $url = "functions/export-salary.php?action=download&from=".$_REQUEST['from']."&to=".$_REQUEST['to'];
    $resp['url'] = $url;
    $success = true;
  }
  $resp['success']=$success;
  die(json_encode($resp));
}
function is_not_empty($str){
  return isset($str) && $str!="";
}
?>