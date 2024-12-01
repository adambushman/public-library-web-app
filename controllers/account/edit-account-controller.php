<?php

require_once '../../config/dbauth.php';
require_once '../../helpers.php';

$conn = connect();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$accountId = $_GET['accountId'];

	$FirstName = $_POST['firstName'];
	$LastName = $_POST['lastName'];
	$Phone = $_POST['phone'];
	$Email = $_POST['email'];
	$Street = $_POST['street'];
	$City = $_POST['city'];
	$State = $_POST['state'];
	$Zip = $_POST['zip'];
	$StartDate = date("Y-m-d");
	$Username = $_POST['username'];
	$AccountTypeId = $_POST['accountType'] ?? 3; // Default to "member"

	
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
			Username = ?,
			AccountTypeID = ?
		WHERE AccountID = ?
	_END;

	$queryStmt = $conn->prepare($queryFramework);
	$queryStmt->bind_param(
		'ssssssssssii', $FirstName, $LastName, $Phone, $Email, $Street, $City, $State, $Zip, $StartDate, $Username, $AccountTypeId, $accountId
	);

	$queryStmt->execute();
	$result = $queryStmt->get_result();
	if(!$result) echo $conn->error;

	$queryStmt->close();

	session_start();
	$roles = getAccountRoles($conn, $_SESSION['accountId']);

	if(count(array_intersect($roles, array('Admin','Staff')))) {
		header("Location: ../../views/pages/application-settings.php");
	} else {
		header("Location: ../../views/pages/view-account.php");
	}

	$conn->close();

	exit();
}