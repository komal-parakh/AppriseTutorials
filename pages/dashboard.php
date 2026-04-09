<?php
session_start();
require_once('../sessioncheck.php');
include_once('../config/config.php');
?>

<html lang="en-IN" >
    <head> 
        <title> Home | ApprizeTutorial </title>
        <link type="image/x-icon" rel="shortcut icon"/> 
        <link type="text/css" rel="stylesheet" href="../public/css/style.css"/>
    </head>
    <body>
        <!-- Main wrapper for the entire page content -->
        <div id="wrapwrap" class="homepage">
    <header id="top" data-anchor="true" data-name="Header" data-extra-items-toggle-aria-label="Extra items button" class="   o_header_standard" >
        <!--Desktop navbar-->      
        <nav data-name="Navbar" aria-label="Main" class="navbar navbar-expand-lg navbar-light o_colored_level o_cc d-none d-lg-block shadow-sm ">
        <div id="o_main_nav" class="o_main_nav container">
            
        <a data-name="Navbar Logo" class="navbar-brand logo me-4">
        <span role="img" aria-label="Logo of ApprizeTutorial" title="ApprizeTutorial"><img src="../images/logo.png" class="img img-fluid" width="95" height="40" alt="ApprizeTutorial" loading="lazy"/></span>
        </a>
        <!-- Navbar menu items -->
        <ul role="menu" id="top_menu" class="nav navbar-nav top_menu o_menu_loading me-auto">
        <li role="presentation" class="nav-item">
        <a role="menuitem" href="dashboard.php" class="nav-link active">
        <span>Home</span>
        </a>
        </li>
        <li role="presentation" class="nav-item">
        <a role="menuitem" href="event.php" class="nav-link ">
        <span>Events</span>
        </a>
        </li>   
        <li role="presentation" class="nav-item">
        <a role="menuitem" href="class.php" class="nav-link">
        <span>Classes</span>
        </a>
        </li> 
        <li role="presentation" class="nav-item">
        <a role="menuitem" href="timetable.php" class="nav-link">
        <span>Time Table</span>
        </a>
        </li>
        </ul>  
        <ul class="navbar-nav align-items-center gap-2 flex-shrink-0 justify-content-end ps-3"> 
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

    <main><!-- Main content -->          
        
    <div id="wrap" class="oe_structure">

        <section class="s_cover oe_img_bg" data-scroll-background-ratio="0" data-snippet="s_cover">
            <div class="container s_allow_columns">
                <h1 class="display-3" style="text-align: center; font-weight: bold;">Apprize Tutorials</h1>
                <p class="lead" style="text-align: center;">Step in as a Student. Step out as a Professionals</p>
            </div>
        </section>
        <!-- Section containing text and image with padding top and bottom -->
        <section class="s_text_image pt32 pb32" data-snippet="s_text_image">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Column for the text content with padding top and bottom -->
                    <div class="pt16 pb16 col-lg-4 offset-lg-1">
                        <h2>Committed to Your Success</h2>
                        <p>Our tutors are carefully selected from top professionals in their respective fields. They are not just educators, but experts in their areas of specialization.</p>
                        <p>Students, learners, and knowledge-seekers excelling in their academic pursuits.</p>
                        <!-- Horizontal separator line -->
                    <div class="s_hr text-start p0 pb32" data-snippet="s_hr" data-name="Separator">
                        <!-- Styling for the horizontal line -->
                <hr class="w-100 mx-auto" style="border-top-width: 1px; border-top-style: solid; border-top-color: var(--o-color-3) !important;"/>
                    </div>
                    </div>
                    <div class="pt16 pb16 col-lg-5 offset-lg-1">
                        <img src="../images/teachers.jpg" style="width: 550px;" loading="lazy"/>
                    </div>
                </div>
            </div>
        </section>

        <section class="s_text_image pt32 pb32" data-snippet="s_image_text">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Column for the image content with padding top and bottom -->
                    <div class="pt16 pb16 col-lg-5 offset-lg-1">
                        <img src="../images/garbha.jpeg" style="width: 550px; margin-left: -80px;" loading="lazy"/>
                    </div>
                    <!-- Column for the text content with padding top and bottom -->
                    <div class="pt16 pb16 col-lg-4 offset-lg-1">
                        <h2>What sets us apart?</h2>
                        <p> We provide personalized attention to each student in a warm and modern setting, ensuring that they receive individualized support and guidance.</p>
                        <p>Experience individualized attention and support from our team of expert tutors.</p>
            <!-- Horizontal separator line -->
            <div class="s_hr text-start p0 pb32" data-snippet="s_hr" data-name="Separator">
            <!-- Styling for the horizontal line -->
            <hr class="w-100 mx-auto" style="border-top-width: 1px; border-top-style: solid; border-top-color: var(--o-color-3) !important;"/>
            </div>
        </section>

        <section class="s_color_blocks_2" data-snippet="s_color_blocks_2">
            <!-- Container for the section content -->
            <div class="container-fluid">
                <!-- Row for the color blocks -->
                <div class="row-1">
                    <!-- Column for the first color block with text center alignment and background image -->
                    <div class="col-lg-6 o_cc text-center oe_img_bg o_bg_img_center o_cc5">
                        <!-- Background filter for the image -->
                        <div class="o_we_bg_filter bg-black-50"></div>
                        <h3>Our Programs</h3>
                        <p1>Are you looking for a private tutor who can provide personalized attention and customized lesson plans? Look no further!</p1>
                    </div>
                    <div class="col-lg-6 o_cc o_cc5 text-center oe_img_bg o_bg_img_center">
                        <div class="o_we_bg_filter bg-black-50"></div>
                        <h3>Our location</h3>
                        <p1>Our private tutoring services are conveniently located in the heart of the city and easily accessible by car or public transportation.</p1>
                    </div>
                </div>
            </div>
        </section>

    </div>
        <!-- Placeholder for shared blocks, making them unremovable -->
        <div id="o_shared_blocks" class="oe_unremovable"></div>
                </main><!-- Main footer section with anchor and name attributes -->
               
               
            <footer id="bottom" data-anchor="true" data-name="Footer" class="o_footer o_colored_level o_cc ">
            <div id="footer" class="oe_structure oe_structure_solo">
            <section class="s_text_block pt48" data-snippet="s_text_block" data-name="Text">
            <div class="container">
            <div class="row">
            <!-- Column for the title with padding bottom -->
            <div class="col-lg-3 pb24">
            <h4><b>Apprize Tutorials</b> 
            </div>
            <div class="col-lg-9 pb24">
            <p class="lead">We are a team of passionate people whose goal is to improve everyone's life.</p>
            </div>
            </div>
            </div>
            </section>
            <!-- Section containing another text block -->
            <section class="s_text_block" data-snippet="s_text_block" data-name="Text">
            <div class="container">
            <div class="row align-items-center">
            <!-- Column for the contact information with padding bottom -->
            <div class="col-lg-3 pb24">
            <ul class="ps-3 mb-0">
            </ul>
            </div>
            <div class="col-lg-6 pb24">
            <ul class="list-unstyled mb-0">
                <!-- Contact phone number with icon -->
                <li><img src="../images/icon.png" alt="Phone Icon" width="20" height="20" class="me-2"></span><a href="tel:+91 99231 36446">+91 99231 36446</a></span></li>
                <li><img src="../images/icon2.png" alt="Email Icon" width="20" height="20" class="me-2"><span><a href="mailto:apprizetutorials@gmail.com">apprizetutorials@gmail.coml</a></span></li>
            </ul>
            </div>
            </div>
            </div>
            </section>
            </div>
                <div class="col-sm text-center text-sm-end o_not_editable"></div>
            </div>
            </div>
            </div>
            </footer>
        
        </body>
</html>
