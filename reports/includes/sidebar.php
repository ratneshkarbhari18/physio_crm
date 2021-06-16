
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
                    <div class="photo">
                        <img src="../assets/img/reports.png" />
                    </div>
                    <div class="info ">
                        <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                            <span><?php echo $_SESSION['reports_name']?>
                            </span>
                        </a>
                    </div>
                </div>
                <ul class="nav">
                   <!-- <li class="nav-item" id="nav-cash-bank">
                        <a class="nav-link" href="cash-bank.php">
                            <i class="nc-icon nc-bank"></i>
                            <p>Cash & Bank Report</p>
                        </a>
                    </li>-->
                    <li class="nav-item" id="nav-donation">
                        <a class="nav-link" href="donation.php">
                            <i class="nc-icon nc-money-coins"></i>
                            <p>Donation Report</p>
                        </a>
                    </li>
                   <!-- <li class="nav-item" id="nav-outstanding">
                        <a class="nav-link" href="outstanding.php">
                            <i class="nc-icon  nc-notes"></i>
                            <p>Outstanding Report</p>
                        </a>
                    </li>-->
                    <li class="nav-item" id="nav-doctorst">
                        <a class="nav-link" href="doctor-st.php">
                            <i class="nc-icon nc-badge"></i>
                            <p>Summary Report</p>
                        </a>
                    </li>
                    <li class="nav-item" id="nav-doctor">
                        <a class="nav-link" href="doctor.php">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Doctor Remuneration</p>
                        </a>
                    </li>
                    <li class="nav-item" id="nav-salary">
                        <a class="nav-link" href="salary.php">
                            <i class="nc-icon nc-notes"></i>
                            <p>Staff Remuneration</p>
                        </a>
                    </li>
					<li class="nav-item" id="ip-pnl">
                        <a class="nav-link" href="pnl_ip.php">
                            <i class="nc-icon nc-single-copy-04"></i>
                            <p>Profit and Loss</p>
                        </a>
                    </li>
                    <!--<li class="nav-item" id="nav-sheet">-->
                    <!--    <a class="nav-link" href="last_year_amounts.php">-->
                    <!--        <i class="nc-icon nc-single-copy-04"></i>-->
                    <!--        <p>Last Year Amounts</p>-->
                    <!--    </a>-->
                    <!--</li>-->
                    <li class="nav-item" id="nav-sheet">
                        <a class="nav-link" href="balancesheet.php">
                            <i class="nc-icon nc-single-copy-04"></i>
                            <p>Balance Sheet</p>
                        </a>
                    </li>

                    <li class="nav-item" id="nav-daily">
                        <a class="nav-link" href="cashbook.php">
                            <i class="nc-icon nc-single-copy-04"></i>
                            <p>Cashbook</p>
                        </a>
                    </li>
                    <li class="nav-item" id="nav-bill">
                        <a class="nav-link" href="bill.php">
                            <i class="nc-icon nc-paper-2"></i>
                            <p>Treatment's Report</p>
                        </a>
                    </li>
                    <li class="nav-item" id="nav-consultant">
                        <a class="nav-link" href="consultant.php">
                            <i class="nc-icon nc-paper-2"></i>
                            <p>Consultant Bill Report</p>
                        </a>
                    </li>
                    <li class="nav-item" id="nav-detail">
                        <a class="nav-link" href="detailed.php">
                            <i class="nc-icon nc-paper-2"></i>
                            <p>Detail Report</p>
                        </a>
                    </li>
                    <li class="nav-item" id="nav-v">
                        <a class="nav-link" href="vouchers.php">
                            <i class="nc-icon nc-money-coins"></i>
                            <p>Vouchers Report</p>
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
