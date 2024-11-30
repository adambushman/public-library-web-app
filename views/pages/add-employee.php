<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

<!-- FORM -->
<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<h2 class="mb-3">Add Employee</h2>

			<form action="../../controllers/Staff/FrancoTestADD.php" method="POST">

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

					<label for="Email">Email:</label>
					<input type="text" class="form-control" id="Email" name="Email" required>
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
					<label for="AccountTypeID">AccountTypeID:</label>
					<input type="Text" class="form-control" id="AccountTypeID" name="AccountTypeID" required>
				</div>
			
				<div class="d-flex justify-content-end">
					<a href="view-employees.php" class="btn btn-secondary me-3">Cancel</a>
					<input type="submit" value="Add" class="btn btn-primary">
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>


<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>
