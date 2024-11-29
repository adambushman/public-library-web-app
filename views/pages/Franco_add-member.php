<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

<!-- FORM -->
<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<h2 class="mb-3">Add Member</h2>

			<form>
				<div class="mb-3">
					<label for="AccountID">Account ID:</label>
					<input type="text" class="form-control" id="AccountID" name="AccountID" required>
				</div>

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
					<label for="Password">Password:</label>
					<input type="Text" class="form-control" id="Password" name="Password" required>
				</div>

				<div class="mb-5">
					<label for="AccountTypeID">AccountTypeID:</label>
					<input type="Text" class="form-control" id="AccountTypeID" name="AccountTypeID" required>
				</div>


				<div class="d-flex justify-content-end">
					<a href="view-members.php" class="btn btn-secondary">Cancel</a>
					<a href="view-members.html" class="btn btn-primary ms-2">Add</a>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- DB Code -->
<?php
//import credentials for db
require_once '../../config/dbauth.php';

//connect to db
$conn = connect();
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
	
	
	//echo $AccountId.'<br>';
	
	$query = <<<_END
    INSERT INTO LIB_CREATOR (AccountID, FirstName, LastName, Phone, Email, Street, City, State,  Zip,  StartDate,  Password,  AccountTypeID) VALUES
    ('$AccountID', '$FirstName', '$LastName', '$Phone', '$Email', '$Street', '$City', '$State', '$Zip', '$StartDate', '$Password', '$AccountTypeID')
_END;
	
	//echo $query.'<br>';
	$result = $conn->query($query); 
	if(!$result) die($conn->error);
	
	$conn->close();
	header("Location: ../../views/pages/view-members.php");
	
	
	
}

?>


<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>