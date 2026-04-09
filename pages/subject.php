<?php
session_start();
require_once('../sessioncheck.php');
include_once('../config/config.php');

$SubjectID = $_GET['SubjectID'] ?? null;
$sql = "SELECT * FROM tbResource WHERE subjectID=".$SubjectID ; // SQL query to fetch all data
$stmt = $conn->prepare($sql); // Prepare the SQL statement
$stmt->execute(); // Execute the prepared statement
$results = $stmt->fetchAll(); // Fetch all results
?>

<!DOCTYPE html>
<html lang="en-IN" data-website-id="1" data-main-object="website.page(5,)">
<head>
    <title>Class Resources | ApprizeTutorial</title>
    <link type="image/x-icon" rel="shortcut icon"/> 
    <link type="text/css" rel="stylesheet" href="../public/css/style.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
         .resource-list {
            list-style-type: style type;;
            padding: 0;
            margin: 0;
        }

        .resource-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #ccc;
        }

        .resource-thumbnail {
            height: 40px;
            width: 40px;
            margin-right: 15px;
            object-fit: cover;
        }

        .resource-details {
            flex: 1;
            display: flex;
            flex-direction: row;
            gap: 150px;
        }

        .resource-name {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }

        .upload-date {
            font-size: 14px;
            color: #555;
            margin: 0;
        }

        .view-link {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .view-link:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div id="wrapwrap" class="classpage">
        <header id="top" data-anchor="true" data-name="Header" data-extra-items-toggle-aria-label="Extra items button" class="o_header_standard">
            <nav data-name="Navbar" aria-label="Main" class="navbar navbar-expand-lg navbar-light o_colored_level o_cc d-none d-lg-block shadow-sm">
                <div id="o_main_nav" class="o_main_nav container">
                    <a data-name="Navbar Logo" class="navbar-brand logo me-4">
                        <span role="img" aria-label="Logo of ApprizeTutorial" title="ApprizeTutorial">
                            <img src="../images/logo.png" class="img img-fluid" width="95" height="40" alt="ApprizeTutorial" loading="lazy"/>
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
            

        <main class="container mt-5">
            <h1>Class Resources</h1>
            <section class="resources">
                <ul class="resource-list">
                    <?php foreach ($results as $row): ?>
                        <li class="resource-item">
                            <?php 
                                $fileType = pathinfo($row['fileName'], PATHINFO_EXTENSION);
                                $icon = '../icons/default-icon.png';
                                switch ($fileType) {
                                    case 'pdf': $icon = '../icons/pdf-icon.png'; break;
                                    case 'doc': $icon = '../icons/word-icon.png'; break;
                                    case 'jpg':
                                    case 'png': $icon = "../images/resources/" . htmlspecialchars($row['fileName']); break;
                                }
                            ?>
                            <img src="<?php echo $icon; ?>" class="resource-thumbnail" alt="File Thumbnail">
                            <div class="resource-details">
                                <h4 class="resource-name"><?php echo htmlspecialchars($row['resourceName']); ?></h4>
                                <p class="upload-date">Uploaded on: <?php echo htmlspecialchars($row['createdAt']); ?></p>
                                <a href="../images/resources/<?php echo htmlspecialchars($row['fileName']); ?>" class="view-link" target="_blank">
                                    <?php echo $fileType === 'pdf' ? 'View PDF' : 'View Image'; ?>
                                </a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        </main>
        <div class="modal" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img id="modalImage" src="" alt="Image" class="img-fluid">
                    </div>
                </div>
            </div>
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
    // Function to open the modal with the clicked image
    function openModal(imageSrc) {
        $('#modalImage').attr('src', imageSrc); // Set the image source in the modal
        $('#imageModal').modal('show'); // Show the modal
    }

    // Add click event to all images
    $('img').on('click', function() {
        var imageSrc = $(this).attr('src'); // Get the source of the clicked image
        openModal(imageSrc); // Open the modal with the clicked image
    });
</script>
</body>
</html>
