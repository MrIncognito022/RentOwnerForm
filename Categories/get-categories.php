<?php
include '../db_connection.php';

// Query to fetch lead data
$sql = "SELECT * FROM Category";
$result = $conn->query($sql);

// Check if there are results
if ($result === false) {
    // Query error
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Failed to fetch categories from the database']);
    exit;
}

if ($result->num_rows > 0) {
    // Fetch the results as an associative array
    $categories = [];
    while($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }

    // Return the data as JSON with HTTP status 200 (OK)
    echo json_encode($categories);
} else {
    // Return an empty array if no categories were found
    echo json_encode([]);
}

$conn->close();
?>
