<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

<!-- FORM -->
<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<h2 class="mb-3">Update Employee</h2>

			<form>
				<div class="mb-3">
					<label for="deptCode">Department Code:</label>
					<input type="text" class="form-control" id="deptCode" name="deptCode" required>
				</div>

				<div class="mb-3">
					<label for="firstName">First Name:</label>
					<input type="text" class="form-control" id="firstName" name="firstName" required>
				</div>

				<div class="mb-3">
					<label for="lastName">Last Name:</label>
					<input type="text" class="form-control" id="lastName" name="lastName" required>
				</div>

				<div class="mb-3"> 

					<label for="email">Email:</label>
					<input type="email" class="form-control" id="email" name="email" required>
				</div>

				<div class="mb-5">
					<label for="phone">Phone Number:</label>
					<input type="tel" class="form-control" id="phone" name="phone" required>
				</div>


				<div class="d-flex justify-content-end">
					<a href="view-employees.php" class="btn btn-secondary">Cancel</a>
					<a href="view-employees.html" class="btn btn-primary ms-2">Add</a>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>