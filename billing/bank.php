
<div class="container-fluid">
    <div class="row">        
        <div class="col-md-7">
        
                                <div class="card-body">
                                    <form class="form-horizontal " action="functions/add-bank.php" id="addBankForm">
                                        
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3 control-label" >Name of person</label>
                                                <div class="col-md-9">
                                                    <input type="name" name="name" required="" placeholder="Name of Ac Holder" class="form-control" >
                                                </div>
                                            </div>
											</div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-md-3 control-label" >Name of AC Holder</label>
                                                    <div class="col-md-9">
                                                        <select name="bank_name" id="bank_name" class="form-control">
                                                            <option value="Abhyudaya Bank">Abhyudaya Bank</option>
                                                            <option value="Saraswat Bank">Saraswat Bank</option>
                                                            <option value="Apna Bank">Apna Bank</option>
                                                            <option value="Janakalyan Bank">Janakalyan Bank</option>
                                                        </select>
                                                    </div>
                                                </div>
											</div>
											<div class="form-group">
													<div class="row">
                                                        <label class="col-md-3 control-label" >Date</label>
														<div class="col-md-9">
                                                        <input type="date" required="" placeholder="Date" name="vdate" class="form-control cheque" >
                                                    </div>
                                                </div>
												  </div>
           <!--                                 <div class="form-group">-->
           <!--                                 <div class="row">-->
           <!--                                     <label class="col-md-3 control-label">AC No</label>-->
           <!--                                     <div class="col-md-9">-->
           <!--                                         <input type="text" name="acno" required="" placeholder="AC No" class="form-control">-->
           <!--                                     </div>-->
           <!--                                 </div>-->
											<!--</div>-->
           <!--                                 <div class="form-group">-->
           <!--                                 <div class="row">-->
           <!--                                     <label class="col-md-3 control-label">Bank Name & Branch</label>-->
           <!--                                     <div class="col-md-9">-->
           <!--                                         <input type="text" name="bname" required="" placeholder="Bank Name" class="form-control">-->
           <!--                                     </div>-->
           <!--                                 </div>-->
											<!--</div>-->
           <!--                                 <div class="form-group">-->
           <!--                                 <div class="row">-->
           <!--                                     <label class="col-md-3 control-label">IFSC Code</label>-->
           <!--                                     <div class="col-md-9">-->
           <!--                                         <input type="text" name="ifsc" required="" placeholder="IFSC Code" class="form-control">-->
           <!--                                     </div>-->
           <!--                                 </div>-->
											<!--</div>-->
											  <div class="form-group">
											<div class="row">
                                                    <label class="col-md-3 control-label" >Type of  Transaction</label>
                                                    <div class="col-md-9">
                                                    <select required="" data-title="Select Option" id="type" name="type" class="selectpicker" data-style="btn-info btn-fill" data-menu-style="dropdown-blue">
                                                        <option value="widthdraw">Widthdraw</option>
                                                        <option value="deposit">Deposit</option>
                                                    
                                                    </select>
													  </div>
                                                </div>
												  </div>
												    <div class="form-group">
											<div class="row">
                                                    <label class="col-md-3 control-label" >Mode Of Payment</label>
                                                    <div class="col-md-9">
                                                    <select required="" data-title="Select Payment Mode" id="mode" name="mode" class="selectpicker" data-style="btn-info btn-fill" data-menu-style="dropdown-blue">
                                                        <option value="cash">Cash</option>
                                                        <option value="cheque">Cheque</option>
                                                    
                                                    </select>
													  </div>
                                                </div>
												  </div>

                                                <div id="cheque">
                                                    <div class="form-group">
													<div class="row">
                                                        <label class="col-md-3 control-label" >Bank Name</label>
														<div class="col-md-9">
                                                        <input type="text" required="" placeholder="Bank Name" name="bname" class="form-control cheque" >
                                                    </div>
													  </div>
													    </div>
													    <div class="form-group">
													<div class="row">
                                                        <label class="col-md-3 control-label" >Branch</label>
														<div class="col-md-9">
                                                        <input type="text" required="" placeholder="Bank Branch Name" name="branch" class="form-control cheque" >
                                                    </div>
													  </div>
													    </div>
                                                    <div class="form-group">
													<div class="row">
                                                        <label class="col-md-3 control-label" >Cheque No.</label>
														<div class="col-md-9">
                                                        <input type="text" required="" placeholder="Cheque Number" name="cheque_no" class="form-control cheque" >
                                                    </div>
                                                </div>
												  </div>
												  <div class="form-group">
													<div class="row">
                                                        <label class="col-md-3 control-label" >Cheque Date</label>
														<div class="col-md-9">
                                                        <input type="date" required="" placeholder="Cheque Date" name="cheque_date" class="form-control cheque" >
                                                    </div>
                                                </div>
												  </div>
												    </div>
												    <div class="form-group">
													<div class="row">
                                                        <label class="col-md-3 control-label" >Description</label>
														<div class="col-md-9">
                                                        <input type="text" required="" placeholder="Description" name="purpose" class="form-control" >
                                                    </div>
													  </div>
													    </div>
                                            <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3 control-label">Amount</label>
                                                <div class="col-md-9">
                                                    <input type="number" name="amount" required="" placeholder="Amount" class="form-control">
                                                </div>
                                            </div>
											</div>
                                        
                                      
                                    
                                        
                                      
                                    
                                </div>
                                <div class="card-footer ">
                                    <div class="col-md-float-right">
                                        <center>
                                        <button type="submit" id="submit" class="btn btn-fill btn-info">Submit</button>
                                        <button type="button" id="print1" onclick="window.location='preview_voucher.php?s=b';" disabled="true"  class="btn btn-fill btn-info" style="background-color:#17a2b8;cursor: not-allowed;">Print</button>
                                        </center>
                                    </div>
                                </div>
								</form>
                            
                        </div>
                        </div>
                    </div>





