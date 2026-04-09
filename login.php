<?php
session_start();
include_once('config/config.php');

if (isset($_POST["login"])) {
    try {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Set error mode for the PDO connection
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the SQL query
        $sql = "SELECT * FROM tbUsers WHERE email = :email AND password = :password";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        // Fetch user data
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if a user is found
        if ($results) {
            $_SESSION["userID"] = $results['id'];
            $_SESSION["email"] = $results['email'];
            $_SESSION["status"] = $results['status'];
            $_SESSION['loggedin'] = true;

            // Redirect based on user status
            if ($results['status'] === 'admin' || $results['status'] === 'teacher') {
                header("Location: " . BASE_URL . "admin/dashboard.php");
            } elseif ($results['status'] === 'student') {
                header("Location: " . BASE_URL . "pages/dashboard.php");
            } else {
                echo "Invalid user role.";
            }
        } else {
            echo "Invalid email or password.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close connection
    $conn = null;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Login | ApprizeTutorial </title>
        <link type="text/css" rel="stylesheet" href="public/css/style.css"/>
    </head>

    <body>
    <div id="wrapwrap" class="">
        <header id="top" data-anchor="true" data-name="Header" data-extra-items-toggle-aria-label="Extra items button" class="   o_header_standard" style=" ">
            <!-- Header section with navigation elements -->
            <nav data-name="Navbar" aria-label="Main" class="navbar navbar-expand-lg navbar-light o_colored_level o_cc d-none d-lg-block shadow-sm ">
    <div id="o_main_nav" class="o_main_nav container">
                
    <a data-name="Navbar Logo" class="navbar-brand logo me-4">
        <span role="img" aria-label="Logo of ApprizeTutorial" title="ApprizeTutorial"><img src="images/logo.png" class="img img-fluid" width="95" height="40" alt="ApprizeTutorial" loading="lazy"/></span>
    </a>
         
        <ul class="navbar-nav align-items-center gap-2 flex-shrink-0 justify-content-end ps-3">
        <!-- Navigation items for user actions -->            
        <li data-name="Language Selector" class="o_header_language_selector "></li>  
            <li class=" o_no_autohide_item">
                <a href="login.php" class="btn btn-outline-secondary">Sign in</a>
            </li>
        </ul>
    </div>
    </nav>
        </header>
                <main>     
            <div class="oe_website_login_container">
           
            <form class="oe_login_form" method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <input type="hidden" name="csrf_token" value="5204"/>
                <!-- Hidden CSRF token for security -->

                <div class="mb-3 field-login">
                    <label for="login" class="form-label">Email</label>
                    <input type="text" placeholder="Email" name="email" id="login" required="required" 
                    autofocus="autofocus" autocapitalize="off" class="form-control "/>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" placeholder="Password" name="password" id="password" required="required"
                    autocomplete="current-password" maxlength="4096" class="form-control "/>
                </div>

                <div class="clearfix oe_login_buttons text-center gap-1 d-grid mb-1 pt-3">
                    <input type="submit" value="Login" name="login" class="btn btn-primary" />
                    <div class="o_login_auth"></div>
                </div>

                <input type="hidden" name="redirect"/>
            </form>

        </div>
        
        <div id="o_shared_blocks" class="oe_unremovable"></div>
                </main>
                <footer id="bottom" data-anchor="true" data-name="Footer" class="o_footer o_colored_level o_cc ">
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
                            <ul class="ps-3 mb-0">
                            </ul>
                        </div>
                        <div class="col-lg-6 pb24">
                            <ul class="list-unstyled mb-0">
                                <li><img src="images/icon.png" alt="Phone Icon" width="20" height="20" class="me-2"></span><a href="tel:+91 99231 36446">+91 99231 36446</a></span></li>
                                <li><img src="images/icon2.png" alt="Email Icon" width="20" height="20" class="me-2"><span><a href="mailto:apprizetutorials@gmail.com">apprizetutorials@gmail.coml</a></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </body>
</html>