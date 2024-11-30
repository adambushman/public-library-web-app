<?php

//import credentials for db
require_once '../../config/dbauth.php';

//connect to db
$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);

//Get data from POST object
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

$query = "INSERT INTO LIB_ACCOUNT (FirstName, LastName, Phone, Email, Street, City, State, Zip, StartDate, AccountTypeID) VALUES ('$FirstName', '$LastName', '$Phone', '$Email', '$Street', '$City', '$State', '$Zip', '$StartDate', '$AccountTypeID')";

	//echo $query.'<br>';
	$result = $conn->query($query); 
	if(!$result) die($conn->error);
	
	header("Location: ../../views/pages/view-employees.php");//this will return you to the view all page
	
$stmt->close();
$conn->close();

