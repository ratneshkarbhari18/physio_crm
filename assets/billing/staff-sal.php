
<div class="container-fluid">
    <div class="row">        
        <div class="col-md-7">
     
                            
                            
                                <div class="card-body">
                                    <form class="form-horizontal " action="functions/add-staffsal.php" id="addStaffsalForm">
                                        
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3 control-label" style="text-align:left;">Employee Name</label>
                                                <div class="col-md-9">
												<input type="text" name="name" placeholder="Name" required="" class="form-control">
                                                </div>
                                            </div>
											 </div>
                                            <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3 control-label ">Total No of Days Present:</label>
                                                <div class="col-md-9">
													<input type="number" name="nod" placeholder="No of patients" required="" class="form-control" style="margin-top:9px;">
                                                </div>
                                            </div>
                                        </div>
                                            <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3 control-label">Gross Salary</label>
                                                <div class="col-md-9">
                                                    <input type="number" name="gs" placeholder="Gross Salary" required="" class="form-control">
                                                </div>
                                            </div>
                                       </div>
									   <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3 control-label">Net Salary</label>
                                                <div class="col-md-9">
                                                    <input type="number" name="ns" placeholder="Net Salary" required="" class="form-control">
                                                </div>
                                            </div>
                                       </div>
									   
                                      
                                   
                                    
                                </div>
                                <div class="card-footer ">
                                    <div class="col-md-float-right">
                                        <center>
                                        <button type="submit" id="submit" class="btn btn-fill btn-info">Submit</button>
                                        <button type="button" id="print3"onclick="window.location='preview_voucher.php?s=st';" disabled="true" class="btn btn-fill btn-info" style="background-color:#17a2b8;cursor: not-allowed;">Print</button>
                                        </center>
                                    </div>
                                </div>
								</form>
                           
                        </div>
                        </div>
                    </div>





