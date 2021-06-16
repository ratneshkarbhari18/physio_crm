<?php
include 'includes/session.php';
include '../includes/db.php';
if(!isset($_GET['id'])){
	die("No Id passed");
}
$id = $_GET['id'];
$res = mysqli_query($conn,"SELECT p.id, p.fname, p.lname, r.base_treatment,r.doc_present,r.other, r.treatments, r.pay_time,r.r_doc_id, r.doc_id,r.covid FROM reports r ,patients p WHERE r.id=$id AND p.id=r.p_id");
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
$covid=$row['covid'];
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
$total = 25;
//var_dump($treatments);
?>
<!DOCTYPE html>
<html>
	<head>
	    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	   <link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/bebas" type="text/css"/>
		<style>
			body{

				margin: 0px;
				margin-top: 280px;
			//	padding: 0px 0;
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

		<p class="left"><b>Patient Name:</b><?php echo $name?></p>

		<p class="right"><b>Patient ID:</b> <?php echo $p_id?></p>

		<br>
		<br>
			<p class="left"><b>Treated by:</b><?php if($doc_name=='attented'){echo "Dr. ".$other;}
			else{
				echo "Dr. ".$doc_name;
			}?></p>
			<p class="right"><b>Referred by:</b> <?php if($r_doc_name==""){echo " --";}else{ echo "Dr. ".$r_doc_name;}?></p>
			<br>
			<br>
		<hr>

		<br>
		<br>

		<table id="myTable" border="1">
			<thead>
				<tr>
					<th>No.</th>
					<th>Treatment</th>
					<th>Rs.</th>
				</tr>
			</thead>
			<tbody>
			    <tr><?php
			    $q=1;
					echo '<td class="cen">'.$q.'</td>'; $q++;?>
					<td>Redevelopment Fee</td>
					<td class="cen">25</td>
				</tr>
				<?php
				if($covid==10){
					echo '<tr>
					<td class="cen">'.$q.'</td>
					<td>COVID-19 Fee</td>
					<td class="cen">
						10
					</td>
					</tr>';
					$q++;
				    $total+=10;
				}
					?>
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
				
				
				<?php
					$query = 'SELECT * FROM treatments WHERE `id` IN (' . implode(',', array_map('intval', $treatments)) . ')';
					$res = mysqli_query($conn,$query);
					
					$n=1;
					
					while($row=mysqli_fetch_assoc($res)){

				echo '<tr id="myTableRow">';

					echo '<td class="cen" id="demo'.$n.'">'.$q.'</td>';
					?>
					<td><?php echo $row['name']?></td>
					<td class="cen">
						<?php
						
							$q++;
							if($row['id']==$base){
								$a = $row['amount'];
							}else{
								$a = 10;
							}
							echo $a;
							$total+=$a;
						
						?>

						
					</td>
				</tr>
				<?php
				$n++;
					}
				?>
				
				<tr>
					<td></td>
					<th>Total</th>
					<th><?php echo $total?></th>
				</tr>
			</tbody>
		</table>

		<br>
		<br>

		<p class="left" style="text-transform: capitalize;"><b>In Words: </b><?php echo getIndianCurrency((float)$total); ?></p>

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
        <script>
       
          var table, rows, switching, i, x, y, shouldSwitch;
          table = document.getElementById("myTable");
          switching = true;
          
          while (switching) {
            
            switching = false;
            rows = table.rows;
            
            for (i = 3; i < (rows.length - 2); i++) {
              
              shouldSwitch = false;
              
              x = rows[i].getElementsByTagName("TD")[2];
              y = rows[i + 1].getElementsByTagName("TD")[2];
              n = rows[i].getElementsByTagName("TD")[0];
              n.innerHTML=i;
              if (Number(x.innerHTML) < Number(y.innerHTML)) {
                
                shouldSwitch = true;
                break;
              }
            
            }
            if (shouldSwitch) {
              rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
              
              
              switching = true;
            }
            
          }
        
</script>
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
