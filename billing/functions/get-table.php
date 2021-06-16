<?php
$res2="";
    if(!isset($first))
        include '../../includes/db.php';


    function calculate($id, $pid, $base, $other,$covid){
        $total = 0;
        $res = "";
		global $res2;
        global $conn;
        $res.="Redevelopment Fee<br>";
		$res2 .="Rs. 25 <br>";
        $total += 25;
        if($covid==10){
            $res.="COVID-19 Fee<br>";
		$res2 .="Rs. 10 <br>";
        $total += 10;
        }
        $query = "SELECT MIN(id) FROM reports WHERE p_id=$pid";
        $r = mysqli_query($conn,$query);
        if(mysqli_affected_rows($conn)>0){
            $row = mysqli_fetch_array($r);
            if($id==$row[0]){
                $res.="First Visit Fee<br>";
				$res2 .="Rs. 10<br>";
                $total +=10;
            }
        }
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
			$res2 .="Rs. ".$a."<br>";
            $total+=$a;
        }
        
        $res.="<b>Total</b> ";
		$res2.="<b>Rs. ".$total."</b><br>";
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
                                                $query = "SELECT r.id,r.p_id,r.base_treatment,r.treatments,p.fname,p.lname,r.covid FROM patients p, reports r WHERE r.p_id=p.id AND r.paid=b'0' AND r.pay_time IS NULL";
                                                $res = mysqli_query($conn,$query);
                                                while ($row = mysqli_fetch_assoc($res)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['id']?></td>
                                                <td><?php echo $row['p_id']?></td>
                                                <td><?php echo $row['fname']." ".$row['lname']?></td>
                                                <td><?php echo calculate($row['id'],$row['p_id'],$row['base_treatment'],$row['treatments'],$row['covid'])?></td>
												<td class="text-center"><?php echo $res2; $res2="";?></td>
                                                <td><button class="btn btn-success" onclick="pay(<?php echo $row['id']?>)">Pay</button>
                                                <button type="button" style="background-color: red; color: white;" class="btn btn-danger"  data-toggle="modal" data-target="#deleteRecordModal-<?php echo $row["id"]; ?>">Delete</button>
                                                <div class="modal fade" id="deleteRecordModal-<?php echo $row["id"]; ?>" tabindex="-1" aria-labelledby="<?php echo $row["id"]; ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <form action="functions/delete_unpaid_record.php" method="post">
                                                                <input type="hidden" name="record_id" value="<?php echo $row["id"]; ?>">
                                                                <h4>Are you sure to delete these record?</h4>
                                                                <button style="background-color: red; color: white;" class="btn btn-danger" type="submit" >Yes, Delete it</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
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