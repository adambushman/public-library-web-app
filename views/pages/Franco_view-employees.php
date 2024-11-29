<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>


<!-- TABLE -->

<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-md-3">
			<div class="list-group">
				<a href="#" class="list-group-item list-group-item-action active" aria-current="true">Employees</a>
				<a href="#" class="list-group-item list-group-item-action">Members</a>
				<a href="#" class="list-group-item list-group-item-action">Reports</a>
			</div>
		</div>
		<div class="col-md-9">
			<h1>Employee List</h1>
			<div class="mb-4">
				<a href="Franco_add-employee.php" class="btn btn-sm btn-primary">Add Employee</a>
			</div>
			<table class="table">
				<thead>
					<tr>
						<th>Account ID</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Phone</th>
						<th>Email</th>
						<th>Street</th>
						<th>City</th>
						<th>State</th>
						<th>Zip</th>
						<th>Start Date</th>
						<th>Account Type</th>
						<th class="text-end">Actions</th>
					</tr>
					
<?php

require_once  '../../config/dbauth.php';

$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);

$query = "SELECT * FROM LIB_ACCOUNT";

$result = $conn->query($query); 
if(!$result) die($conn->error);

$rows = $result->num_rows;

for($j=0; $j<$rows; $j++){
	$result->data_seek($j); 
	$row = $result->fetch_array(MYSQLI_ASSOC);

            echo "<tr>";
            echo "<td>".$row['AccountID']."</td>";
            echo "<td>".$row['FirstName']."</td>";
            echo "<td>".$row['LastName']."</td>";
            echo "<td>".$row['Phone']."</td>";
			echo "<td>".$row['Email']."</td>";
			echo "<td>".$row['Street']."</td>";
			echo "<td>".$row['City']."</td>";
			echo "<td>".$row['State']."</td>";
			echo "<td>".$row['Zip']."</td>";
			echo "<td>".$row['StartDate']."</td>";
			echo "<td>".$row['AccountTypeID']."</td>";
            echo "<td>";
			echo "<form action='Franco_update-employee.php' method='post'>";
			echo "<input type='hidden' name='AccountID' value='".$row['AccountID']."'>";
			echo "<input type='submit' value='Update'>";
			echo "</form>";
			echo "<form action='Franco_delete-employee.php' method='post'>";
			echo "<input type='hidden' name='delete' value='yes'>";
			echo "<input type='hidden' name='AccountID' value='".$row['AccountID']."'>";
			echo "<input type='submit' value='Delete'>";
			echo "</form>";
            echo "</td>";
            echo "</tr>";
        }


$conn->close();

?>
</table>


<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>