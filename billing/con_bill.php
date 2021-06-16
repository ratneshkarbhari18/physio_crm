<?php
include 'includes/session.php';
include '../includes/db.php';
if(!isset($_GET['id'])){
	die("No Id passed");
}
$id = $_GET['id'];
$res = mysqli_query($conn,"SELECT * FROM consultant WHERE id=$id and paid='1'");
if(mysqli_affected_rows($conn)==0){
	die("Invalid Id passed");
}
$row = mysqli_fetch_assoc($res);
$covid=$row['covid'];
$query1="SELECT * from users where id=".$row['doc_id'];
$res1=mysqli_query($conn,$query1);
$row1=mysqli_fetch_array($res1);
$date_new  = date_create($row['date']);
$date = date_format($date_new,'d-m-Y');
$q=1;
$doc_name=$row1['name'];
$total=$row['cost']+25;
?>
<!DOCTYPE html>
<html>
	<head>
	    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	   <link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/bebas" type="text/css"/>
		<style>
			body{

				margin: 20px;
				margin-top: 280px;
				padding: 20px 0;
				font-family: monospace;
				background-image: url('back.jpg');
				background-size: cover;
			}

			.left{
				float: left;
			}

			.right{
				float: right;
			}

			.heading{
			    font-family: 'BebasNeueRegular';
				text-align: center;
				text-transform: capitalize;
				margin:2px;
			}
			.firstl{
			    font-size:60px;
			}
			.footer{
			    font-family: 'BebasNeueRegular';
				text-align: center;
				text-transform: capitalize;
				margin:2px;
				font-size:15px;
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
				text-align:center;

			}
			.cen{
				text-align:center;
			}

			p{
				margin: 0 50px;
			}
			hr{
				margin-left: 45px;
    margin-right: 24px;
			}
.center{text-align:center;}
		</style>
	</head>
	<body>

		<p class="left"><b>Receipt No:</b> <?php echo $id?></p>

		<p class="right"><b>Date:</b> <?php echo $date?></p>

		<br>
		<br>

		<p class="left"><b>Name:</b><?php echo $row['patient_name']?></p>

		<p class="right"><b>Patient ID:</b> <?php echo $id?></p>

		<br>
		<br>
			<p class="left"><b>Treated by:</b><?php echo "Dr.".$doc_name;?></p>

			<br>
			<br>
		<hr>

		<br>
		<br>

		<table border="1">
		    <thead>
		        <tr>
		            <th>Sr No.</th>
		            <th>Treatment</th>
		            <th>Cost</th>
		        </tr>
		    </thead>
			<tbody>
			    <tr>
					<td><?php  echo $q; $q++ ?></td>
					<td style="text-align:left">Redevelopment Fee</td>
					<td>Rs. 25 </td>
				</tr>
				<?php
				if($covid==10){
				    echo '
				    <tr>
					<td>'.$q.'</td>
					<td style="text-align:left">COVID-19 Fee</td>
					<td>Rs. 10 </td>
				</tr>
				    ';
				    $q++;
				    $total+=10;
				}
				?>
				<tr>
					<td><?php  echo $q; $q++ ?></td>
					<td style="text-align:left">Consulting Charges</td>
					<td>Rs. <?php echo $row['cost']?> </td>
				</tr>
				<td></td>
				<td><b>Total</b></td>
				<td><b>Rs. <?php echo $total; ?></b></td>
			</tbody>
			<!--<tbody>-->
			<!--	<tr>-->
			<!--		<th>1</th>-->
			<!--		<th><?php //echo $row['treatment']?></th>-->
			<!--		<th><?php //echo $row['cost']?></th>-->
			<!--	</tr>-->
			<!--</tbody>-->
		</table>
<script type="text/javascript"> myFunction(); </script>
		<br>
		<br>

		<p class="left" style="text-transform: capitalize;"><b>In Words: </b><u><?php echo getIndianCurrency((float)$total); ?></u></p>

        <br>
        <br>
        <br>
		<p class="right"><b>Authority Signature</b></p>


		<br>
		<br>
		<br>
		<br>

		<br>
		<br>

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
