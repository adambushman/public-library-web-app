<?php

//import credentials for db
require_once '../../config/dbauth.php';

//connect to db
$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);

//check if Account ID exists
if(isset($_POST['AccountId'])){
	
	//Get data from POST object
	$AccountID = $_POST['AccountID'];  
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $Phone = $_POST['Phone'];
    $Email = $_POST['Email'];
    $Street = $_POST['Street'];
    $City = $_POST['City'];
    $State = $_POST['State'];
    $Zip = $_POST['Zip'];
    $StartDate = $_POST['StartDate'];
    $Password = $_POST['Password'];
    $AccountTypeID = $_POST['AccountTypeID'];

	
	$query = "INSERT INTO LIB_ACCOUNT (FirstName, LastName, Phone, Email, Street, City, State,  Zip,  StartDate,  Password,  AccountTypeID) VALUES
    ('$FirstName', '$LastName', '$Phone', '$Email', '$Street', '$City', '$State', '$Zip', '$StartDate', '$Password', '$AccountTypeID')";
	
	//echo $query.'<br>';
	$result = $conn->query($query); 
	if(!$result) die($conn->error);
	
	//header("Location: ../../views/pages/Franco_view-employees.php");
	
	
}

?>