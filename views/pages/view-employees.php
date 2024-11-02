<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

<!-- TABLE -->

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="text-center">Employee List</h1>
        </div>
        <div class="col-md-4 text-right">
			<a href="add-employee.php" class="btn btn-primary">Add Employee</a>
			
        </div>
    </div>
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
                    <td>
                        <a href="delete-employee.php" class="btn btn-danger">Delete</a>
						<a href="update-employee.php" class="btn btn-primary btn-sm">Update</a>

                    </td>
                </tr>
				   <tr>
					<td></td>
					<td>2</td>
					<td>Amy</td>
					<td>Sosa</td>
                    <td>asosa@example.com</td>
                    <td>801-123-4567</td>
                    <td>
                        <a href="delete_employee.php" class="btn btn-danger">Delete</a>
						<a href="update-employee.php" class="btn btn-primary btn-sm">Update</a> 

                    </td>
                </tr>
				   <tr>
                    <td></td>
					<td>3</td>
					<td>Jonah</td>
					<td>Simms</td>
                    <td>jsimms@example.com</td>
                    <td>801-123-4567</td>
                    <td>
                        <a href="delete_employee.php" class="btn btn-danger">Delete</a>
						<a href="update-employee.php" class="btn btn-primary btn-sm">Update</a>

                    </td>
                </tr>
                </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C89scichPD0hXIKDPO4dyJ1hSf8gQBHY2A9BZ6qBYhKZikpWYAmgMedRac6o7D0lw"   
	crossorigin="anonymous"></script>
 
 
 <!-- CAROUSEL -->
 
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