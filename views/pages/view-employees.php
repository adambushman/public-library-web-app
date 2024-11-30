<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

<!-- Authorization Code -->
<?php
require_once '../../config/dbauth.php';
require_once '../../helpers.php';

$conn = connect();

$roles = isset($_SESSION['accountId']) ? getAccountRoles($conn, $_SESSION['accountId']) : [];
preventMembers($roles); // Redirect if "Member"
?>

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
				<a href="add-employee.php" class="btn btn-sm btn-primary">Add Employee</a>
			</div>
			<table class="table">
				<thead>
					<tr>
						<th></th>
						<th>Department code</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th class="text-end">Actions</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<td>1</td>
						<td>Glenn</td>
						<td>Sturgis</td>
						<td>gsturgis@example.com</td>
						<td>801-123-4567</td>
						<td class="text-end">
							<a href="update-employee.php" class="btn text-secondary">
								<i class="bi bi-pencil"></i>
							</a>
							<a href="delete-employee.php" class="btn text-secondary">
								<i class="bi bi-trash3"></i>
							</a>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>2</td>
						<td>Amy</td>
						<td>Sosa</td>
						<td>asosa@example.com</td>
						<td>801-123-4567</td>
						<td class="text-end">
							<a href="update-employee.php" class="btn text-secondary">
								<i class="bi bi-pencil"></i>
							</a>
							<a href="delete-employee.php" class="btn text-secondary">
								<i class="bi bi-trash3"></i>
							</a>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>3</td>
						<td>Jonah</td>
						<td>Simms</td>
						<td>jsimms@example.com</td>
						<td>801-123-4567</td>
						<td class="text-end">
							<a href="update-employee.php" class="btn text-secondary">
								<i class="bi bi-pencil"></i>
							</a>
							<a href="delete-employee.php" class="btn text-secondary">
								<i class="bi bi-trash3"></i>
							</a>
						</td>
					</tr>
					</tbody>
			</table>
		</div>
	</div>
</div> 

<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>