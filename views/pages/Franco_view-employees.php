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
				<a href="add-employee.php" class="btn btn-sm btn-primary">Add Employee</a>
			</div>
			<table class="table">
				<thead>
					<tr>
						<th></th>
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
				</thead>
				<tbody>
					<tr>
						<td></td>
						<td>201</td>
						<td>Glenn</td>
						<td>Sturgis</td>
						<td>801-123-4567</td>
						<td>gsturgis@example.com</td>
						<th>234 Street</th>
						<th>Warsaw</th>
						<th>NY</th>
						<th>64578</th>
						<th>10/14/2005</th>
						<th>1</th>
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
						<td>202</td>
						<td>Amy</td>
						<td>Sosa</td>
						<td>801-123-4567</td>
						<td>asosa@example.com</td>
						<th>Baker Street</th>
						<th>Los Angeles</th>
						<th>CA</th>
						<th>98956</th>
						<th>05/08/2006</th>
						<th>2</th>
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
						<td>203</td>
						<td>Jonah</td>
						<td>Simms</td>
						<td>801-123-4567</td>
						<td>jsimms@example.com</td>
						<th>456 Main Ave</th>
						<th>Ogden</th>
						<th>UT</th>
						<th>84067</th>
						<th>11/22/2012</th>
						<th>3</th>
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