
<?php

require_once '../../config/dbauth.php';

$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);



function add_user($conn, $AccountID, $FirstName, $LastName, $Phone,  $Email, $Street, $City, $State, $Zip,  $StartDate, $token, $AccountTypeID){
	//code to add user here
	$query = "INSERT INTO LIB_ACCOUNT (AccountID, FirstName, LastName, Phone, Email, Street, City, State, Zip, StartDate, Password, AccountTypeID) VALUES ('$AccountID', '$FirstName', '$LastName', '$Phone', '$Email', '$Street', '$City', '$State', '$Zip', '$StartDate', '$token', '$AccountTypeID')";
	$result = $conn->query($query);
	if(!$result) die($conn->error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

	
	$token = password_hash($Password,PASSWORD_DEFAULT); 

	add_user($conn, $AccountID, $FirstName, $LastName, $Phone,  $Email, $Street, $City, $State, $Zip,  $StartDate, $token, $AccountTypeID);
	
		

	
header("Location: home.php");
exit();




}
?>

<html>
	<head>
	
	</head>
	
	<body>
		<form method='post' action='add-user.php'>
			<pre>
				AccountID: <input type='text' name='AccountID'>
				First Name: <input type='text' name='FirstName'>
				Last Name: <input type='text' name='LastName'>
				Phone: <input type='text' name='Phone'>
				Email: <input type='text' name='Email'>
				Street: <input type='text' name='Street'>
				City: <input type='text' name='City'>
				State: <input type='text' name='State'>
				Zip: <input type='text' name='Zip'>
				Start Date: <input type='date_create' name='StartDate'>
				Password: <input type='password' name='Password'>
				Account Type: <select name='AccountTypeID'>
					<option value='1'>Admin</option>
					<option value='2'>Staff</option>
					<option value='3'>Member</option>
					<br>
				<input type='submit' value='Add Record'>
		</form>
	</body>
</html>


