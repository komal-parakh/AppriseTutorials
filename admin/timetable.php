<?php
session_start();
require_once('../sessioncheck.php');
include_once('../config/config.php');

// Define variables
$editRow = null;
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_timetable'])) {
    if (isset($_POST['subjects']) && is_array($_POST['subjects'])) {
        $subjects = $_POST['subjects']; // Array of subjects with IDs as keys

        foreach ($subjects as $id => $subject) {
            if (!empty($subject) && is_numeric($id)) {
                // Update each subject based on its ID
                $sql = "UPDATE tbtimetable SET subject = :subject WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->execute([':subject' => $subject, ':id' => $id]);
            }
        }
        // Set success message for JavaScript
        $message = "success";
    } else {
        // Set error message for JavaScript
        $message = "error";
    }
}



// Fetch all timetable data for the table
$sql = "SELECT * FROM tbtimetable ORDER BY FIELD(day, 'mon', 'tue', 'wed', 'thu', 'fri')";
$result = $conn->query($sql);


// Handle edit logic when "Edit" is clicked
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $id = $_GET['edit'];

    // Fetch the specific row to edit
    $sql = "SELECT * FROM tbtimetable WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    $editRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$editRow) {
        $message = "<p style='color:red;'>Record not found.</p>";
    }
}

// Fetch all timetable data for the table
$sql = "SELECT * FROM tbtimetable ORDER BY FIELD(day, 'mon', 'tue', 'wed', 'thu', 'fri')";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time table | ApprizeTutorial</title>
    <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../public/css/admin.css"/>
</head>
<body>
    <div id="wrapwrap" class="classpage">
    <header id="top" data-anchor="true" data-name="Header" data-extra-items-toggle-aria-label="Extra items button" class="o_header_standard">
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
            <a role="menuitem" href="class.php" class="nav-link ">
                <span>Classes</span>
            </a>
        </li> 
        <li role="presentation" class="nav-item">
            <a role="menuitem" href="timetable.php" class="nav-link active">
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

        <main>
            <h1>Timetable</h1>

            <table id="timetable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Day/Period</th>
                        <th>I<br>9:30-10:20</th>
                        <th>II<br>10:20-11:10</th>
                        <th>III<br>11:10-12:00</th>
                    </tr>
                </thead>
                <form method="POST">
    <tbody>
        <?php
        $currentDay = "";
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // Start a new row if the day changes
            if ($row['day'] != $currentDay) {
                $currentDay = $row['day'];
                echo "<tr><td>" . htmlspecialchars($currentDay) . "</td>"; // Static day column
            }

            // Add dropdowns for subjects with associated ID
            echo "<td>
                    <select name='subjects[{$row['id']}]'>
                        <option value='Math' " . ($row['subject'] === 'Math' ? 'selected' : '') . ">Math</option>
                        <option value='Economics' " . ($row['subject'] === 'Economics' ? 'selected' : '') . ">Economics</option>
                        <option value='English' " . ($row['subject'] === 'English' ? 'selected' : '') . ">English</option>
                        <option value='Accounts' " . ($row['subject'] === 'English' ? 'selected' : '') . ">Accounts</option>
                    </select>
                </td>";

            // Check if the day row should end
            if ($row['day'] != $currentDay) {
                echo "</tr>";
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">
                <button type="submit" name="update_timetable" class="btn btn-primary" >Save All</button>
                <input type="hidden" id="statusMessage" value="<?php echo htmlspecialchars($message ?? '', ENT_QUOTES); ?>">
            </td>
        </tr>
    </tfoot>
</form>



            </table>
        </main>
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
                        <div class="col-lg-3 pb24"></div>
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
    document.addEventListener("DOMContentLoaded", function () {
        // Check if a message is passed from PHP
        const statusMessage = document.getElementById("statusMessage").value;
        if (statusMessage === "success") {
            alert("Timetable is saved successfully!");
        } else if (statusMessage === "error") {
            alert("There was an error updating the timetable. Please try again.");
        }
    });
</script>

</body>
</html>
