<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

<!-- FORM -->
<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<h2 class="mb-3">Add Employee</h2>

			<form action="FrancoTestADD.php" method="post">

				<div class="mb-3">
					<label for="FirstName">First Name:</label>
					<input type="text" class="form-control" id="FirstName" name="FirstName" required>
				</div>

				<div class="mb-3">
					<label for="LastName">Last Name:</label>
					<input type="text" class="form-control" id="LastName" name="LastName" required>
				</div>

				<div class="mb-3"> 

					<label for="Phone">Phone:</label>
					<input type="text" class="form-control" id="Phone" name="Phone" required>
				</div>

				<div class="mb-3"> 

					<label for="email">Email:</label>
					<input type="text" class="form-control" id="email" name="email" required>
				</div>

				<div class="mb-5">
					<label for="Street">Street:</label>
					<input type="Text" class="form-control" id="Street" name="Street" required>
				</div>

				<div class="mb-5">
					<label for="City">City:</label>
					<input type="Text" class="form-control" id="City" name="City" required>
				</div>

				<div class="mb-5">
					<label for="State">State:</label>
					<input type="Text" class="form-control" id="State" name="State" required>
				</div>

				<div class="mb-5">
					<label for="Zip">Zip:</label>
					<input type="Text" class="form-control" id="Zip" name="Zip" required>
				</div>

				<div class="mb-5">
					<label for="StartDate">StartDate:</label>
					<input type="Text" class="form-control" id="StartDate" name="StartDate" required>
				</div>

				<div class="mb-5">
					<label for="Password">Password:</label>
					<input type="Text" class="form-control" id="Password" name="Password" required>
				</div>

				<div class="mb-5">
					<label for="AccountTypeID">AccountTypeID:</label>
					<input type="Text" class="form-control" id="AccountTypeID" name="AccountTypeID" required>
				</div>

				
				<div class="d-flex justify-content-end">
					<a href="Franco_view-employees.php" class="btn btn-secondary me-3">Cancel</a>
					<input type="submit" value="Add" class="btn btn-primary">
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>

<!-- DB Code -->
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


<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>
