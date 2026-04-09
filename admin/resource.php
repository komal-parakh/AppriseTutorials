<?php
session_start();
require_once('../sessioncheck.php');
include_once('../config/config.php');

$SubjectID = $_GET['SubjectID'] ?? null;
$message = isset($_GET['message']) ? $_GET['message'] : "";
if ($SubjectID) {
    $sql = "SELECT Name FROM tbSubject WHERE SubjectID = :SubjectID";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':SubjectID', $SubjectID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
if (isset($_POST["Submit"])) {
    try {
        $SubjectID = $_POST['SubjectID'];
        $resourceName = $_POST['resourceName'];
        $target_dir = "../images/resources/";

        // Loop through all uploaded files
        foreach ($_FILES['resourceFile']['name'] as $key => $filename) {
            // Get the full file path
            $target_file = $target_dir . basename($_FILES["resourceFile"]["name"][$key]);

            // Check for upload errors
            if ($_FILES['resourceFile']['error'][$key] === UPLOAD_ERR_OK) {
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                if ($_FILES["resourceFile"]["size"][$key] > 500000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Check file type (allow only certain extensions)
                if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'docx', 'pdf'])) {
                    echo "Sorry, only JPG, JPEG, DOCX, PNG & PDF files are allowed.";
                    $uploadOk = 0;
                }

                // Proceed if no errors
                if ($uploadOk == 1) {
                    // Insert the resource into the database
                    $sql = "INSERT INTO tbResource (subjectID, resourceName, fileName) 
                            VALUES (:subjectID, :resourceName, :fileName)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':subjectID', $SubjectID);
                    $stmt->bindParam(':resourceName', $resourceName);
                    $stmt->bindParam(':fileName', $_FILES["resourceFile"]["name"][$key]);
                    $stmt->execute();

                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($_FILES["resourceFile"]["tmp_name"][$key], $target_file)) {
                        $message = "success"; // Success message
                    } else {
                        $message = "error_database"; 
                    }
                }
            } else {
                $message = "error_database"; 
            }
        }

        // Redirect after upload
        header("Location: ".BASE_URL."admin/Resource.php?SubjectID=".$SubjectID);
        exit();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


$sql = "SELECT * FROM tbResource"; // SQL query to fetch all data
$stmt = $conn->prepare($sql); // Prepare the SQL statement
$stmt->execute(); // Execute the prepared statement
$results = $stmt->fetchAll(); // Fetch all results
?>

<html lang="en-IN">
<head>
    <title>Class Resources | ApprizeTutorial </title>
    <link type="text/css" rel="stylesheet" href="../public/css/admin.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"> <!-- DataTables CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> <!-- DataTables JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div id="wrapwrap" class="classpage">
        <header id="top" class="o_header_standard">
            <nav data-name="Navbar" aria-label="Main" class="navbar navbar-expand-lg navbar-light o_colored_level o_cc d-none d-lg-b;ock shadow-sm ">
                <div id="o_main_nav" class="o_main_nav container">
                <a data-name="Navbar Logo" class="navbar-brand logo me-4">
                <span role="img" aria-label="Logo of ApprizeTutorial" title="ApprizeTutorial"><img src="../images/logo.png" class="img img-fluid" width="95" height="40" alt="ApprizeTutorial" loading="lazy"/></span>
                </a>
                
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
                    <a href="../logout.php" class="btn btn-outline-secondary">Sign out</a> <!-- Sign in button -->
                   <?php }else {?>
                    <a href="../login.php" class="btn btn-outline-secondary">Sign in</a> <!-- Sign in button -->
                    <?php }?>
        </li>   
        </ul>
            </div>       
        </nav> 
        </header>

        <div class="content">  
        
        <h1 class="page-title">Upload Resources</h1>
        <form id="uploadResourceForm" class="resource-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
        <label for="className">Class: <?php echo htmlspecialchars($result['Name'] ?? ''); ?></label>
            
            <label for="resourceName">Resource Name:</label>
            <input type="text" id="resourceName" name="resourceName" required>
            <label for="resourceFile">Resource Files:</label> 
            <input type="file" id="resourceFile" name="resourceFile[]" multiple>

            
            <input type="hidden" name="SubjectID" value="<?php  echo $SubjectID; ?>" />
            <input type="submit" value="Submit" name="Submit" class="btn btn-primary" />
            <input type="hidden" id="statusMessage" value="<?php echo htmlspecialchars($message ?? '', ENT_QUOTES); ?>">
            </div> 
        </form>

        <div style="margin-top: 5%;">

        <table id="resource" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Resource</th>
                <th>Update</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($results as $row): 
            $filePath = "../images/resources/" . $row['fileName'];
            $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        ?>
            <tr>
                <td><?php echo htmlspecialchars($row['resourceName']); ?></td>
                <td><?php 
                        $fileType = pathinfo($row['fileName'], PATHINFO_EXTENSION); // Get the file extension
                        if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                            <a href="../images/resources/<?php echo htmlspecialchars($row['fileName']); ?>" 
                            target="_blank">View image</a>
                        <?php elseif ($fileType === 'pdf'): ?>
                            <a href="../images/resources/<?php echo htmlspecialchars($row['fileName']); ?>" 
                            target="_blank">View PDF</a>
                        <?php endif; ?>
                        </td>
                <td><a href="edit_resource.php?id=<?php echo $row['ID']; ?>"><button>Edit</button></a></td>
                <td><a href="delete_resource.php?id=<?php echo $row['ID']; ?>"><button>Delete</button></a></td>
            </tr>
        <?php endforeach; ?>
            </tbody>
        </table>

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
        <script>
            $(document).ready( function () {
                $('#resource').DataTable();
            } );

            document.addEventListener("DOMContentLoaded", function () {
        // Check if a message is passed from PHP
        const statusMessage = document.getElementById("statusMessage").value;
        if (statusMessage === "success") {
            alert("Resource is saved successfully!");
        } else if (statusMessage === "error") {
            alert("There was an error creating the resource. Please try again.");
        }
    });
        </script>
</body>
</html>   