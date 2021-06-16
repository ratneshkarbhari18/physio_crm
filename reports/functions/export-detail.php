<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include '../includes/session.php';
include '../../includes/db.php';

$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
$tef=0;
if(is_not_empty($_REQUEST['from']) && is_not_empty($_REQUEST['to'])){
  $from = date_format(date_create_from_format("d/m/Y",$_REQUEST['from']),'Y-m-d');
  $to = date_format(date_create_from_format("d/m/Y",$_REQUEST['to']),'Y-m-d');
  $query = "SELECT r.id,r.doc_id,r.p_id,r.base_treatment,r.treatments,r.covid,p.fname,p.lname,r.pay_time FROM patients p, reports r WHERE r.p_id=p.id AND r.pay_time>='$from' AND r.pay_time<='$to' AND paid=1";
}else{
  die("Please select both dates");
}

$result = mysqli_query($conn, $query);  

if(isset($_GET['action']) && $_GET['action']=="download"){
  require "../../vendor/autoload.php";
  $spreadsheet = new Spreadsheet();
  
  $sheet = $spreadsheet->getActiveSheet();
  $sheet->getColumnDimension('A')->setWidth(30);
  $sheet->getColumnDimension('B')->setWidth(30);
  $sheet->getColumnDimension('C')->setWidth(20);
  $sheet->getColumnDimension('D')->setWidth(20);
  $sheet->getColumnDimension('E')->setWidth(20);
  $sheet->getColumnDimension('F')->setWidth(20);
  $sheet->getColumnDimension('G')->setWidth(20);
  $sheet->setTitle('Detailed');
 $sheet->setCellValue('A5', 'Doctor Name');
  $sheet->setCellValue('B5', 'Patient Name');
  $sheet->setCellValue('C5', 'Bill Id');
  $sheet->setCellValue('D5', 'Amount');
  $sheet->setCellValue('E5', 'Doctor %');
  $sheet->setCellValue('F5', 'Centre Shared');
  $sheet->setCellValue('G5', 'Entry Fee');

  $sheet->setCellValue('A1', 'Report Type: ');
  $sheet->setCellValue('B1', 'Detailed Report');
  $sheet->setCellValue('A2', 'From Date: ');
  $sheet->setCellValue('B2', $_REQUEST['from']);
  $sheet->setCellValue('A3', 'To Date: ');
  $sheet->setCellValue('B3', $_REQUEST['to']);
    $c = 6;
    $t=0;
    while($row = mysqli_fetch_assoc($result)) {
      $data = calculate($row['id'],$row['p_id'],$row['base_treatment'],$row['treatments']);
      $sql="select * from users where type='doctor' AND id=".$row['doc_id'];
      $r = mysqli_query($conn,$sql);
      $rw = mysqli_fetch_assoc($r);
      $per=$rw['doc_percent']/100;
      $amount=$data['amount'];
      $tp=$amount-$tef-25;
      $sheet->setCellValue('A'.$c, $rw['name']);
      $sheet->setCellValue('B'.$c, $row['fname']." ".$row['lname']);
      $sheet->setCellValue('C'.$c, $row['id']);
      $sheet->setCellValue('D'.$c, ($data['amount'] +$row['covid']));
      $sheet->setCellValue('E'.$c, $tp*$per);
      $sheet->setCellValue('F'.$c, ($tp -($tp*$per) +$row['covid']+$tef+25));
      $sheet->setCellValue('G'.$c, $tef);
      $t=$t+$data['amount'];
      $c++;
      $tef=0;
    }
    $sql="SELECT * FROM consultant where paid=1  AND date>='$from' AND date<='$to'";
     $re= mysqli_query($conn,$sql);
     while($row = mysqli_fetch_assoc($re)) {
            $sql1="select * from users where type='consultant' AND id=".$row['doc_id'];
            $r = mysqli_query($conn,$sql1);
            $rw = mysqli_fetch_assoc($r);
            $per=$rw['doc_percent']/100;
            $amount=$row['cost'];
            $amount += 25;
            $tp=$amount-25;
            $sheet->setCellValue('A'.$c, $rw['name']);
            $sheet->setCellValue('B'.$c, $row['patient_name']);
            $sheet->setCellValue('C'.$c, $row['id']);
            $sheet->setCellValue('D'.$c, $amount+$row['covid']);
            $sheet->setCellValue('E'.$c, $tp*$per);
            $sheet->setCellValue('F'.$c, $tp -($tp*$per)+$row['covid']+25);
            $sheet->setCellValue('G'.$c, "0");
            $c++;
     }

    // $sheet->setCellValue('E'.$c,'=SUM(E5:E'.($c-1).')');
    // $sheet->setCellValue('D'.$c,'Total Amount');
    // $c=$c+3;
    // $amount_in_w=getIndianCurrency((float)$t);
    // $sheet->setCellValue('B'.$c,'Total Amount In Words');
    // $sheet->setCellValue('C'.$c,$amount_in_w);
    $sheet->getStyle('A1:A3')->getFont()->setBold(true);
    $sheet->getStyle('A5:G5')->getFont()->setBold(true);
    // $sheet->getStyle('D'.$c)->getFont()->setBold(true);
  $writer = new Xlsx($spreadsheet);
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="Detailed.xlsx"');
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
    $url = "functions/export-detail.php?action=download&from=".$_REQUEST['from']."&to=".$_REQUEST['to'];
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
          $GLOBALS['tef'] +=10;
      }
  }
  $data['amount'] = $total;
  $data['treatments'] = $res;
  return $data;
}
function is_not_empty($str){
  return isset($str) && $str!="";
}
function getIndianCurrency($number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    return ($Rupees ? $Rupees . 'Rupees Only' : '');
}
?>