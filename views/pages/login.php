<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

					<img src="../../ImageDirectory/booklogo.jpg" style="float: left;" width="300" height="195" />

		<div class="jumbotron text-center">
		<h1 style="color:red" ">Library</h1>



	</div>

		<br>
		<br>
		<h1 style="margin-left: 250px;"> Please Log into Your Library Account </h1>




		<br>
		<br>
		<br>
		<br>
	
			
		<form class="container-fluid text-center" action ='Library-home.html' method='post'>
		<h3 style="margin-left: 180px;">
		<img class="container-fluid text-right"src="../../ImageDirectory/library1.jpeg" width="700" height="500"/>
			Username:
				<input type='text' name ='username'>
				<br>
				<br>
			 Password: 
				<input type='text' name ='password'>
				<br>
				<br>
				<input type='submit' style="text-align: center;" />
		</form>
		<br>
		<br>
		</h3>
		<form class="container-fluid text-center" action ='Library-create-account.html' method='post'>
		<input type='submit' value= 'Create Account' style="text-align: center;" />
		</form>

<?php include_once '../partials/footer.php'; ?>