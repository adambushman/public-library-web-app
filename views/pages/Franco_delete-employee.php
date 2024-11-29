<?php
require_once '../../config/dbauth.php';

$conn = connect();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['AccountID'])) {
    $AccountID = $_GET['AccountID'];

    // Prepare and execute the DELETE statement
    $stmt = $conn->prepare("DELETE FROM LIB_ACCOUNT WHERE AccountID = ?");
    $stmt->bind_param("i", $AccountID);

    if ($stmt->execute()) {
        // Deletion successful
        header("Location: ../../views/pages/Franco_view-employees.php?message=Employee deleted successfully");
        exit();
    } else {
        // Deletion failed
        header("Location: ../../views/pages/Franco_view-employees.php?error=Employee deletion failed");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>