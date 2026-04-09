<?php
session_start();
require_once('../sessioncheck.php');
include_once('../config/config.php');

// Check if the 'id' parameter is passed via GET
if (isset($_GET['id'])) {
    $resourceId = $_GET['id'];

    // Fetch the resource details to pre-fill the form
    $sql = "SELECT * FROM tbResource WHERE ID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $resourceId, PDO::PARAM_INT);
    $stmt->execute();
    $resource = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$resource) {
        die("Resource not found!");
    }
} else {
    die("ID not provided!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $resourceName = $_POST['resourceName'];
    $fileToUpload = $_FILES['resourceFile'];

    // If a new file is uploaded
    if ($fileToUpload['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../images/resources/";
        $target_file = $target_dir . basename($fileToUpload["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file size and type
        if ($fileToUpload["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "docx", "pdf"])) {
            echo "Sorry, only JPG, JPEG, DOCX, PNG & PDF files are allowed.";
            $uploadOk = 0;
        }

        // Upload the file if it's valid
        if ($uploadOk == 1) {
            // Delete old file from server if a new file is uploaded
            $oldFilePath = "../images/resources/" . $resource['fileName'];
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);  // Delete old file
            }

            // Move the new file to the target directory
            if (move_uploaded_file($fileToUpload["tmp_name"], $target_file)) {
                // Update the resource in the database
                $sql = "UPDATE tbResource SET resourceName = :resourceName, fileName = :fileName WHERE ID = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':resourceName', $resourceName);
                $stmt->bindParam(':fileName', $fileToUpload["name"]);
                $stmt->bindParam(':id', $resourceId, PDO::PARAM_INT);
                $stmt->execute();

                // Redirect to the resource list page after successful update
                header("Location: Resource.php?SubjectID=" . $resource['subjectID']);
                exit;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // If no new file is uploaded, update only the resource name
        $sql = "UPDATE tbResource SET resourceName = :resourceName WHERE ID = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':resourceName', $resourceName);
        $stmt->bindParam(':id', $resourceId, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect to the resource list page after successful update
        header("Location: Resource.php?SubjectID=" . $resource['subjectID']);
        exit;
    }
}
?>

<html lang="en-IN">
<head>
    <title>Edit Resource | ApprizeTutorial</title>
    <link type="text/css" rel="stylesheet" href="../public/css/admin.css"/>
</head>
<body>
    <div class="content">
        <h1>Edit Resource</h1>
        <form class="form-group" method="POST" enctype="multipart/form-data">
            <label for="resourceName">Resource Name:</label>
            <input type="text" name="resourceName" value="<?php echo htmlspecialchars($resource['resourceName']); ?>" required>

            <!-- Display the current file if available -->
            <label for="currentFile">Current Resource File:</label>
            <p>
                <?php
                if ($resource['fileName']) {
                    // Display file link based on the file type (Image, PDF, DOCX, etc.)
                    $filePath = "../images/resources/" . $resource['fileName'];
                    $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

                    if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
                        echo "<img src=\"$filePath\" alt=\"Resource Image\" style=\"width: 100px; height: 100px;\">";
                    } else {
                        echo "<a href=\"$filePath\" target=\"_blank\"> " . $resource['fileName'] . "</a>";
                    }
                } else {
                    echo "No file uploaded.";
                }
                ?>
            </p>
            <label for="resourceFile">Upload New Resource File</label>
            <input type="file" name="resourceFile">

            <input type="submit" value="Update Resource">
        </form>
    </div>
</body>
</html>
