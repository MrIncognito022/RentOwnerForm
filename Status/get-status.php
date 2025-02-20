<?php
// Enable error reporting (for debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json'); // Ensure correct JSON response

include '../db_connection.php';

// Check if the database connection is successful
if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$sql = "SELECT * FROM status";  
$result = $conn->query($sql);

// Check if query execution was successful
if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
    exit;
}

// Fetch results as an array (associative)
$status = $result->fetch_all(MYSQLI_ASSOC);

// Return the data as JSON
echo json_encode($status);

$conn->close();
?>
