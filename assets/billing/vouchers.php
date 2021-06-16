

<div class="container-fluid">
    <div class="row">
        <div class="col-md-7">
                          
                                <div class="card-body">
                                    <form class="form-horizontal " action="functions/add-voucher.php" id="addVoucherForm">
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3 control-label ">Convection</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="convection" required="" placeholder="Convection" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-3 control-label">Narration</label>
                                                <div class="col-md-9">
                                                    <input type="amount" name="narration" required="" placeholder="Naration" class="form-control">
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
                                            <div class="form-group">
                                            <div class="row">
             
                                                <div class="col-md-9">
                                                    <input type="hidden"  name="t" id="abc" required="" placeholder="Amount in words" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                      
                                    </form>
                                </div>
                                <div class="card-footer ">
                                    <div class="col-md-float-right">
                                        <center>
                                        <button type="submit" id="submit" class="btn btn-fill btn-info">Submit</button>
                                        <button type="button" onclick="window.location='preview_voucher.php?s=de';"  id="print" disabled="true"  class="btn btn-fill btn-info" style="background-color:#17a2b8;cursor: not-allowed;">Print</button>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                   
					</div>
					</div>
					</div>


