<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Include database connection
include '../db_connection.php';

// Get the POST data from the request body
$data = json_decode(file_get_contents('php://input'), true);

// Check if 'name' field is present in the request data
if (isset($data['name']) && !empty($data['name'])) {
    $priorityName = $data['name'];

    // Prepare the SQL query to insert a new priority
    $sql = "INSERT INTO priority (name) VALUES (?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the parameter to the query
        $stmt->bind_param('s', $priorityName);

        // Execute the query and check for success
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Priority created successfully']);
        } else {
            echo json_encode(['error' => 'Failed to create priority']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Database error: ' . $conn->error]);
    }
} else {
    echo json_encode(['error' => 'Priority name is required']);
}

// Close the database connection
$conn->close();
?>
