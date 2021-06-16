<?php
include 'includes/session.php';
include '../includes/db.php';
if(!isset($_GET['id'])){
	die("No Id passed");
}
$id = $_GET['id'];
$res = mysqli_query($conn,"SELECT p.id, p.fname, p.lname, r.base_treatment,r.doc_present,r.other, r.treatments, r.pay_time,r.r_doc_id, r.doc_id FROM reports r ,patients p WHERE r.id=$id AND p.id=r.p_id");
if(mysqli_affected_rows($conn)==0){
	die("Invalid Id passed");
}
$row = mysqli_fetch_assoc($res);
$other=$row['other'];
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
$d = date_create($row['pay_time']);
$date = date_format($d, "d/m/Y");
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
				border: 1px solid black;
				
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
	
		<h1 class="heading upper" style="color:#ff0000;">Sarvajanik Ganesh Utsav Samiti</h1>
		
		<h3 class="heading">Physiotherapy Centre, Opp Bldg.No 230, Kannamwar Nagar No-1, Vikhroli (East), Mumbai-83</h3>
		
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
			<p class="left"><b>Treated by:</b><?php if($doc_name=='attented'){echo "Dr. ".$other;}
			else{
				echo "Dr. ".$doc_name;
			}?></p>
			<p class="right"><b>Referred by:</b> <?php if($r_doc_id==0){echo " --";}else{ echo "Dr. ".$r_doc_name;}?></p>
			<br>
			<br>
		<hr>

		<br>
		<br>

		<table border="1">
			<thead>
				<tr>
					<th>No.</th>
					<th>Treatment</th>
					<th>Rs.</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$query = "SELECT * FROM treatments";
					$res = mysqli_query($conn,$query);
					$total = 25;
					$n=1;
					$q=1;
					while($row=mysqli_fetch_assoc($res)){
				
				echo '<tr id="myTableRow'.$n.'">';
				
					echo '<td class="cen" id="demo'.$n.'">'.$q.'</td>';
					?>
					<td><?php echo $row['name']?></td>
					<td class="cen">
						<?php
						if(in_array($row['id'], $treatments)){
							$q++;
							if($row['id']==$base){
								$a = $row['amount']; 	
							}else{
								$a = 10;
							}
							echo $a;
							$total+=$a;
						}else{
							echo '<script type="text/javascript">   document.getElementById("myTableRow'.$n.'").style.display = "none"; </script> ';
						?>
						
						<?php
						}
						?>
					</td>
				</tr>
				<?php
				$n++;
					}
				?>
				<tr><?php 
					echo '<td class="cen">'.$q.'</td>'; $q++;?>
					<td>Redevelopment Fee</td>
					<td class="cen">25</td>
				</tr>
				<tr><?php 
					echo '<td class="cen">'.$q.'</td>'; $q++;?>
					<td>First Visit Fee</td>
					<td class="cen">
						<?php
						if($first_time){
							echo 10;
							$total+=10;
						}else{
							echo '--';
						}
						?>		
					</td>
				</tr>
				<tr>
					<td></td>
					<th>Total</th>
					<th><?php echo $total?></th>
				</tr>
			</tbody>
		</table>
<script type="text/javascript"> myFunction(); </script>
		<br>
		<br>

		<p class="left" style="text-transform: capitalize;"><b>In Words: </b><?php echo getIndianCurrency((float)$total); ?></p>

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
