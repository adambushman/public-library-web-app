<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

						<img src="../../ImageDirectory/booklogo.jpg" style="float: left;" width="300" height="195" />
	<!-- Header -->
	<div class="jumbotron text-center">
		<h1>Library Home Page</h1>
	</div>
		
	<div class="container-fluid", class="col-lg-12" style="float: right;">	
	<img src="../../ImageDirectory/kidbook.jpg" syle="float: center-right" />
	</div>
	
	<!-- Search for Classes -->
	<div id="Search" class="container-fluid">
		<div class="row">
			<div class="col-sm-4">
			<h1><a href="404.php">Search for Classes</a></h1>
				<h4> We offer many classes from pottery to reading hour for children!</h4><br>
			<h1><a href="404.php">Track Items</a></h1>
				<h4> Check here to see if your favorite book is available!</h4><br>
			<h1><a href="404.php">Track Fines</a></h1>
				<h4> Check here to see if you need to pay fines before checking out your next book!</h4><br>	
			</div>
		</div>
	</div>


	

	
	
	<br>
	<br>
	<br>
    

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