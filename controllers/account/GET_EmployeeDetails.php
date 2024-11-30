<?php
require_once '../../config/dbauth.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['AccountID'])) {
    $AccountID = $_GET['AccountID'];

    // Fetch the employee details using the AccountID
    $query = "SELECT * FROM LIB_ACCOUNT WHERE AccountID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $AccountID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display the full employee information here
    } else {
        echo "Employee not found.";
    }

    $stmt->close();
}

$conn->close();