<?php
session_start();
require_once('../sessioncheck.php');
include_once('../config/config.php');

$sql = "SELECT * FROM tbSubject"; // SQL query to fetch all data
$stmt = $conn->prepare($sql); // Prepare the SQL statement
$stmt->execute(); // Execute the prepared statement
$results = $stmt->fetchAll(); // Fetch all results

?>

<!DOCTYPE html>
<html lang="en-IN">
<head>
    <title>Teacher Classes | ApprizeTutorial</title>
    <link rel="shortcut icon" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="../public/css/admin.css"/>
</head>
<body>
    <div id="wrapwrap" class="classpage">
        <header id="top" class="o_header_standard">
            <nav data-name="Navbar" aria-label="Main" class="navbar navbar-expand-lg navbar-light o_colored_level o_cc d-none d-lg-block shadow-sm ">
                <div id="o_main_nav" class="o_main_nav container">
                    
            <a data-name="Navbar Logo" class="navbar-brand logo me-4">
                <span role="img" aria-label="Logo of ApprizeTutorial" title="ApprizeTutorial"><img src="../images/logo.png" class="img img-fluid" width="95" height="40" alt="ApprizeTutorial" loading="lazy"/></span>
            </a>
            <!-- Navbar menu items -->
        <ul role="menu" id="top_menu" class="nav navbar-nav top_menu o_menu_loading me-auto">
        <li role="presentation" class="nav-item">
            <a role="menuitem" href="dashboard.php" class="nav-link ">
                <span>Dashboard</span>
            </a>
        </li>
        <li role="presentation" class="nav-item">
            <a role="menuitem" href="event.php" class="nav-link ">
                <span>Events</span>
            </a>
        </li>   
        <li role="presentation" class="nav-item">
            <a role="menuitem" href="class.php" class="nav-link active">
                <span>Classes</span>
            </a>
        </li> 
        <li role="presentation" class="nav-item">
            <a role="menuitem" href="timetable.php" class="nav-link">
                <span>Time Table</span>
            </a>
        </li>
        </ul>  
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

        <div class="content">
        <?php foreach ($results as $row): ?>
            <div class="class-card">
                <span><td><?php echo htmlspecialchars($row['Name']); ?></td></span>
                <div class="action-btns">
                    <a href="resource.php?SubjectID=<?php echo $row['SubjectID']; ?>">Upload Resources</a>
                </div>
            </div>
         <?php endforeach; ?>
        <div class="class-card">
        <span><td>Progress Report</td></span>
        <div class="action-btns">
            <a href="progress_report.php">Upload Results</a>
        </div>
        </div>
        </div>

    <footer id="bottom" class="o_footer o_colored_level o_cc">
        <div id="footer" class="oe_structure oe_structure_solo">
            <section class="s_text_block pt48">
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
            <section class="s_text_block">
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
    </div>
</body>
</html>
