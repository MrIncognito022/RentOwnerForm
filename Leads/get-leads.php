<?php
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

// Query to fetch lead data
$sql = "SELECT * FROM lead";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch the results as an associative array
    $leads = [];
    while($row = $result->fetch_assoc()) {
        $leads[] = $row;
    }
    
    // Return the data as JSON
    echo json_encode($leads);
} else {
    echo json_encode([]);
}

$conn->close();
?>
