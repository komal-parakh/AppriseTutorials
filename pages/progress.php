<?php
session_start();
require_once('../sessioncheck.php');
include_once('../config/config.php');

if (!isset($_SESSION['userID']) || $_SESSION['status'] !== 'student') {
    header("Location: ../login.php");
    exit;
}

$studentID = $_SESSION['userID']; // Get the logged-in student's ID

try {
    // Fetch progress data for the logged-in student
    $sql = "SELECT Subject, Grade, attendanceP, Remarks FROM tbProgress WHERE studentID = :studentID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':studentID', $studentID, PDO::PARAM_INT);
    $stmt->execute();
    $progressRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en-IN">
<head>
    <title>Progress Report | ApprizeTutorial</title>
    <link rel="shortcut icon" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="../public/css/style.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js CDN -->
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
                <span>Home</span>
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
        <main>
        
        <h1>Progress Report</h1>
<table>
    <thead>
        <tr>
            <th>Subject</th>
            <th>Grade</th>
            <th>Attendance (%)</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($progressRecords)): ?>
            <?php foreach ($progressRecords as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Subject']); ?></td>
                    <td><?php echo htmlspecialchars($row['Grade']); ?></td>
                    <td><?php echo htmlspecialchars($row['attendanceP']); ?></td>
                    <td><?php echo htmlspecialchars($row['Remarks']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No progress reports available.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

        <canvas id="progressChart" width="400" height="200"></canvas>
        
    </main>
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
    <script>
        // Prepare data for the chart
        const progressRecords = <?php echo json_encode($progressRecords); ?>;

        // Extract subjects, attendance, and grades
        const subjects = progressRecords.map(record => record.Subject);
        const attendance = progressRecords.map(record => record.attendanceP);
        const grades = progressRecords.map(record => record.Grade);

        // Create the chart
        const ctx = document.getElementById('progressChart').getContext('2d');
        const progressChart = new Chart(ctx, {
            type: 'bar',  // Chart type (bar, line, etc.)
            data: {
                labels: subjects,  // X-axis labels (subjects)
                datasets: [
                    {
                        label: 'Attendance (%)',
                        data: attendance,  // Y-axis data for attendance
                        backgroundColor: 'rgb(159, 137, 169)'
                    },
                    {
                        label: 'Grades',
                        data: grades,  // Y-axis data for grades
                        backgroundColor: 'rgb(237, 196, 226)'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>