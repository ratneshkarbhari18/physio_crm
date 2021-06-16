<?php
include 'includes/session.php';
include '../includes/db.php';
if(!isset($_GET['id'])){
	die("No Id passed");
}
$id = $_GET['id'];
$res = mysqli_query($conn,"SELECT p.id, p.fname, p.lname, r.base_treatment,r.doc_present,r.other, r.treatments, r.pay_time,r.r_doc_id, r.doc_id,p.co,p.ho,p.mho,p.ix,p.tri FROM reports r ,patients p WHERE p.id=$id AND p.id=r.p_id");
if(mysqli_affected_rows($conn)==0){
	die("Invalid Id passed");
}
$row = mysqli_fetch_assoc($res);
$co=$row['co'];
$ho=$row['ho'];
$mho=$row['mho'];
$ix=$row['ix'];
$tri=$row['tri'];
$treatments = array(json_decode($row['base_treatment'],true)['id']);
$base = $treatments[0];
$array = json_decode($row['treatments'],true);
foreach($array as $i){
    array_push($treatments,$i['id']);
}
$present=$row['doc_present'];
$query1="SELECT * from users where id=".$row['doc_id'];
$res1=mysqli_query($conn,$query1);
$row1=mysqli_fetch_array($res1);
$r_doc_id=$row['r_doc_id'];
$query2="SELECT * from referring_doc where id=".$row['r_doc_id'];
$res2=mysqli_query($conn,$query2);
$row2=mysqli_fetch_array($res2);
$r_doc_name=$row2['name'];
$name = $row['fname']." ".$row['lname'];
$doc_name=$row1['name'];
$mobile=$row1['mobile'];
$d = date_create($row['pay_time']);
$date = date("d/m/Y");
$p_id = $row['id'];
$query = "SELECT MIN(id) FROM reports WHERE p_id=$p_id";
$res = mysqli_query($conn,$query);
$row = mysqli_fetch_array($res);
$first_time = false;
if($id==$row[0]){
	$first_time = true;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<style>
			body{
				border: solid black;
				border-width: 1px;
				margin: 20px;
				padding: 20px 0;
				font-family: monospace;
			}
				
			.left{
				float: left;
			}
			
			.right{
				float: right;
			}
			.treat-l{
			margin-left:1px;
			}
			
			.heading{
				font-weight: bold;
				text-align: center;
				text-transform: capitalize;
				margin:2px;
			}
			
			.upper{
				text-transform: uppercase;
			}

			table {
				border-collapse: collapse;
				margin: 0 auto;
				width: 90%;	
			}

			table, th, td {
				//border: 1px solid black;
				
			}
			.cen{
				text-align:center;
			}
			
			p{
				margin: 0 50px;
			}
.center{text-align:center;}
		</style>
	</head>
	<body>
	
		<h3 class="heading upper" style="color:#ff0000;">Sarvajanik Ganeshotsav Samiti</h1>
		
		<h1 class="heading">Physiotherapy Centre</h3>
		
		<h3 class="heading">Opp Bldg.No 230, Kannamwar Nagar No-1, Vikhroli (East), Mumbai-83</h3>
		
		<h3 class="heading">Phone No: 25779594 | Mobile No: 961982244 </h3>

		<h3 class="heading">Time: 9:00 AM to 9:00 PM (Sunday Closed)</h3>

		<h3 class="heading">31 Years of affordable service</h3>

		
		<br>
		<br>
		<hr>

		<br>
		<br>
		<p class="left"><b>Receipt No:</b> <?php echo $id?></p>

		<p class="right"><b>Date:</b> <?php echo $date?></p>

		<br>
		<br>
	
		<p class="left"><b>Name:</b><?php echo $name?></p>

		<p class="right"><b>Patient ID:</b> <?php echo $p_id?></p>

		<br>
		<br>
			<p class="left"><b>Treated by:</b><?php if($present==1){echo "<u>Dr.".$doc_name."</u>";}
			else{
				echo "  --";
			}?></p>
			<p class="right"><b>Referred by:</b> <?php if($r_doc_id==0){echo " --";}else{ echo "<u>Dr.".$r_doc_name."</u>";}?></p>
			<br>
			<br>
			<p class="left"><b>Doctor's Mobile No:</b><?php echo $mobile; ?></p>
			<br>
			<br>
			<br>
			
			
		<hr>

		<br>
		<br>
		<p class="left"><b>C/O:</b><u><?php echo '       '.$co ?></u></p>
		<br>
		<br>
		<p class="left"><b>H/O:</b><u><?php echo '       '.$ho ?></u></p>
		<br>
		<br>
		<p class="left"><b>M/H/O:</b><u><?php echo '      '.$mho ?></u></p>
		<br>
		<br>
		<p class="left"><b>IX:</b><u><?php echo '      '.$ix ?></u></p>
		<br>
		<br>
		<p class="left"><img src="../assets/img/triangle2.png" style=""><b>:</b><u><?php echo '  '.$tri ?></u></p>
		<br>
		<br>
		<hr>
		
<table border=0>
<?php
$query = "SELECT r.id,r.base_treatment,r.treatments,r.time_stamp,d.name FROM reports r, users d WHERE r.doc_id=d.id AND p_id=$id";
$result = mysqli_query($conn, $query);  
$c = 1;

echo '<td style="width:45px;"><b class="treat-l">RX:</b></td>';
echo '<td>';
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
	echo '<b class="treat">'.$c.'.'.$ts.'</b><br>';
	$c++;
	if($c==6){break;}
  }
 echo '</td>';
?>
</table>
		<br>
		<br>

		

        <br>
        <br>
        <br>
		<p class="right"><b>Authority Signature</b></p>


		<br>
		<br>
		<p id="demo"></p>
     </body>

</html>
<?php
function getIndianCurrency($number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
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
