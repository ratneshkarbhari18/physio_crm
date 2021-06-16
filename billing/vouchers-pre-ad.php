<?php
include 'includes/session.php';
include '../includes/db.php';
$query="select * from ad order by id DESC";
$result=mysqli_query($conn,$query);
$row=mysqli_fetch_array($result);
$pd=json_decode($row['mode'],true);
?>
<!DOCTYPE html>
<html>
	<head>
	    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
		<style>
			body{

				margin-left: 40px;
				margin-top: 250px;
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
			    font-family: 'Satisfy';
				font-weight: bold;
				text-align: center;
				text-transform: capitalize;
				margin:2px;
			}
			.footer{
			    font-family: 'Satisfy';
				font-weight: bold;
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
				height:18px;
			}

			p{
				margin: 0 50px;
			}
			.sign {
                border: 0px solid black;
            }
            .sign th,.sign td {
                border: 0px solid black;
            }

		</style>
	</head>
	<body>



		<br>
		<p class="left"><b>Voucher No.:</b> <?php echo $row['id']?></p>

		<p class="right"><b>Voucher Date:</b> <?php echo date('d/m/Y')?></p>

		<br>
		<br>
        <p><b>Name of person:</b><u><?php echo $row['name']?></u></p>
		<br>
		<table>
		    <thead>
		        <th>Details of expenses</th>
		        <th>Rupees</th>
		        <th>Paise</th>
		    </thead>
		    <tbody>
		        <tr>
		            <td>Advance salary</td>
		            <td><?php echo "Rs.".$row['amount']?></td>
		            <td></td>
		        </tr>
		        <tr>
		            <?php if($pd['mode']=="cheque"){ ?>
		            <td>Bank name:<?php echo $pd['bank']?></td><?php }else {echo "<td></td>"; } ?>
		            <td></td>
		            <td></td>
		        </tr>
		        <tr>
		            <?php if($pd['mode']=="cheque"){ ?>
		            <td>Cheque No.:<?php echo $pd['cheque_no']?></td><?php }else {echo "<td></td>"; } ?>
		            <td></td>
		            <td></td>
		        </tr>
		        <tr>
		            <td></td>
		            <td></td>
		            <td></td>
		        </tr>
		    </tbody>
		</table>
		<!--<p><b>Name:</b><u><?php echo "<u>".$row['name']."</u>"?></u></p>-->

		<!--<br>-->
		<!--	<p> <b>Amount:</b><u><?php echo "Rs. ".$row['amount']?></u></p>-->
			<br>

		<p style="text-transform: capitalize;"><b>In Words: </b><u><?php echo getIndianCurrency($row['amount'])?></u></p>

        <br>
        <br>
        <br>
		<table class="sign">
		    <tbody>
		        <tr>
		        <td><b>Reciever Sign</b></td>
		        <td><b>Auditor Sign</b></td>
		        <td><b>Treasurer Sign</b></td>
		        <td><b>Secretary Sign</b></td>
		    </tr>
		    </tbody>
		    
		</table>

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
