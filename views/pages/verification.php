<?php

//Example 12-2

require_once '../../config/dbauth.php';
$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);

if (isset($_POST['Email']) && isset($_POST['Password'])) {
	
	//Get values from login screen
	$tmp_username = mysql_entities_fix_string($conn, $_POST['Email']);
	$tmp_password = mysql_entities_fix_string($conn, $_POST['Password']);
	
	//get password from DB w/ SQL
	$query = "SELECT Password FROM lib_account WHERE Email = '$tmp_username'";
	
	$result = $conn->query($query); 
	if(!$result) die("Query failed: ". $conn->error);
	
	$rows = $result->num_rows;
	$passwordFromDB="";
	for($j=0; $j<$rows; $j++)
	{
		$result->data_seek($j); 
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$passwordFromDB = $row['Password'];
	
	}
	
	//Compare passwords
	if(password_verify($tmp_password,$passwordFromDB))
	{
		echo "successful login<br>";
		
        // Start session and redirect to card-list.html
        session_start();
        $_SESSION['email'] = $tmp_username;
        
        // Redirect to home.php
        header("Location: home.php");
		exit();
	}
	else
	{
		header("Location: login.php");
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



?>