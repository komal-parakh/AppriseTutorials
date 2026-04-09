<?php
session_start();
require_once('../sessioncheck.php');
include_once('../config/config.php');

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    // Fetch the event details to get the image name
    $sql = "SELECT imagename FROM tbEvent WHERE eventID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);

    try {
        $stmt->execute();
        $event = $stmt->fetch();

        if (!$event) {
            die("Event not found!");
        }

        $imagePath = "../images/uploads/" . $event['imagename'];

        // Check if the image exists and delete it
        if (file_exists($imagePath)) {
            unlink($imagePath);  // Deletes the image file from the server
        }

        // Now delete the event record from the database
        $sql = "DELETE FROM tbEvent WHERE eventID = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: event.php");  // Redirect back to the event list page
            exit;
        } else {
            echo "Failed to delete event!";
        }

    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    die("ID not provided!");
}
?>


