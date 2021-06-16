<div class="container-fluid">
    <div class="row">
        <div class="col-md-7">
                          
                                <div class="card-body">
                                    <form class="form-horizontal " action="functions/add-jv.php" id="addjvForm">
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3 control-label ">Payable To</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="pay" required="" placeholder="Name" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3 control-label">Purpose</label>
                                                <div class="col-md-9">
                                                    <input type="amount" name="pur" required="" placeholder="Purpose" class="form-control">
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
                                                <label class="col-md-3 control-label">Amount</label>
                                                <div class="col-md-9">
                                                    <input type="number" name="amount" required="" placeholder="Amount" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3 control-label">Amount in words</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="amount-word" required="" placeholder="Amount in words" class="form-control">
                                                </div>
                                            </div>
                                          
                                      
                                    </form>
                                </div>
                                <div class="card-footer ">
                                    <div class="col-md-float-right">
                                        <center>
                                        <button type="submit" id="submit" class="btn btn-fill btn-info">Submit</button>
                                        <button type="button" onclick="window.location='preview_voucher.php?s=jv';"  id="print5" disabled="true"  class="btn btn-fill btn-info" style="background-color:#17a2b8;cursor: not-allowed;">Print</button>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                   
					</div>
					</div>
					</div>

