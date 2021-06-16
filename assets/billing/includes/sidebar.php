
        <div class="sidebar" data-color="orange" data-image="assets/img/sidebar-5.jpg">
            
            <div class="sidebar-wrapper">
                <div class="logo">
                    <center>
                    <a href="dashboard.php" class="simple-text logo-normal">
                        SUMI
                    </a>
                    </center>
                </div>
                <div class="user">
                    <div class="photo">
                        <img src="assets/img/admin.png" />
                    </div>
                    <div class="info ">
                        <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                            <span><?php echo $_SESSION['name']?>
                                <b class="caret"></b>
                            </span>
                        </a>
                        <div class="collapse" id="collapseExample">
                            <ul class="nav">
                                <li>
                                    <a class="profile-dropdown" href="#">
                                        <span class="sidebar-mini">MP</span>
                                        <span class="sidebar-normal">My Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="profile-dropdown" href="#">
                                        <span class="sidebar-mini">EP</span>
                                        <span class="sidebar-normal">Edit Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="profile-dropdown" href="#">
                                        <span class="sidebar-mini">S</span>
                                        <span class="sidebar-normal">Settings</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="nav">
                    <li class="nav-item" id="nav-dashboard">
                        <a class="nav-link" href="dashboard.php">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#formsExamples">
                            <i class="nc-icon nc-notes"></i>
                            <p>
                                Forms
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse " id="formsExamples">
                            <ul class="nav">
                                <li class="nav-item " id="nav-add-project">
                                    <a class="nav-link" href="add-project.php">
                                        <span class="sidebar-mini">AP</span>
                                        <span class="sidebar-normal">Add Project</span>
                                    </a>
                                </li>
                                <li class="nav-item " id="nav-add-tendersure">
                                    <a class="nav-link" href="add-tendersure.php">
                                        <span class="sidebar-mini">AT</span>
                                        <span class="sidebar-normal">Add TenderSURE</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#viewExamples">
                            <i class="nc-icon nc-zoom-split"></i>
                            <p>
                                View
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse " id="viewExamples">
                            <ul class="nav">
                                <li class="nav-item " id="nav-project">
                                    <a class="nav-link" href="view-project.php">
                                        <span class="sidebar-mini">P</span>
                                        <span class="sidebar-normal">Project</span>
                                    </a>
                                </li>
                                <li class="nav-item " id="nav-tendersure">
                                    <a class="nav-link" href="view-tendersure.php">
                                        <span class="sidebar-mini">T</span>
                                        <span class="sidebar-normal">TenderSURE</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
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