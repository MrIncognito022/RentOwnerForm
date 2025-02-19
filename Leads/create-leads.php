<?php
// Get the incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);
$leadName = $data['LeadName'] ?? '';

if (!$leadName) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Lead name is required']);
    exit;
}

// Database connection
$servername = "localhost"; // or your database server
$username = "root";        // your MySQL username
$password = "";            // your MySQL password
$dbname = "RentOwnerDB"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert the new lead into the database
$sql = "INSERT INTO lead (LeadName) VALUES (?)"; // Replace 'leads' with your actual table name
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $leadName);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Failed to insert lead']);
}
// Close connection
$conn->close();
?>
