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

<!-- FORM -->
<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<h2 class="mb-3">Update Employee</h2>

			<form>
				<div class="mb-3">
					<label for="deptCode">Department Code:</label>
					<input type="text" class="form-control" id="deptCode" name="deptCode" value="1" required>
				</div>

				<div class="mb-3">
					<label for="firstName">First Name:</label>
					<input type="text" class="form-control" id="firstName" name="firstName" value="Sammy" required>
				</div>

				<div class="mb-3">
					<label for="lastName">Last Name:</label>
					<input type="text" class="form-control" id="lastName" name="lastName" value="Stone" required>
				</div>

				<div class="mb-3"> 

					<label for="email">Email:</label>
					<input type="email" class="form-control" id="email" name="email" value="email@example.com" required>
				</div>

				<div class="mb-5">
					<label for="phone">Phone Number:</label>
					<input type="tel" class="form-control" id="phone" name="phone" value="801-123-4567" required>
				</div>
				
				<div class="d-flex justify-content-between">
					<a href="delete-employee.php" class="btn btn-danger">Delete</a>
					<div>
						<a href="view-employees.php" class="btn btn-secondary">Cancel</a>
						<a href="view-employees.php" class="btn btn-primary ms-2">Update</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>