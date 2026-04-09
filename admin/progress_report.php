<?php
session_start();
require_once('../config/config.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $name = $_POST['Name'];
    $subject = $_POST['Subject'];
    $grade = $_POST['Grade'];
    $attendance = $_POST['attendanceP'];
    $remarks = $_POST['Remarks'];

    // Validate attendance percentage
    if ($attendance < 0 || $attendance > 100) {
        die("Attendance percentage must be between 0 and 100.");
    }

    // Identify the student ID (either from session or from form input)
    if ($_SESSION['status'] == 'student') {
        // If logged-in user is a student, use their ID
        $studentID = $_SESSION['userID'];
    } else {
        // If it's a teacher, use the selected studentID from the form
        $studentID = $_POST['studentID'];
    }

    // Insert progress report into the database, including the studentID
    $sql = "INSERT INTO tbProgress (studentID, Name, Subject, Grade, attendanceP, Remarks) 
            VALUES (:studentID, :name, :subject, :grade, :attendance, :remarks)";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':subject', $subject);
    $stmt->bindParam(':grade', $grade);
    $stmt->bindParam(':attendance', $attendance);
    $stmt->bindParam(':remarks', $remarks);
    $stmt->bindParam(':studentID', $studentID);

    // Execute the query
    if ($stmt->execute()) {
        header("Location: progress_report.php?success=1"); // Redirect with success message
        exit(); // Make sure to exit after redirect to prevent further code execution
    } else {
        echo "Error: " . $stmt->errorInfo(); // Display error message if query fails
    }
}

// Fetch all progress reports
$sql = "SELECT * FROM tbProgress"; // SQL query to fetch all data
$stmt = $conn->prepare($sql); // Prepare the SQL statement
$stmt->execute(); // Execute the prepared statement
$results = $stmt->fetchAll(); // Fetch all results

// Fetch all students (for the dropdown)
$sql1 = "SELECT email FROM tbUsers WHERE status = 'student'";
$stmt = $conn->prepare($sql1); // Prepare the query
$stmt->execute(); // Execute the query
$students = $stmt->fetchAll(); // Fetch all results
?>

<!DOCTYPE html>
<html lang="en-IN">
<head>
    <title>Progress Report | ApprizeTutorial</title>
    <link rel="shortcut icon" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="../public/css/admin.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"> <!-- DataTables CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> <!-- DataTables JS -->
    <script type="text/javascript" defer="defer" src="../public/js/index.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
.dropbtn {
  background-color: white;
  color: black;
  cursor: pointer;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}
.dropdown-content a:hover {background-color: #ddd;}

/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
.show {display:block;}
    </style>
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

        <div class="admin-container">
        <h2>Progress Reports</h2>

        <form class="event-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">

    <label for="Name">Student Name:</label>
    <div class="dropdown">
    <input type="text" id="Name" name="Name" onclick="myFunction()" class="dropbtn" required readonly>
    <div id="myDropdown" class="dropdown-content">
        <?php foreach ($students as $student): ?>
            <a href="javascript:void(0)" onclick="selectStudent('<?php echo htmlspecialchars($student['email']); ?>')">
                <?php echo htmlspecialchars($student['email']); ?>
            </a>
        <?php endforeach; ?>
    </div>
    </div>
    

    <label for="Subject">Subject:</label>
    <input type="text" id="Subject" name="Subject" required>

    <label for="Grade">Grade:</label>
    <input type="text" id="Grade" name="Grade" required>

    <label for="Attendance">Attendance (%):</label>
    <input type="number" id="Attendance" name="attendanceP" step="0.01" min="0" max="100" required>

    <label for="Remarks">Remarks:</label>
    <textarea id="Remarks" name="Remarks"></textarea>
    
    <input type="submit" value="Submit" name="Submit" class="btn btn-primary" />
</form>

<table id="progress" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Subject</th>
                <th>Grade</th>
                <th>Attendance</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Name']); ?></td>
                    <td><?php echo htmlspecialchars($row['Subject']); ?></td>
                    <td><?php echo htmlspecialchars($row['Grade']); ?></td>
                    <td><?php echo htmlspecialchars($row['attendanceP']); ?></td>
                    <td><?php echo htmlspecialchars($row['Remarks']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

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
    <script>
        $(document).ready( function () {
            $('#progress').DataTable();
        } );
       
        function selectStudent(studentName) {
        // Set the selected student email into the 'Name' input field
        document.getElementById("Name").value = studentName;
        // Close the dropdown after selection
        document.getElementById("myDropdown").classList.remove("show");
    }

    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown menu if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
    </script>
</body>
    
</html>