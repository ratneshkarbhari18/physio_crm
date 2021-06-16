<?php
$res2="";
    if(!isset($first))
        include '../../includes/db.php';


    function calculate($id, $pid, $base, $other){
        $total = 0;
        $res = "";
		global $res2;
        global $conn;
        $t = array(json_decode($base,true)['id']);
        $b = $t[0];
        $array = json_decode($other,true);
        foreach($array as $i){
            array_push($t,$i['id']);
        } 
        foreach($t as $i){
            $query = "SELECT * FROM treatments WHERE id=$i";
            
            $r = mysqli_query($conn,$query);
            $row = mysqli_fetch_assoc($r);
            if($b == $i){
                $a = $row["amount"];
			//$res2 .=$a."<br>";
			}
            else
                $a = 10;
            $res .= $row["name"]."<br>";
			$res2 .=$a."<br>";
            $total+=$a;
        }
        $res.="Redevelopment Fee<br>";
		$res2 .="25 <br>";
        $total += 25;
        $query = "SELECT MIN(id) FROM reports WHERE p_id=$pid";
        $r = mysqli_query($conn,$query);
        if(mysqli_affected_rows($conn)>0){
            $row = mysqli_fetch_array($r);
            if($id==$row[0]){
                $res.="First Visit Fee<br>";
				$res2 .=" 10<br>";
                $total +=10;
            }
        }
        $res.="<b>Total</b> ";
		$res2.=$total."<br>";
        return $res;
    }
?>
         <div class="content">
                <div class="container-fluid">
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card bootstrap-table">
                                <div class="card-body table-full-width">
                                    <div class="toolbar">
									</div>
                                    <table id="bootstrap-table" class="table">
                                        <thead>
                                            <th data-field="id" data-sortable="true" class="text-center">Bill ID</th>
                                            <th data-field="pid" data-sortable="true" class="text-center">Patient ID</th>
                                            <th data-field="name" data-sortable="true">Name</th>
											<th data-field="treatmentname">Treatment Name</th>
                                            <th data-field="treatmentcost" class="text-center">Treatment Cost</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $query = "SELECT r.id,r.p_id,r.base_treatment,r.treatments,p.fname,p.lname FROM patients p, reports r WHERE r.p_id=p.id AND r.paid=b'0' AND r.pay_time IS NULL";
                                                $res = mysqli_query($conn,$query);
                                                while ($row = mysqli_fetch_assoc($res)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['id']?></td>
                                                <td><?php echo $row['p_id']?></td>
                                                <td><?php echo $row['fname']." ".$row['lname']?></td>
                                                <td><?php echo calculate($row['id'],$row['p_id'],$row['base_treatment'],$row['treatments'])?></td>
												<td class="text-center"><?php echo $res2; $res2="";?></td>
                                                <td><button class="btn btn-success" onclick="pay(<?php echo $row['id']?>)">Pay</button></td>
                                            </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>