<?php
session_start();
require_once('../sessioncheck.php');
include_once('../config/config.php');

$sql = "SELECT day, subject 
        FROM tbtimetable 
        ORDER BY FIELD(day, 'mon', 'tue', 'wed', 'thu', 'fri')";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<head>
    <title> Time Table | ApprizeTutorial </title> 
    <link type="text/css" rel="stylesheet" href="../public/css/style.css"/>
</head>
<body>
    <div id="wrapwrap" class="classpage">
        <header id="top" data-anchor="true" data-name="Header" data-extra-items-toggle-aria-label="Extra items button" class="o_header_standard">
            <nav data-name="Navbar" aria-label="Main" class="navbar navbar-expand-lg navbar-light o_colored_level o_cc d-none d-lg-block shadow-sm">
                <div id="o_main_nav" class="o_main_nav container">
                    <a data-name="Navbar Logo" class="navbar-brand logo me-4">
                        <span role="img" aria-label="Logo of ApprizeTutorial" title="ApprizeTutorial">
                            <img src="../images/logo.png" width="95" height="40" alt="ApprizeTutorial"/>
                        </span>
                    </a>
                    <ul role="menu" id="top_menu" class="nav navbar-nav top_menu o_menu_loading me-auto">
                        <li role="presentation" class="nav-item">
                            <a role="menuitem" href="dashboard.php" class="nav-link">
                                <span>Home</span>
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a role="menuitem" href="event.php" class="nav-link">
                                <span>Events</span>
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a role="menuitem" href="class.php" class="nav-link">
                                <span>Classes</span>
                            </a>
                        </li>   
                        <li role="presentation" class="nav-item">
                            <a role="menuitem" href="timetable.php" class="nav-link active ">
                                <span>Time Table</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav align-items-center gap-2 flex-shrink-0 justify-content-end ps-3">
                    <li class=" o_no_autohide_item">
            <?php if (isset($_SESSION["userID"])) { ?>
                        <a href="../login.php" class="btn btn-outline-secondary">Sign out</a>
                    <?php }else {?>
                        <a href="../login.php" class="btn btn-outline-secondary">Sign in</a> <!-- Sign in button -->
                        <?php }?>
            </li> 
                    </ul>
                </div>
            </nav>
        </header>
</head>
<body>
    <h1><br>TIME TABLE</h1>
    <table id="timetable" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Day/Period</th>
            <th>I<br>9:30-10:20</th>
            <th>II<br>10:20-11:10</th>
            <th>III<br>11:10-12:00</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $currentDay = "";
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) { 
            if ($row['day'] != $currentDay) {
                $currentDay = $row['day'];
            ?>
        <tr>
            <td><?php echo htmlspecialchars($row['day']); ?></td>
            <td><?php echo htmlspecialchars($row['subject']); ?></td>
    <?php } else { ?> 
            <td><?php echo htmlspecialchars($row['subject']); ?></td>
        
<?php }  }   echo "</tr>"; ?>
    </tbody>
    </table>
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
</body>
</html>