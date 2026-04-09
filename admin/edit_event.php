<?php
session_start();
require_once('../sessioncheck.php');
include_once('../config/config.php');

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    // Fetch existing event details
    $sql = "SELECT * FROM tbEvent WHERE eventID = :id"; // Use 'eventID' instead of 'id' or 'event_id'
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);

    try {
        $stmt->execute();
        $event = $stmt->fetch();

        if (!$event) {
            die("Event not found!");
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    die("ID not provided!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];
    $eventDescription = $_POST['eventDescription'];

    // Handle multiple file uploads
    $uploadedFiles = [];
    if (isset($_FILES['myfile']) && count($_FILES['myfile']['name']) > 0) {
        $target_dir = "../images/uploads/";
        $fileCount = count($_FILES['myfile']['name']);

        for ($i = 0; $i < $fileCount; $i++) {
            $fileName = basename($_FILES['myfile']['name'][$i]);
            $target_file = $target_dir . $fileName;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Validate file size and type
            if ($_FILES['myfile']['size'][$i] > 5000000) {
                echo "Sorry, file $fileName is too large.";
                $uploadOk = 0;
            }

            if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed for $fileName.";
                $uploadOk = 0;
            }

            // Upload file if valid
            if ($uploadOk === 1) {
                if (move_uploaded_file($_FILES['myfile']['tmp_name'][$i], $target_file)) {
                    $uploadedFiles[] = $fileName;
                } else {
                    echo "Sorry, there was an error uploading $fileName.";
                }
            }
        }
    }

    // If no new images uploaded, keep the current images
    $finalImageNames = !empty($uploadedFiles) ? implode(',', $uploadedFiles) : $event['imagename'];

    // Update the event
    $sql = "UPDATE tbEvent SET name = :name, date = :date, description = :description, imagename = :imagename WHERE eventID = :id";
    $stmt = $conn->prepare($sql);

    // Bind the parameters
    $stmt->bindParam(':name', $eventName);
    $stmt->bindParam(':date', $eventDate);
    $stmt->bindParam(':description', $eventDescription);
    $stmt->bindParam(':imagename', $finalImageNames);
    $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);

    try {
        if ($stmt->execute()) {
            header("Location: event.php");
            exit;
        } else {
            echo "Failed to update event!";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<html>
    <head>
        <title>Edit Event | ApprizeTutorial</title>
        <link type="text/css" rel="stylesheet" href="../public/css/admin.css"/>
    </head>
    <body>
        <div class="admin-container">
            <h2>Edit Events</h2>
            <form class="event-form" method="post" enctype="multipart/form-data">
                <label for="eventName">Event Name:</label>
                <input type="text" id="eventName" name="eventName" value="<?php echo htmlspecialchars($event['name']); ?>" required>

                <label for="eventDate">Event Date:</label>
                <input type="date" id="eventDate" name="eventDate" value="<?php echo htmlspecialchars($event['date']); ?>" required>

                <label for="eventDescription">Event Description:</label>
                <textarea name="eventDescription" rows="4" required><?php echo htmlspecialchars($event['description']); ?></textarea>

                <label for="myfile">Event Images (Optional):</label>
                <input type="file" name="myfile[]" multiple>

                <button type="submit">Update Event</button>
            </form>
        </div>
    </body>
</html>
