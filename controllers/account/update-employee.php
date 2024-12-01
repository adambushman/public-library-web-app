<?php

require_once '../../config/dbauth.php';

$conn = connect();

$AccountID = $_GET['accountId'];

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
	
	$queryFramework = <<<_END
	UPDATE LIB_ACCOUNT 
	SET 
		FirstName = ?, 
		LastName = ?, 
		Phone = ?, 
		Email = ?,
		Street = ?, 
		City = ?, 
		State = ?, 
		Zip = ?, 
		StartDate = ?, 
		AccountTypeID = ?
	WHERE AccountID = ?
	_END;

	$queryStmt = $conn->prepare($queryFramework);
    $queryStmt->bind_param("sssssssssii", $FirstName, $LastName, $Phone, $Email, $Street, $City, $State, $Zip, $StartDate, $AccountTypeID, $AccountID);

	if ($queryStmt->execute()) {
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
