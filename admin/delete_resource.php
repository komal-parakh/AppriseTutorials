<?php
session_start();
require_once('../sessioncheck.php');
include_once('../config/config.php');

if (isset($_GET['id'])) {
    $ID = $_GET['id'];

    $sql = "SELECT * FROM tbResource WHERE ID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();


    $SubjectID = $result['subjectID'];
    $resource = $result['fileName'];

    try {
        
        if (!$resource) {
            die("Resource not found!");
        }
        $filePath = "../images/resources/" . $result['fileName'];

        if (file_exists($filePath)) {
            unlink($filePath); 
        }

        // Now delete the event record from the database
        $sql = "DELETE FROM tbResource WHERE ID = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $ID, PDO::PARAM_INT);

        $params = http_build_query([
            'message' => 'Resource deleted successfully!',
            'SubjectID' => $SubjectID
        ]);


        if ($stmt->execute()) {
            header("Location: resource.php?$params");
            exit;
        } else {
            echo "Failed to delete resource!";
        }

    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    die("ID not provided!");
}
?>


