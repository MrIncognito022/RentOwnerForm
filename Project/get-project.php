<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the content type to JSON
header('Content-Type: application/json');

// Include your database connection
include '../db_connection.php';

// Check if the connection is successful
if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// SQL query to fetch all columns from the Project table
$sql = "SELECT * FROM project";
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
    exit;
}

// Fetch all rows as an associative array
$projects = $result->fetch_all(MYSQLI_ASSOC);

// Return the data as JSON
echo json_encode($projects);

// Close the database connection
$conn->close();
?>
