<?php
// Get the incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);
$categoryName = $data['name'] ?? '';

if (!$categoryName) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Category name is required']);
    exit;
}

// Database connection
include '../db_connection.php';

// Insert the new category into the database
$sql = "INSERT INTO category (name) VALUES (?)"; 
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $categoryName);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500); 
    echo json_encode(['error' => 'Failed to insert category']);
}

// Close connection
$stmt->close(); 
$conn->close(); 
?>
