<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Include database connection
include '../db_connection.php';

// Fetch all priorities from the database
$sql = "SELECT id, name FROM priority"; // Adjust table and column names as needed
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    $priorities = [];
    
    // Fetch each priority record
    while ($row = $result->fetch_assoc()) {
        $priorities[] = [
            'id' => $row['id'],
            'name' => $row['name']
        ];
    }

    // Send the priorities as a JSON response
    echo json_encode($priorities);
} else {
    // No priorities found, send an empty array
    echo json_encode([]);
}

// Close the database connection
$conn->close();
?>
