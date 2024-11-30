<?php

require_once '../../config/dbauth.php';

$conn = connect();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
	$Password = $_POST['password'];
	$AccountTypeId = $_POST['accountType'] ?? 3; // Default to "member"
	
	$token = password_hash($Password,PASSWORD_DEFAULT); 


	$queryFramework = <<<_END
		INSERT INTO LIB_ACCOUNT (FirstName, LastName, Phone, Email, Street, City, State, Zip, StartDate, Username, Password, AccountTypeID) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?)
	_END;

	$queryStmt = $conn->prepare($queryFramework);
	$queryStmt->bind_param(
		'sssssssssssi', $FirstName, $LastName, $Phone,  $Email, $Street, $City, $State, $Zip, $StartDate, $Username, $token, $AccountTypeId
	);

	$queryStmt->execute();
	$result = $queryStmt->get_result();
	if(!$result) echo $conn->error;
	$accountId = $conn->insert_id;

	$queryStmt->close();
	$conn->close();

	session_start();
	$_SESSION['email'] = $accountId;

	header("Location: ../../views/pages/home.php");
	exit();
}