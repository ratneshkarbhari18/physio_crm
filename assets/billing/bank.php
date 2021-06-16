
<div class="container-fluid">
    <div class="row">        
        <div class="col-md-7">
        
                           
                            
                                <div class="card-body">
                                    <form class="form-horizontal " action="functions/add-bank.php" id="addBankForm">
                                        
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-md-3 control-label" >Name of AC Holder</label>
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
                                                        </select>
                                                    </div>
                                                </div>
											</div>
                                            <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3 control-label">AC No</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="acno" required="" placeholder="AC No" class="form-control">
                                                </div>
                                            </div>
											</div>
                                            <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3 control-label">Bank Name & Branch</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="bname" required="" placeholder="Bank Name" class="form-control">
                                                </div>
                                            </div>
											</div>
                                            <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3 control-label">IFSC Code</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="ifsc" required="" placeholder="IFSC Code" class="form-control">
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





