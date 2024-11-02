<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>
	
	
	
	<!-- FORM -->
	
		<div class="container">   
	
			<div class="row justify-content-center">
				<div class="col-md-6">
					<h2>Update Employee</h2>
	
					<form>
						<div class="mb-3">
							<label for="deptCode">Department Code:</label>
							<input type="text" class="form-control" id="deptCode" name="deptCode" value="1" required>
						</div>
						<br>
	
						<div class="mb-3">
							<label for="firstName">First Name:</label>
							<input type="text" class="form-control" id="firstName" name="firstName" value="Sammy" required>
						</div>
						<br>
	
						<div class="mb-3">
							<label for="lastName">Last Name:</label>
							<input type="text" class="form-control" id="lastName" name="lastName" value="Stone" required>
						</div>
						<br>
	
						<div class="mb-3"> 
	
							<label for="email">Email:</label>
							<input type="email" class="form-control" id="email" name="email" value="email@example.com" required>
						</div>
						<br>
	
						<div class="mb-3">
	
							<label for="phone">Phone Number:</label>
							<input type="tel" class="form-control" id="phone" name="phone" value="801-123-4567" required>
						</div>
						<br>
	
						<div class="d-flex justify-content-end">
							<a href="delete-employee.php" class="btn btn-danger">Delete</a>
							<a href="view-employees.php" class="btn btn-primary ms-2">Update</a>
							
						</div>
					</form>
				</div>
			</div>
		</div>
	
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>   
	
		  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C89scichPD0hXIKDPO4dyJ1hSf8gQBHY2A9BZ6qBYhKZikpWYAmgMedRac6o7D0lw"   
 crossorigin="anonymous"></script>
 
		<div id="myCarousel" class="carousel slide text-center" data-ride="carousel">
			<!-- Indicators -->
			<h2>What is happening at our Library?</h2>
			<br>
			<br>
			<ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
			<li data-target="#myCarousel" data-slide-to="2"></li>
				<br>
			<br>
			</ol>
		
			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
			<div class="item active">
				<h4>Join us for story hour Wednesday and Thursdays from 10am-11am<br></h4>
			</div>
			<div class="item">
				<h4>Upcoming book fair with 10% off and BOGO!</span></h4>
			</div>
			<div class="item">
				<h4>Paint with Ms. Rachel for Mom and Kids!</span></h4>
			</div>
			</div>
		
			<!-- Left and right controls -->
			<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
			</a>
		</div>
		</div>
	

<?php include_once '../partials/footer.php'; ?>