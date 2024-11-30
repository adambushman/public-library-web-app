<?php

require_once '../../config/dbauth.php';
$conn = connect();

if (isset($_POST['username']) && isset($_POST['password'])) {

	//Get values from login screen
	$tmp_username = mysql_entities_fix_string($conn, $_POST['username']);
	$tmp_password = mysql_entities_fix_string($conn, $_POST['password']);
	
	//get password from DB w/ SQL
	$queryFramework = <<<_END
		SELECT AccountID, Password FROM LIB_ACCOUNT WHERE Email = ?
	_END;
	$queryStmt = $conn->prepare($queryFramework);
	$queryStmt->bind_param('s', $tmp_username);

	$queryStmt->execute();	
	$result = $queryStmt->get_result();
	if(!$result) die("Query failed: ". $conn->error);
	
	$dbValues = array(
		"accountId" => null, 
		"password" => null	
	);

	$rows = $result->num_rows;
	for($j = 0; $j < $rows; $j++) {
		$result->data_seek($j); 
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$dbValues['accountId'] = $row['AccountID'];
		$dbValues['password'] = $row['Password'];
	}

	$queryStmt->close();
	
	//Compare passwords
	if(password_verify($tmp_password, $passwordFromDB)) {
        // Start session and redirect to home.php
        session_start();
        $_SESSION['accountId'] = $dbValues['accountId'];
        
        // Redirect to home.php
        header("Location: ../../views/pages/home.php");
		exit();
	}
	else {
		header("Location: ../../views/pages/login.php");
		exit();
	}	
}

$conn->close();

//sanitization functions
function mysql_entities_fix_string($conn, $string){
	return htmlentities(mysql_fix_string($conn, $string));	
}

function mysql_fix_string($conn, $string){
	$string = stripslashes($string);
	return $conn->real_escape_string($string);
}