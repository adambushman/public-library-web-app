<?php

//import credentials for db
require_once '../../config/dbauth.php';

//connect to db
$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);


if(isset($_POST)){
	
    $accountId = $_GET['accountId'];

    $query = "DELETE FROM LIB_ACCOUNT WHERE AccountID = '$accountId' ";

	//Run the query
	$result = $conn->query($query); 
	if(!$result) {
		echo $conn->error;
		die();
	}


	header("Location: ../../views/pages/application-settings.php");
}