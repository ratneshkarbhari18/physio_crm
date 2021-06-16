<?php
include '../includes/session.php';
include '../../includes/db.php';
require "../../vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
 
$sheet = $spreadsheet->getActiveSheet();
$sheet->getColumnDimension('B')->setWidth(25);
$sheet->getColumnDimension('C')->setWidth(25);
$sheet->getColumnDimension('D')->setWidth(25);
$sheet->getColumnDimension('A')->setWidth(30);
$sheet->setTitle('Patient History');
$sheet->setCellValue('A7', 'ID');
$sheet->setCellValue('B7', 'Treatment');
$sheet->setCellValue('C7', 'Doctor');
$sheet->setCellValue('D7', 'Date');
$sheet->setCellValue('A6', 'History: ');
$_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
if(!isset($_GET['id'])){
    die("Error no patient selected");
}
$id = $_GET['id'];
$query = "SELECT fname,lname,gender,TIMESTAMPDIFF(YEAR, dob, CURDATE()) as age FROM patients WHERE id=$id";
$res = mysqli_query($conn,$query);
if(mysqli_affected_rows($conn)<=0){
    die("Invalid Patient");
}
$row = mysqli_fetch_assoc($res);
$sheet->setCellValue('A1', "Patient ID: $id");
$sheet->setCellValue('A2', 'Patient Name: '.$row['fname']." ".$row['lname']);
$sheet->setCellValue('A3', 'Patient Age: '.$row['age']);
$sheet->setCellValue('A4', 'Patient Gender: '.$row['gender']);

$query = "SELECT r.id,r.base_treatment,r.treatments,r.time_stamp,d.name FROM reports r, users d WHERE r.doc_id=d.id AND p_id=$id";
$result = mysqli_query($conn, $query);  
$c = 8;


  while($row = mysqli_fetch_assoc($result)) {
    $ts = "";
    $t = array(json_decode($row['base_treatment'],true)["id"]);
    $array = json_decode($row['treatments'],true);
    foreach($array as $i){
        array_push($t,$i['id']);
    }
    $first = true;
    foreach($t as $i){
        $sql = "SELECT name FROM treatments WHERE id=$i";
        $r = mysqli_fetch_assoc(mysqli_query($conn,$sql));
        if(!$first){
            $ts.=", ";
        }
        $ts.=$r['name'];
        $first=false;
    }
                                                    
    $sheet->setCellValue('A'.$c, $row['id']);
    $sheet->setCellValue('B'.$c, $ts);
    $sheet->setCellValue('C'.$c, $row['name']);
    $sheet->setCellValue('D'.$c, $row['time_stamp'].' ');
    $c++;
  } 

$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="history.xlsx"');
header('Cache-Control: max-age=0');
header('Expires: Fri, 11 Nov 2011 11:11:11 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: cache, must-revalidate');
header('Pragma: public');
$writer->save('php://output');

?>