<div class="sidebar" data-color="grey" data-image="../assets/img/sidebar-5.jpg"">		
    	<div class="sidebar-wrapper">

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
                        <p>Current Bills
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

				<li class="nav-item" id="nav-donation">
					<a class="nav-link" href="donation.php">
						<i class="nc-icon nc-money-coins"></i>
						<p>Donation
						</p>
					</a>
				</li>
				<li class="nav-item" id="nav-voucher">
					<a class="nav-link" href="voucher.php">
						<i class="nc-icon nc-paper-2"></i>
						<p>vouchers
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
