<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include '../includes/session.php';
include '../../includes/db.php';

$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if(is_not_empty($_REQUEST['from']) && is_not_empty($_REQUEST['to'])){
  $from = date_format(date_create_from_format("d/m/Y",$_REQUEST['from']),'Y-m-d');
  $to = date_format(date_create_from_format("d/m/Y",$_REQUEST['to']),'Y-m-d');
  $query = "SELECT * FROM donations WHERE payment_time>='$from' AND payment_time<='$to' AND paid=1";
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
  $sheet->getColumnDimension('F')->setWidth(40);
  $sheet->setTitle('Donations');
  $sheet->setCellValue('A5', 'Receipt No.');
  $sheet->setCellValue('B5', 'Donor Name');
  $sheet->setCellValue('C5', 'Donor Type');
  $sheet->setCellValue('D5', 'Amount');
  $sheet->setCellValue('E5', 'Payment Type');
  $sheet->setCellValue('F5', 'Payment Details');
  $sheet->setCellValue('A1', 'Report Type: ');
  $sheet->setCellValue('B1', 'Donation Report');
  $sheet->setCellValue('A2', 'From Date: ');
  $sheet->setCellValue('B2', $_REQUEST['from']);
  $sheet->setCellValue('A3', 'To Date: ');
  $sheet->setCellValue('B3', $_REQUEST['to']);
    $c = 6;

    while($row = mysqli_fetch_assoc($result)) {
        $p=json_decode($row['payment_details'], true);
        if($row['type']=='patient'){
            $r = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM patients WHERE id=".$row['p_id']));
            $name = $r['fname']." ".$r["lname"];
        }else{
            $name = $row['name'];
        }
      $sheet->setCellValue('A'.$c, $row['id']);
      $sheet->setCellValue('B'.$c, $name);
      $sheet->setCellValue('C'.$c, $row['type']);
      $sheet->setCellValue('D'.$c, $row['amount']);
      $sheet->setCellValue('E'.$c, $p['mode']);
       if($p['mode']=='cheque'){
       
       $sheet->setCellValue('F'.$c, "Bank Name:".$p['bank']." Cheque no.:".$p['cheque_no']);
         }elseif($p['mode']=='card'){ 
        $sheet->setCellValue('F'.$c, "Card no:".$p['card_no']);
        } else{
           $sheet->setCellValue('F'.$c, "---");
        }
      $c++;
    }

    $sheet->setCellValue('D'.$c,'=SUM(D5:D'.($c-1).')');
    $sheet->setCellValue('C'.$c,'Total Amount');
    $sheet->getStyle('A1:A3')->getFont()->setBold(true);
    $sheet->getStyle('A5:F5')->getFont()->setBold(true);
    $sheet->getStyle('C'.$c)->getFont()->setBold(true);
  $writer = new Xlsx($spreadsheet);
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="Donations.xlsx"');
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
    $url = "functions/export-donation.php?action=download&from=".$_REQUEST['from']."&to=".$_REQUEST['to'];
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