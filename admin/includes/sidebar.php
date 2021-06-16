
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
                        <img src="../assets/img/doctor.png" />
                    </div>
                    <div class="info ">
                        <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                            <span> <?php echo $_SESSION['admin_name']?>
                            </span>
                        </a>
                    </div>
                </div>
                <ul class="nav">
                    <li class="nav-item" id="nav-user">
                        <a class="nav-link" href="users.php">
                            <i class="nc-icon nc-single-02"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    <li class="nav-item" id="nav-treat">
                        <a class="nav-link" href="treatments.php">
                            <i class="nc-icon nc-favourite-28"></i>
                            <p>Treatments</p>
                        </a>
                    </li>
                    <li class="nav-item" id="nav-reff-doc">
                        <a class="nav-link" href="refering-dr.php">
                            <i class="nc-icon nc-vector"></i>
                            <p>Refering Dr</p>
                        </a>
                    </li>
                    <!--<li class="nav-item" id="nav-bed">
                        <a class="nav-link" href="add-bedmaster.php">
                            <i class="nc-icon nc-key-25"></i>
                            <p>Bedmaster</p>
                        </a>
                    </li>-->
                    <!--<li class="nav-item" id="nav-donor">-->
                    <!--    <a class="nav-link" href="donor.php">-->
                    <!--        <i class="nc-icon nc-chart-pie-36"></i>-->
                    <!--        <p>Donor</p>-->
                    <!--    </a>-->
                    <!--</li>-->
                    <li class="nav-item" id="nav-add-reports">
                        <a class="nav-link" href="../reports/dashboard.php">
                            <i class="nc-icon nc-notes"></i>
                            <p>Reports</p>
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
