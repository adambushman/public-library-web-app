<?php

require_once '../../config/dbauth.php';

$conn = connect();
if($conn->connect_error) die($conn->connect_error);

//Query to DB
$query = "DELETE FROM LIB_ACCOUNT WHERE AccountID = $AccountID";
$result = $conn->query($query);
if(!$result) "Could not delete Employee";

$conn->close();
header("Location: ../../views/pages/view-employees.php");
	
	
}