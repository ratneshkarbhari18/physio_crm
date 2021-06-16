
<div class="container-fluid">
    <div class="row">        
        <div class="col-md-7">
     
                            
                            
                                <div class="card-body">
                                    <form class="form-horizontal " action="functions/add-docsal.php" id="addDocsalForm">
                                        
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3 control-label" style="text-align:left;"> Doctor's Name</label>
                                                <div class="col-md-9">
												<select  style="margin-top:1%;" id="dd" name="name" class="selectpicker" data-style="btn-info btn-fill btn-block" data-menu-style="dropdown-blue" style="width:29%!important;"> 
												<option value="none">Select Option</option>
												<?php
                                                $query = "SELECT id, name FROM users WHERE type='doctor'";
                                                $res = mysqli_query($conn,$query);
                                                while ($row = mysqli_fetch_assoc($res)) {
                                                    $id = $row['id'];
                                                    $q = "SELECT * FROM reports WHERE doc_id=$id AND paid=1";
                                                    $r = mysqli_query($conn, $q);
                                                    $count = mysqli_num_rows($r);
                                                    $amount = 0;
                                                    while($rw = mysqli_fetch_assoc($r)){
                                                        //$amount+=calculate($rw['id'],$rw['p_id'],$rw['base_treatment'],$rw['treatments']);
                                                    }
                                            ?>
														
												<?php
												echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
                                                }
                                            ?>
                                                        
                        </select>
                                                </div>
                                            </div>
											 </div>
                                            <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3 control-label ">Total No of Patient Treated</label>
                                                <div class="col-md-9">
													<input type="number" name="nop" placeholder="No of patients" required="" class="form-control" style="margin-top:9px;">
                                                </div>
                                            </div>
                                        </div>
                                            <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3 control-label">Salary</label>
                                                <div class="col-md-9">
                                                    <input type="number" name="amount" placeholder="Salary" required="" class="form-control">
                                                </div>
                                            </div>
                                       </div>
									   
                                      
                                   
                                    
                                </div>
                                <div class="card-footer ">
                                    <div class="col-md-float-right">
                                        <center>
                                        <button type="submit" id="submit" class="btn btn-fill btn-info">Submit</button>
                                        <button type="button" id="print2" onclick="window.location='preview_voucher.php?s=doc';" disabled="true" class="btn btn-fill btn-info" style="background-color:#17a2b8;cursor: not-allowed;">Print</button>
                                        </center>
                                    </div>
                                </div>
								</form>
                           
                        </div>
                        </div>
                    </div>





