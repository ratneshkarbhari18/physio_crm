
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
                            <span>Dr. <?php echo $_SESSION['doctor_name']?>
                            </span>
                        </a>
                    </div>
                </div>
                <ul class="nav">
                    <li class="nav-item" id="nav-dashboard">
                        <a class="nav-link" href="dashboard.php">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item" id="nav-add-report">
                        <a class="nav-link" href="add-report.php">
                            <i class="nc-icon nc-notes"></i>
                            <p>Find/Add Patient</p>
                        </a>
                    </li>
                    <li class="nav-item" id="nav-add-report">
                        <a class="nav-link" href="add-patientx.php">
                            <i class="nc-icon nc-notes"></i>
                            <p>Corrections</p>
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
