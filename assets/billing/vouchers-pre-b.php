<?php
include 'includes/session.php';
include '../includes/db.php';
$query="select * from bank order by id DESC";
$result=mysqli_query($conn,$query);
$row=mysqli_fetch_array($result);

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
				width: 80%;	
				font-size:20px;
			}

			table, th, td {
			
			}
			
			p{
				margin: 0 50px;
			}

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
		<p class="left"><b>Voucher No.:</b> <?php echo $row['id']?></p>

		<p class="right"><b>Voucher Date:</b> <?php echo date('d/m/Y')?></p>

		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<table style="border:0 solid;">
		    <tr>
		        <td style="width:202px;"><b>Name Of Ac Holder:</b></td>
		        <td style="border-bottom:1px solid #000000;"><?php echo $row['name']?></td>
		    </tr>
		    <tr>
		        <td style="width:202px;"><b>Account No</b></td>
		        <td style="border-bottom:1px solid #000000;"><?php echo $row['acno']?></td>
		    </tr>
		    <tr>
		        <td style="width:202px;"><b>Bank Name:</b></td>
		        <td style="border-bottom:1px solid #000000;"><?php echo $row['bname']?></td>
		    </tr>
		    <tr>
		        <td style="width:202px;"><b>IFSC Code:</b></td>
		        <td style="border-bottom:1px solid #000000;"><?php echo $row['ifsc']?></td>
		    </tr>
		     <tr>
		        <td style="width:202px;"><b>Amount:</b></td>
		        <td style="border-bottom:1px solid #000000;"><?php echo $row['amount']?></td>
		    </tr>
		     <tr>
		        <td style="width:202px;"><b>In Words:</b></td>
		        <td style="border-bottom:1px solid #000000;"><?php echo getIndianCurrency($row['amount'])?></td>
		    </tr>
		</table>
		

        <br>
        <br>
        <br>
		<br>
		<br>
		<br>
		<br>
		<p class="left"><b>Recieved By</b></p>
		<p class="right"><b>Paid By</b></p>


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
