<?php

//import credentials for db
require_once '../../config/dbauth.php';

//connect to db
$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);


if(isset($_POST['delete'])){
	
    $AccountID = $_POST['AccountID'];

    $query = "DELETE FROM LIB_ACCOUNT WHERE AccountID = '$AccountID' ";

	//Run the query
	$result = $conn->query($query); 
	if(!$result) die($conn->error);


	header("Location: ../../views/pages/view-employees.php");
}


?>
