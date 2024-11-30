<?php

require_once '../../config/dbauth.php';

$conn = new mysqli($hn, $un, $pw, $db);
	if ($conn->connect_error){
        die("Connection failed:".$conn->connect_error);
    }

if ($_SERVER['REQUEST_METHOD'] = 'POST'){
	$FirstName = $_POST['FirstName'];
	$LastName = $_POST['LastName'];
	$Phone = $_POST['Phone'];
	$Email = $_POST['Email'];
	$Street = $_POST['Street'];
	$City = $_POST['City'];
	$State = $_POST['State'];
	$Zip = $_POST['Zip'];
	$StartDate = $_POST['StartDate'];
	$AccountTypeID = $_POST['AccountTypeID'];
	
	
	$stmt = $conn->prepare("UPDATE LIB_ACCOUNT SET FirstName = ?, LastName = ?, Phone = ?, Email = ?, Street = ?, City = ?, State = ?, Zip = ?, StartDate = ?, AccountTypeID = ? WHERE AccountID = ?");
    $stmt->bind_param("ssisssssii", $firstName, $lastName, $Phone, $Email, $Street, $City, $State, $Zip, $AccountTypeID, $AccountID);

	    if ($stmt->execute()) {
        header("Location: ../../views/pages/view-employees.php?message=Employee updated successfully");
        exit();
    } else {
        header("Location: ../../views/pages/employee-details.php?error=Error updating employee");
        exit();
    }

    $stmt->close();
    $conn->close();
}


?>
