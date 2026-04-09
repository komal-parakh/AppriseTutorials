<?php
session_start();
require_once('../sessioncheck.php');
include_once('../config/config.php');

?>

<!DOCTYPE html>
<html lang="en-IN">
<head>
    <title>Admin Events | ApprizeTutorial</title>
    <link type="text/css" rel="stylesheet" href="../public/css/admin.css"/>
    <link type="text/css" rel="stylesheet" href="../public/css/style.css"/>
</head>
<body>
    <header id="top" class="o_header_standard">
    <nav data-name="Navbar" aria-label="Main" class="navbar navbar-expand-lg navbar-light o_colored_level o_cc d-none d-lg-block shadow-sm ">
        <div id="o_main_nav" class="o_main_nav container">
                    
        <a data-name="Navbar Logo" class="navbar-brand logo me-4">
            <span role="img" aria-label="Logo of ApprizeTutorial" title="ApprizeTutorial"><img src="../images/logo.png" class="img img-fluid" width="95" height="40" alt="ApprizeTutorial" loading="lazy"/></span>
        </a>
            
    <ul class="navbar-nav align-items-center gap-2 flex-shrink-0 justify-content-end ps-3"> <!-- Right-side navigation items -->
        <li class=" divider d-none"></li>    <!-- Hidden divider item -->                        
            <li data-name="Language Selector" class="o_header_language_selector "></li>
                <li class=" o_no_autohide_item">
                    <?php if (isset($_SESSION["userID"])) { ?>
                    <a href="../login.php" class="btn btn-outline-secondary">Sign out</a> <!-- Sign in button -->
                   <?php }else {?>
                    <a href="../login.php" class="btn btn-outline-secondary">Sign in</a> <!-- Sign in button -->
                    <?php }?>

                </li>   
    </ul>
                </div>       
        </nav> 
    </header>

     <div class="content-1">
     <a href="event.php" ><div class="card-1"><h2>Events</h2></div></a>
     <a href="class.php" ><div class="card-1"><h2>Classes</h2></div></a>
     <a href="timetable.php"><div class="card-1"><h2>Time Table</h2></div></a>
    </div>

    <footer id="bottom" data-anchor="true" data-name="Footer" class="o_footer o_colored_level o_cc">
        <div id="footer" class="oe_structure oe_structure_solo">
            <section class="s_text_block pt48" data-snippet="s_text_block" data-name="Text">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 pb24">
                            <h4><b>Apprize Tutorials</b></h4>
                        </div>
                        <div class="col-lg-9 pb24">
                            <p class="lead">We are a team of passionate people whose goal is to improve everyone's life.</p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="s_text_block" data-snippet="s_text_block" data-name="Text">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3 pb24">
                            <ul class="ps-3 mb-0"></ul>
                        </div>
                        <div class="col-lg-6 pb24">
                            <ul class="list-unstyled mb-0">
                                <li><img src="../images/icon.png" alt="Phone Icon" width="20" height="20" class="me-2"><a href="tel:+91 99231 36446">+91 99231 36446</a></li>
                                <li><img src="../images/icon2.png" alt="Email Icon" width="20" height="20" class="me-2"><a href="mailto:apprizetutorials@gmail.com">apprizetutorials@gmail.com</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </footer>
</html>
