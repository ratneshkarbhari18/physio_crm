<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include '../includes/session.php';
include '../../includes/db.php';

$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if(is_not_empty($_REQUEST['from']) && is_not_empty($_REQUEST['to'])){
  $from = date_format(date_create_from_format("d/m/Y",$_REQUEST['from']),'Y-m-d');
  $to = date_format(date_create_from_format("d/m/Y",$_REQUEST['to']),'Y-m-d ');
  $query = "SELECT * FROM vouchers WHERE date>='$from' AND date<='$to' ";
  
   $query1 = "SELECT * FROM ad WHERE date>='$from' AND date<='$to' ";
    $result1 = mysqli_query($conn, $query1);
    
    $query2 = "SELECT * FROM bank WHERE date>='$from' AND date<='$to' ";
    $result2 = mysqli_query($conn, $query2);
    
    $query3 = "SELECT * FROM jv WHERE date>='$from' AND date<='$to' ";
    $result3 = mysqli_query($conn, $query3);
    
    $query4 = "SELECT * FROM ex_income WHERE date>='$from' AND date<='$to' ";
    $result4 = mysqli_query($conn, $query4);
}else{
  die("Please select both dates");
}

$result = mysqli_query($conn, $query);  

if(isset($_GET['action']) && $_GET['action']=="download"){
  require "../../vendor/autoload.php";
  $spreadsheet = new Spreadsheet();
  
  $sheet = $spreadsheet->getActiveSheet();
  $sheet->getColumnDimension('A')->setWidth(20);
  $sheet->getColumnDimension('B')->setWidth(25);
  $sheet->getColumnDimension('C')->setWidth(30);
  $sheet->getColumnDimension('D')->setWidth(30);
  $sheet->getColumnDimension('E')->setWidth(30);
  $sheet->getColumnDimension('F')->setWidth(20);
  $sheet->getColumnDimension('G')->setWidth(20);
  $sheet->getColumnDimension('H')->setWidth(30);
  $sheet->setTitle('Bills');
  $sheet->setCellValue('A5', 'Voucher No.');
  $sheet->setCellValue('B5', 'Date');
  $sheet->setCellValue('C5', 'Voucher Type');
  $sheet->setCellValue('D5', 'Name of Person');
  $sheet->setCellValue('E5', 'Narration');
  $sheet->setCellValue('F5', 'Amount');
  $sheet->setCellValue('G5', 'Payment Type');
  $sheet->setCellValue('H5', 'Payment Details');
  $sheet->setCellValue('A1', 'Report Type: ');
  $sheet->setCellValue('B1', 'Bill Report');
  $sheet->setCellValue('A2', 'From Date: ');
  $sheet->setCellValue('B2', $_REQUEST['from']);
  $sheet->setCellValue('A3', 'To Date: ');
  $sheet->setCellValue('B3', $_REQUEST['to']);
    $c = 6;
    $t=0;
    while($row = mysqli_fetch_assoc($result)) {
      $data = calculate($row['id'],$row['p_id'],$row['base_treatment'],$row['treatments']);
      $p=json_decode($row['mode'], true);
      $sql="select * from users where type='doctor' AND id=".$row['doc_id'];
      $r = mysqli_query($conn,$sql);
      $rw = mysqli_fetch_assoc($r);
      $sheet->setCellValue('A'.$c, $row['id']);
      $sheet->setCellValue('B'.$c, $row['date']);
      $sheet->setCellValue('C'.$c, $row['type']);
      $sheet->setCellValue('D'.$c, $row['convection']);
      $sheet->setCellValue('E'.$c, $row['narration']);
      $sheet->setCellValue('F'.$c, $row['amount']);
      $sheet->setCellValue('G'.$c, $p['mode']);
      if($p['mode']=='cheque'){
       
       $sheet->setCellValue('H'.$c, "Bank Name:".$p['bank']." Cheque no.:".$p['cheque_no']);
         } else{
           $sheet->setCellValue('H'.$c, "---");
        }
      $t=$t+$row['amount'];
      $c++;
    }

    $sheet->setCellValue('F'.$c,'=SUM(F5:F'.($c-1).')');
    $sheet->setCellValue('E'.$c,'Total Amount'); 
    
    //2
    $c=$c+2;
    $sheet->setCellValue('A'.$c, 'Advance Salary Vouchers');
    $sheet->getStyle('A'.$c)->getFont()->setBold(true);
    $c++;
    $query = "SELECT * FROM ad WHERE date>='$from' AND date<='$to' ";
    $result1 = mysqli_query($conn, $query);
    $sheet->setCellValue('A'.$c, 'Voucher No.');
  $sheet->setCellValue('B'.$c, 'Date');
  $sheet->setCellValue('C'.$c, 'Employee Name');
  $sheet->setCellValue('D'.$c, 'Amount');
  $sheet->setCellValue('E'.$c, 'Payment Type');
  $sheet->setCellValue('F'.$c, 'Payment Details');
  $sheet->getStyle('A'.$c.':F'.$c)->getFont()->setBold(true);
  $c++;
  $t1=$c;
  while($row = mysqli_fetch_assoc($result1)) {
      $p=json_decode($row['mode'], true);
      $sheet->setCellValue('A'.$c, $row['id']);
      $sheet->setCellValue('B'.$c, $row['date']);
      $sheet->setCellValue('C'.$c, $row['name']);
      $sheet->setCellValue('D'.$c, $row['amount']);
      $sheet->setCellValue('E'.$c, $p['mode']);
      if($p['mode']=='cheque'){
       
       $sheet->setCellValue('F'.$c, "Bank Name:".$p['bank']." Cheque no.:".$p['cheque_no']);
         } else{
           $sheet->setCellValue('F'.$c, "---");
        }
      $t=$t+$row['amount'];
      $c++;
    }
    $sheet->setCellValue('D'.$c,'=SUM(D'.$t1.':D'.($c-1).')');
    $sheet->setCellValue('C'.$c,'Total Amount');
    
    //3
    $c=$c+2;
    $sheet->setCellValue('A'.$c, 'Bank Deposit/withdrawl Vouchers');
    $sheet->getStyle('A'.$c)->getFont()->setBold(true);
    $c++;
    $query = "SELECT * FROM bank WHERE date>='$from' AND date<='$to' ";
    $result1 = mysqli_query($conn, $query);
    $sheet->setCellValue('A'.$c, 'Voucher No.');
  $sheet->setCellValue('B'.$c, 'Date');
  $sheet->setCellValue('C'.$c, 'Name Of Person');
  $sheet->setCellValue('D'.$c, 'Description');
  $sheet->setCellValue('E'.$c, 'Type of Transaction');
  $sheet->setCellValue('F'.$c, 'Amount');
  $sheet->setCellValue('G'.$c, 'Payment Type');
  $sheet->setCellValue('H'.$c, 'Payment Details');
  $sheet->getStyle('A'.$c.':H'.$c)->getFont()->setBold(true);
  $c++;
  $t1=$c;
  while($row = mysqli_fetch_assoc($result1)) {
      $p=json_decode($row['mode'], true);
      $sheet->setCellValue('A'.$c, $row['id']);
      $sheet->setCellValue('B'.$c, $row['date']);
      $sheet->setCellValue('C'.$c, $row['name']);
      $sheet->setCellValue('D'.$c, $row['purpose']);
      $sheet->setCellValue('E'.$c, $row['type']);
      $sheet->setCellValue('F'.$c, $row['amount']);
      $sheet->setCellValue('G'.$c, $p['mode']);
      if($p['mode']=='cheque'){
       
       $sheet->setCellValue('H'.$c, "Bank Name:".$p['bank']." Cheque no.:".$p['cheque_no']);
         } else{
           $sheet->setCellValue('H'.$c, "---");
        }
      $t=$t+$row['amount'];
      $c++;
    }
    $sheet->setCellValue('F'.$c,'=SUM(F'.$t1.':F'.($c-1).')');
    $sheet->setCellValue('E'.$c,'Total Amount');
    
    //4
    $c=$c+2;
    $sheet->setCellValue('A'.$c, 'Payable Vouchers');
    $sheet->getStyle('A'.$c)->getFont()->setBold(true);
    $c++;
    $query = "SELECT * FROM jv WHERE date>='$from' AND date<='$to' ";
    $result1 = mysqli_query($conn, $query);
    $sheet->setCellValue('A'.$c, 'Voucher No.');
  $sheet->setCellValue('B'.$c, 'Date');
  $sheet->setCellValue('C'.$c, 'Name Of Person');
  $sheet->setCellValue('D'.$c, 'Purpose');
  $sheet->setCellValue('E'.$c, 'Amount');
  $sheet->setCellValue('F'.$c, 'Payment Type');
  $sheet->setCellValue('G'.$c, 'Payment Details');
  $sheet->getStyle('A'.$c.':G'.$c)->getFont()->setBold(true);
  $c++;
  $t1=$c;
  while($row = mysqli_fetch_assoc($result1)) {
      $p=json_decode($row['mode'], true);
      $sheet->setCellValue('A'.$c, $row['id']);
      $sheet->setCellValue('B'.$c, $row['date']);
      $sheet->setCellValue('C'.$c, $row['payee']);
      $sheet->setCellValue('D'.$c, $row['purpose']);
      $sheet->setCellValue('E'.$c, $row['amount']);
      $sheet->setCellValue('F'.$c, $p['mode']);
      if($p['mode']=='cheque'){
       
       $sheet->setCellValue('G'.$c, "Bank Name:".$p['bank']." Cheque no.:".$p['cheque_no']);
         } else{
           $sheet->setCellValue('G'.$c, "---");
        }
      $t=$t+$row['amount'];
      $c++;
    }
    $sheet->setCellValue('E'.$c,'=SUM(E'.$t1.':E'.($c-1).')');
    $sheet->setCellValue('D'.$c,'Total Amount');
    
    //5
    $c=$c+2;
    $sheet->setCellValue('A'.$c, 'Additional Income Vouchers');
    $sheet->getStyle('A'.$c)->getFont()->setBold(true);
    $c++;
    $query = "SELECT * FROM ex_income WHERE date>='$from' AND date<='$to' ";
    $result1 = mysqli_query($conn, $query);
    $sheet->setCellValue('A'.$c, 'Voucher No.');
  $sheet->setCellValue('B'.$c, 'Date');
  $sheet->setCellValue('C'.$c, 'Name Of Person');
  $sheet->setCellValue('D'.$c, 'Description');
  $sheet->setCellValue('E'.$c, 'Amount');
  $sheet->setCellValue('F'.$c, 'Payment Type');
  $sheet->setCellValue('G'.$c, 'Payment Details');
  $sheet->getStyle('A'.$c.':G'.$c)->getFont()->setBold(true);
  $c++;
  $t1=$c;
  while($row = mysqli_fetch_assoc($result1)) {
      $p=json_decode($row['mode'], true);
      $sheet->setCellValue('A'.$c, $row['id']);
      $sheet->setCellValue('B'.$c, $row['date']);
      $sheet->setCellValue('C'.$c, $row['name']);
      $sheet->setCellValue('D'.$c, $row['des']);
      $sheet->setCellValue('E'.$c, $row['cost']);
      $sheet->setCellValue('F'.$c, $p['mode']);
      if($p['mode']=='cheque'){
       
       $sheet->setCellValue('G'.$c, "Bank Name:".$p['bank']." Cheque no.:".$p['cheque_no']);
         } else{
           $sheet->setCellValue('G'.$c, "---");
        }
      $t=$t+$row['amount'];
      $c++;
    }
    $sheet->setCellValue('E'.$c,'=SUM(E'.$t1.':E'.($c-1).')');
    $sheet->setCellValue('D'.$c,'Total Amount');
    
    // $amount_in_w=getIndianCurrency((float)$t);
    // $sheet->setCellValue('B'.$c,'Total Amount In Words');
    // $sheet->setCellValue('C'.$c,$amount_in_w);
    $sheet->getStyle('A1:A3')->getFont()->setBold(true);
    $sheet->getStyle('A5:H5')->getFont()->setBold(true);
    $sheet->getStyle('C'.$c)->getFont()->setBold(true);
  $writer = new Xlsx($spreadsheet);
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="Vouchers.xlsx"');
  header('Cache-Control: max-age=0');
  header('Expires: Fri, 11 Nov 2011 11:11:11 GMT');
  header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
  header('Cache-Control: cache, must-revalidate');
  header('Pragma: public');
  $writer->save('php://output');
}else{
  $resp = array();
  $success = false;
  if(mysqli_num_rows($result)>0 || mysqli_num_rows($result1)>0 || mysqli_num_rows($result2)>0 || mysqli_num_rows($result3)>0 || mysqli_num_rows($result4)>0){
    $url = "functions/export-v.php?action=download&from=".$_REQUEST['from']."&to=".$_REQUEST['to'];
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