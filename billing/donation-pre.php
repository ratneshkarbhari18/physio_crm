<?php
include 'includes/session.php';
include '../includes/db.php';
$query="select * from donations order by id DESC";
$result=mysqli_query($conn,$query);
$row=mysqli_fetch_array($result);
$p=json_decode($row['payment_details'], true);

?>
<!DOCTYPE html>
<html>
	<head>
	      	    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
                 <link href='https://fonts.googleapis.com/css?family=Satisfy' rel='stylesheet'>
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
				height:18px;
				
			}

			p{
				margin: 0 50px;
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
		        <th style="width: 70%;">Donation</th>
		        <th>Rupees</th>
		        <th>Paise</th>
		    </thead>
		    <tbody>
		        <tr>
		            <td rowspan="4"><p style="margin: 0 20px;">Donated via <?php
		            if($p['mode']=="cash"){
		                echo "<u>Cash</u>";
		            }else if($p['mode']=="Equipment"){
		                echo "<u>".$p['mode']."</u>";
		              //  echo "<p style='text-align:center;    margin-top: 45px;'>Thanks! <b style='position: fixed;right: 32%;'>Total</b></p></td>";
		            }else if(($p['mode']=="cheque")){
		                echo "<u>Cheque</u>";
		                echo "<p style='margin: 0 20px;'>Bank name:<u>".$p['bank']."</u>  Cheque no:<u>".$p['cheque_no']."</u></p>";
		            }else{
		                echo "<u>".$p['mode']."</u>";
		            }
		            
		            ?></p>
		            
		            <br>
            
		<p style="text-transform: capitalize;margin: 0 20px;"><b>In Words: </b><u><?php echo getIndianCurrency($row['amount'])?></u></p>
		<p style='text-align:center;    margin-top: 19px;'>Thanks! <b style="position: fixed;right: 32%;">Total</b></p></td>
		            <td style="text-align:center;"><?php echo "Rs.".$row['amount']?></td>
		            
                
		            
		            <td></td>
		        </tr>
		        <tr>
		            <td></td>
		            <td></td>
		            
		        </tr>
		        <tr>
		            <td></td>
		            <td></td>
		            
		        </tr>
		        <tr>
		          
		            <td style="text-align:center;"><?php echo "Rs.".$row['amount']?></td>
		         
                
		            
		            <td></td>
		            
		        </tr>
		    </tbody>
		</table>
		<!--<p><b>Name:</b><u><?php echo "<u>".$row['name']."</u>"?></u></p>-->

		<!--<br>-->
		<!--	<p> <b>Amount:</b><u><?php echo $row['amount']." Rs"?></u></p>-->
			

        <br>
        <br>
        <br>
		<br>
		
		
		<p class="right"><b>Recieved By</b></p>
		<!--<p class="right"><b>Paid By</b></p>-->


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
