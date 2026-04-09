<?php
$servername = "centerbeam.proxy.rlwy.net";
$username = "root";
$password = "kprGafttKYbDDOYifyqFcUEUtETQxGFo";
$port = "37516";
try {
  $conn = new PDO("mysql:host=$servername;port=$port;dbname=railway", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
define('BASE_URL', '/');
?>
