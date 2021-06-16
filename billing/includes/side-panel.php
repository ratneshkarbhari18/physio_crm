<div class="sidebar" data-color="grey" data-image="../assets/img/sidebar-5.jpg">
    	<div class="sidebar-wrapper">
        <div class="logo">
            <center>
            <a href="dashboard.php" class="simple-text logo-normal">
                <img src="../assets/img/logo.png" style="width:60%;"/>
            </a>
            </center>
        </div>
			<div class="user">
				<div class="info">
					<div class="photo">
	                    <img src="../assets/img/woman.png" />
	                </div>

					<a data-toggle="collapse" href="#collapseExample" class="collapsed">
						<span>
							<?php echo $_SESSION['billing_name']?>
						</span>
                    </a>


				</div>
            </div>

            <ul class="nav">

                <li class="nav-item" id="nav-dashboard">
                    <a class="nav-link" href="dashboard.php">
                        <i class="nc-icon nc-notes"></i>
                        <p>Unpaid Bills
                        </p>
                    </a>
                </li>

				<li class="nav-item" id="nav-paid">
					<a class="nav-link" href="paid.php">
						<i class="nc-icon nc-single-copy-04"></i>
						<p>Paid Bills
						</p>
					</a>
				</li>
        <li class="nav-item" id="nav-cons">
            <a class="nav-link" href="cons_bills.php">
                <i class="nc-icon nc-notes"></i>
                <p>Consultant Unpaid Bills
                </p>
            </a>
        </li>

      <li class="nav-item" id="nav-cons_paid">
      <a class="nav-link" href="cons_paid.php">
        <i class="nc-icon nc-single-copy-04"></i>
        <p>Consultant Paid Bills
        </p>
      </a>
      </li>
				<li class="nav-item" id="nav-donation">
					<a class="nav-link" href="donation.php">
						<i class="nc-icon nc-money-coins"></i>
						<p>Donation
						</p>
					</a>
				</li>
				<li class="nav-item" id="fd-vouchers">
					<a class="nav-link" href="fd-vouchers.php">
						<i class="nc-icon nc-paper-2"></i>
						<p>FD vouchers
						</p>
					</a>
				</li>
				<li class="nav-item" id="asset-purchase-vouchers">
					<a class="nav-link" href="asset-purchase-vouchers.php">
						<i class="nc-icon nc-paper-2"></i>
						<p>Asset Purchase Vouchers
						</p>
					</a>
				</li>
				<li class="nav-item" id="nav-voucher">
					<a class="nav-link" href="voucher.php">
						<i class="nc-icon nc-paper-2"></i>
						<p>Add Vouchers
						</p>
					</a>
				</li>
				<li class="nav-item" id="all-vouchers">
					<a class="nav-link" href="all-vouchers.php">
						<i class="nc-icon nc-paper-2"></i>
						<p>View All Vouchers
						</p>
					</a>
				</li>
				<li class="nav-item" id="nav-voucher">
					<a class="nav-link" href="ad-vouchers.php">
						<i class="nc-icon nc-paper-2"></i>
						<p>Ad Vouchers
						</p>
					</a>
				</li>
				<li class="nav-item" id="bank-vouchers">
					<a class="nav-link" href="bank-vouchers.php">
						<i class="nc-icon nc-paper-2"></i>
						<p>View Bank Vouchers
						</p>
					</a>
				</li>
				<li class="nav-item" id="docsal-vouchers">
					<a class="nav-link" href="docsal-vouchers.php">
						<i class="nc-icon nc-paper-2"></i>
						<p>View Doc Sal Vouchers
						</p>
					</a>
				</li>
				<!-- <li class="nav-item" id="nav-voucher">
					<a class="nav-link" href="donation-vouchers.php">
						<i class="nc-icon nc-paper-2"></i>
						<p>Donation Vouchers
						</p>
					</a>
				</li> -->
				<li class="nav-item" id="ex-income-vouchers">
					<a class="nav-link" href="ex-income-vouchers.php">
						<i class="nc-icon nc-paper-2"></i>
						<p>View Extra Income Vouchers
						</p>
					</a>
				</li>

				<li class="nav-item" id="nav-voucher">
					<a class="nav-link" href="jv-vouchers.php">
						<i class="nc-icon nc-paper-2"></i>
						<p>View Payable Vouchers
						</p>
					</a>
				</li>
				<li class="nav-item" id="staff-sal-vouchers">
					<a class="nav-link" href="staff-sal-vouchers.php">
						<i class="nc-icon nc-paper-2"></i>
						<p>View Staff Sal Vouchers
						</p>
					</a>
				</li>
				
				<li class="nav-item" id="nav-doc">
					<a class="nav-link" href="doc-sal.php">
						<i class="nc-icon nc-paper-2"></i>
						<p>Doctor Renumeration
						</p>
					</a>
				</li>
				<li class="nav-item" id="nav-staff">
					<a class="nav-link" href="staff-sal.php">
						<i class="nc-icon nc-paper-2"></i>
						<p>Staff Renumeration
						</p>
					</a>
				</li>
				<li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="nc-icon nc-button-power"></i>
                            <p>Logout</p>
                        </a>
                    </li>

            </ul>
    	</div>
    </div>
