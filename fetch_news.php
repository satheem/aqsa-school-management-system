<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$servername = "localhost"; // Replace with your server name
$username = "root";        // Replace with your database username
$password = "";            // Replace with your database password
$dbname = "studentmsdb"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Fetch news from the database
$sql = "SELECT id, image, title, content, dateposted FROM tblnews ORDER BY dateposted DESC";
$result = $conn->query($sql);

// Initialize an empty array to hold the news articles
$news = [];

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $news[] = $row;
    }
} else {
    // If no news found, we still return an empty array
    $news = [];
}

// Close the database connection
$conn->close();

// Return the news articles as JSON
header('Content-Type: application/json');
echo json_encode($news);
?>
