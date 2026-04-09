<?php
session_start();
require_once('../sessioncheck.php');
include_once('../config/config.php');

if (isset($_POST["Submit"])) {
    try {
        $eventName = $_POST['eventName'];
        $eventDate = $_POST['eventDate'];
        $eventDescription = $_POST['eventDescription'];

        $target_dir = "../images/uploads/";
        $uploadOk = 1;

        // Initialize an array to hold file names
        $uploadedImages = [];

        // Loop through all uploaded files
        foreach ($_FILES['myfile']['name'] as $key => $fileName) {
            $target_file = $target_dir . basename($fileName);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check file size
            if ($_FILES['myfile']['size'][$key] > 10000000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
                break;
            }

            // Check file type
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
                break;
            }

            if ($uploadOk == 1) {
                // Move the uploaded file
                if (move_uploaded_file($_FILES['myfile']['tmp_name'][$key], $target_file)) {
                    $uploadedImages[] = $fileName;  // Store the file name for database
                } else {
                    echo "Sorry, there was an error uploading your file.";
                    $uploadOk = 0;
                    break;
                }
            }
        }

        if ($uploadOk == 1) {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $imageNames = implode(",", $uploadedImages); // Store all image names as a comma-separated string
            $sql = "INSERT INTO tbEvent (name, date, description, imagename) 
                    VALUES (:name, :date, :description, :imagename)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':name' => $eventName,
                ':date' => $eventDate,
                ':description' => $eventDescription,
                ':imagename' => $imageNames
            ]);

            $message = "success"; // Success message
        }
    } catch (PDOException $e) {
        $message = "error_database"; // Database error
    }
}

$sql = "SELECT * FROM tbEvent"; // SQL query to fetch all data
$stmt = $conn->prepare($sql); // Prepare the SQL statement
$stmt->execute(); // Execute the prepared statement
$results = $stmt->fetchAll(); // Fetch all results

?>
<html lang="en-IN">
<head>
    <title>Admin Events | ApprizeTutorial</title>
    <link type="text/css" rel="stylesheet" href="../public/css/admin.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"> <!-- DataTables CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> <!-- DataTables JS -->
    <script type="text/javascript" defer="defer" src="../public/js/index.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
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
            <a role="menuitem" href="event.php" class="nav-link active">
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
        <ul class="navbar-nav align-items-center gap-2 flex-shrink-0 justify-content-end ps-3"> <!-- Right-side navigation items -->
        <li class=" divider d-none"></li>    <!-- Hidden divider item -->                        
        <li data-name="Language Selector" class="o_header_language_selector "></li>
        <li class=" o_no_autohide_item">
        <?php if (isset($_SESSION["userID"])) { ?>
                    <a href="../logout.php" class="btn btn-outline-secondary">Sign out</a> 
                   <?php }else {?>
                    <a href="../login.php" class="btn btn-outline-secondary">Sign in</a> <!-- Sign in button -->
                    <?php }?>
        </li>   
        </ul>
                </div>       
        </nav> 
    </header>
    <div class="admin-container">
        <h2>Manage Events</h2>

        <form class="event-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
            <label for="eventName">Event Name:</label>
            <input type="text" id="eventName" name="eventName" required>

            <label for="eventDate">Event Date:</label>
            <input type="date" id="eventDate" name="eventDate" required>

            <label for="eventDescription">Event Description:</label>
            <textarea type="varchar" id="eventDescription" name="eventDescription" rows="4" required></textarea>

            <label for="eventImage">Event Images:</label>
            <input type="file" id="myfile" name="myfile[]" multiple>
            <input type="submit" value="Submit" name="Submit" class="btn btn-primary" />
            <input type="hidden" id="statusMessage" value="<?php echo htmlspecialchars($message ?? '', ENT_QUOTES); ?>">
        </form>


    <table id="events" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Description</th>
                <th>Image</th>
                <th>Update</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td>
                        <?php
                        // Split the stored image names and display each image
                        $images = explode(",", $row['imagename']);
                        foreach ($images as $image) {
                            echo '<img src="../images/uploads/' . $image . '" alt="No image" style="width: 70px; height: 70px;"/>';
                        }
                        ?>
                    </td>
                    <td><a href="edit_event.php?id=<?php echo $row['eventID']; ?>"><button>Edit</button></a></td>
                    <td><a href="delete_event.php?id=<?php echo $row['eventID']; ?>"><button>Delete</button></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
    
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
    <script>
        $(document).ready( function () {
            $('#events').DataTable();
        } );

    document.addEventListener("DOMContentLoaded", function () {
        // Check if a message is passed from PHP
        const statusMessage = document.getElementById("statusMessage").value;
        if (statusMessage === "success") {
            alert("Event is saved successfully!");
        } else if (statusMessage === "error") {
            alert("There was an error creating the event. Please try again.");
        }
    });
    </script>
</body>
</html>
