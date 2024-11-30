<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>



<!-- TABLE -->

<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-md-3">
			<div class="list-group">
				<a href="view-employees.php" class="list-group-item list-group-item-action active" aria-current="true">Employees</a>
				<a href="view-members.php" class="list-group-item list-group-item-action">Members</a>
				<a href="#" class="list-group-item list-group-item-action">Reports</a>
			</div>
		</div>
		<div class="col-md-9">
			<h1>Employee List</h1>
			<div class="mb-4">
				<a href="add-employee.php" class="btn btn-sm btn-primary">Add Employee</a>
			</div>
			<table class="table">
				<thead>
					<tr>
						<th>Account ID</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Phone</th>
						<th>Email</th>
						<th>Account Type</th>
						<th class="text-end">Actions</th>
					</tr>
					
<?php

require_once  '../../config/dbauth.php';

$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);

$query = "SELECT * FROM LIB_ACCOUNT where AccountTypeID BETWEEN 1 and 2";

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
			echo "<td>".$row['AccountTypeID']."</td>";
            echo "<td class='text-end'>";
			echo "<a href='employee-details.php?AccountID=".$row['AccountID']."'class='btn btn-sm btn-primary'>Details</a>";
			echo "<form action='delete-employee.php?accountId=$row[AccountID]' method='post'>";
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