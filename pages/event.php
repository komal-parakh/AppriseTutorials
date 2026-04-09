<?php
session_start();
require_once('../sessioncheck.php');
include_once('../config/config.php');

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM tbEvent";
if (!empty($searchQuery)) {
    $sql .= " WHERE name LIKE :search OR description LIKE :search"; // Search in 'name' and 'description'
}

$stmt = $conn->prepare($sql);

// Bind the search query if it's not empty
if (!empty($searchQuery)) {
    $stmt->bindValue(':search', '%' . $searchQuery . '%', PDO::PARAM_STR);
}

$stmt->execute(); // Execute the prepared statement
$results = $stmt->fetchAll(); // Fetch all results
?>


<!DOCTYPE html>
<html lang="en-IN">
<head>
    <title>Events | ApprizeTutorial</title>
    <link type="image/x-icon" rel="shortcut icon"/> 
    <link type="text/css" rel="stylesheet" href="../public/css/style.css"/>
<style>
.slideshow-container {
    position: relative;
    max-width: 100%;
    margin: auto;
    overflow: hidden;
}
.mySlides {
    display: none;
    position: relative;
    text-align: center;
}
.mySlides img {
    width: 100%;
}
.prev, .next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    margin-top: -22px;
    padding: 16px;
    color: white;
    font-weight: bold;
    font-size: 18px;
    transition: 0.6s ease;
    user-select: none;
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
}
.prev {
    left: 0;
}
.next {
    right: 0;
}
.prev:hover, .next:hover {
    background-color: rgba(0, 0, 0, 0.8);
}
.search-container {
    margin: 20px auto;
    text-align: center;
}
.search-container input {
    padding: 10px;
    width: 300px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-right: 5px;
}
.search-container button {
    padding: 10px 15px;
    border: none;
    background-color: grey;
    color: white;
    border-radius: 5px;
    cursor: pointer;
}
.search-container button:hover {
    background-color: black;
}
</style>

</head>
<body>
    <div id="wrapwrap" class="eventspage">
        <header id="top" class="o_header_standard">
            <nav aria-label="Main" class="navbar navbar-expand-lg navbar-light o_colored_level o_cc d-none d-lg-block shadow-sm">
                <div id="o_main_nav" class="o_main_nav container">
                    <a class="navbar-brand logo me-4">
                        <img src="../images/logo.png" class="img img-fluid" width="95" height="40" alt="ApprizeTutorial" loading="lazy"/>
                    </a>
                    <ul role="menu" id="top_menu" class="nav navbar-nav top_menu o_menu_loading me-auto">
                        <li role="presentation" class="nav-item">
                            <a role="menuitem" href="dashboard.php" class="nav-link">
                                <span>Home</span>
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
                    <div class="search-container">
                        <form method="get" action="event.php">
                            <input type="text" name="search" placeholder="Search events..." 
                            value="<?php echo htmlspecialchars($searchQuery); ?>" />
                            <button type="submit">Search</button>
                        </form>
                    </div>
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
      
    <div class="content">
    <?php foreach ($results as $index => $row): ?>
    <div class="card">
        <div class="slideshow-container" id="slideshow-<?php echo $index; ?>">
            <?php
            $images = explode(',', $row['imagename']); // Split the comma-separated image names into an array
            foreach ($images as $imageIndex => $image): ?>
                <div class="mySlides slide-<?php echo $index; ?>">
                    <img src="../images/uploads/<?php echo trim($image); ?>" alt="Event Image" style="width:100%">
                </div>
            <?php endforeach; ?>

            <!-- Show navigation only if there are multiple images -->
            <?php if (count($images) > 1): ?>
                <a class="prev" onclick="plusSlides(-1, <?php echo $index; ?>)">&#10094;</a>
                <a class="next" onclick="plusSlides(1, <?php echo $index; ?>)">&#10095;</a>
            <?php endif; ?>
        </div>

        <div class="card-content">
            <h4><?php echo htmlspecialchars($row['name']); ?></h4>
            <p class="date"><?php echo htmlspecialchars($row['date']); ?></p>
            <p class="description"><?php echo htmlspecialchars($row['description']); ?></p>
        </div>
    </div>
<?php endforeach; ?>



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
    // Object to track the current slide for each slideshow
    const slideIndices = {};

    function showSlides(n, slideshowIndex) {
        const slides = document.querySelectorAll(`.slide-${slideshowIndex}`);
        if (!slideIndices[slideshowIndex]) {
            slideIndices[slideshowIndex] = 1; // Initialize index if it doesn't exist
        }
        if (n > slides.length) slideIndices[slideshowIndex] = 1;
        if (n < 1) slideIndices[slideshowIndex] = slides.length;

        slides.forEach(slide => (slide.style.display = 'none')); // Hide all slides
        slides[slideIndices[slideshowIndex] - 1].style.display = 'block'; // Show active slide
    }

    function plusSlides(n, slideshowIndex) {
        if (!slideIndices[slideshowIndex]) {
            slideIndices[slideshowIndex] = 1; // Initialize index if it doesn't exist
        }
        showSlides((slideIndices[slideshowIndex] += n), slideshowIndex);
    }

    // Initialize all slideshows
    document.addEventListener('DOMContentLoaded', () => {
        <?php foreach ($results as $index => $row): ?>
            showSlides(1, <?php echo $index; ?>);
        <?php endforeach; ?>
    });
</script>


</body>
</html>
