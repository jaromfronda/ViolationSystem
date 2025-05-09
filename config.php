<?php
// Database configuration
$host = "localhost";  // Change if using a remote DB
$username = "kiko";   // Your database username
$password = "kiko1507mf";       // Your database password
$database = "violators"; // Change to your actual DB name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character encoding to avoid issues
$conn->set_charset("utf8mb4");

// Optional: Start a session
session_start();
define('DEFAULT_IMG_ID', 1); // Change this to the actual ID of your logo in the img table

// Optional: Define site URL for easy reference
define("SITE_URL", "http://localhost/your_project"); // Change to your actual site URL

// Debugging mode (Set to false in production)
define("DEBUG_MODE", true);

if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
?>
