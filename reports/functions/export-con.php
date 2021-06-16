<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include '../includes/session.php';
include '../../includes/db.php';

$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if(is_not_empty($_REQUEST['from']) && is_not_empty($_REQUEST['to'])){
  $from = date_format(date_create_from_format("d/m/Y",$_REQUEST['from']),'Y-m-d');
  $to = date_format(date_create_from_format("d/m/Y",$_REQUEST['to']),'Y-m-d ');
  $query = "SELECT * FROM consultant WHERE  date>='$from' AND date<='$to' AND paid=1";
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
  $sheet->getColumnDimension('C')->setWidth(40);
  $sheet->getColumnDimension('D')->setWidth(20);
  $sheet->getColumnDimension('E')->setWidth(20);
  $sheet->getColumnDimension('F')->setWidth(20);
  $sheet->getColumnDimension('G')->setWidth(20);
  $sheet->getColumnDimension('H')->setWidth(20);
  $sheet->getColumnDimension('I')->setWidth(30);
  $sheet->setTitle('Bills');
  $sheet->setCellValue('A5', 'Bill No.');
  $sheet->setCellValue('B5', 'Patient Name');
  $sheet->setCellValue('C5', 'Date');
  $sheet->setCellValue('D5', 'Treated By');
  $sheet->setCellValue('E5', 'Redevelopment Fee');
  $sheet->setCellValue('F5', 'COVID-19 Fee');
  $sheet->setCellValue('G5', 'Amount');
  $sheet->setCellValue('H5', 'Payment Type');
  $sheet->setCellValue('I5', 'Payment Details');
  $sheet->setCellValue('A1', 'Report Type: ');
  $sheet->setCellValue('B1', 'Bill Report');
  $sheet->setCellValue('A2', 'From Date: ');
  $sheet->setCellValue('B2', $_REQUEST['from']);
  $sheet->setCellValue('A3', 'To Date: ');
  $sheet->setCellValue('B3', $_REQUEST['to']);
    $c = 6;
    $t=0;
    while($row = mysqli_fetch_assoc($result)) {
      
      $sql="select * from users where type='consultant' AND id=".$row['doc_id'];
      $r = mysqli_query($conn,$sql);
      $rw = mysqli_fetch_assoc($r);
      $p=json_decode($row['mode'], true);
      $sheet->setCellValue('A'.$c, $row['id']);
      $sheet->setCellValue('B'.$c, $row['patient_name']);
      $ll=date_create($row['date']);
      $sheet->setCellValue('C'.$c, date_format($ll,"d/m/Y").' ');
      $sheet->setCellValue('D'.$c, $rw['name']);
      $sheet->setCellValue('E'.$c, "25");
      $sheet->setCellValue('F'.$c, $row['covid']);
      $sheet->setCellValue('G'.$c, $row['cost']);
      $sheet->setCellValue('H'.$c, $p['mode']);
      if($p['mode']=='cheque'){
       
       $sheet->setCellValue('I'.$c, "Bank Name:".$p['bank']." Cheque no.:".$p['cheque_no']);
         } else{
           $sheet->setCellValue('I'.$c, "---");
        }
      $t=$t+$row['cost']+25+$row['covid'];
      $c++;
    }

    // $sheet->setCellValue('G'.$c,'=SUM(F5:F'.($c-1).')+SUM(E5:E'.($c-1).')+SUM(G5:G'.($c-1).')');
    // $sheet->setCellValue('F'.$c,'Total Amount');
    // $tc = $sheet->getCellValue('G'.$c);
    $c=$c+3;
    $amount_in_w=getIndianCurrency((float)$t);
    // $sheet->setCellValue('B'.$c,'Total Amount In Words');
    // $sheet->setCellValue('C'.$c,$amount_in_w);
    $sheet->getStyle('A1:A3')->getFont()->setBold(true);
    $sheet->getStyle('A5:H5')->getFont()->setBold(true);
    $sheet->getStyle('D'.$c)->getFont()->setBold(true);
  $writer = new Xlsx($spreadsheet);
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="Consultant Bills.xlsx"');
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
    $url = "functions/export-con.php?action=download&from=".$_REQUEST['from']."&to=".$_REQUEST['to'];
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