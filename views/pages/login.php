<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>


<main id="login" class="my-auto">
        <div class="container container-fluid d-flex flex-column align-items-evenly">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-xl-6 col-xxl-4">
                    <div class="card">
						<img class="card-img-top" src="../../ImageDirectory/library1.jpeg" alt="">      
                        <div class="card-body">
							<h2>Login to Your Account</h2>
                            <form action="login.php" method="POST" class="w-md-75 justify-content-center">
                                <div class="my-3">
                                    <label for="emailInput" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="emailInput" name="email" placeholder="name@example.com">
                                </div>
                                <div>
                                    <label for="passwordInput" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="passwordInput" name="password" placeholder="************">
                                </div>
                                <div class="d-grid">
                                    <button type="submit" href="home.php" class="btn btn-dark my-3">Login</button>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between px-2 mb-3">
                                    <a href="#">
                                        <i class="bi bi-info-circle-fill pe-1"></i>
                                        Need Help Logging In?
                                    </a>
                                    <a href="#">
                                        Create an Account
                                        <i class="bi bi-book-fill ps-1"></i>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php


require_once '../../config/dbauth.php';
$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);

if (isset($_POST['Email']) && isset($_POST['Password'])) {
	
	//Get values from login screen
	$tmp_username = mysql_entities_fix_string($conn, $_POST['Email']);
	$tmp_password = mysql_entities_fix_string($conn, $_POST['Password']);
	
	//get password from DB w/ SQL
	$query = "SELECT Password FROM lib_account WHERE Email = '$tmp_username'";
	
	$result = $conn->query($query); 
	if(!$result) die("Query failed: ". $conn->error);
	
	$rows = $result->num_rows;
	$passwordFromDB="";
	for($j=0; $j<$rows; $j++)
	{
		$result->data_seek($j); 
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$passwordFromDB = $row['Password'];
	
	}
	
	//Compare passwords
	if(password_verify($tmp_password,$passwordFromDB))
	{
		echo "successful login<br>";
		
        // Start session and redirect to home.php
        session_start();
        $_SESSION['email'] = $tmp_username;
        
        // Redirect to home.php
        header("Location: home.php");
		exit();
	}
	else
	{
		header("Location: login.php");
		echo "unsuccessful login<br>";
		exit();
	}	
	
}

$conn->close();


//sanitization functions
function mysql_entities_fix_string($conn, $string){
	return htmlentities(mysql_fix_string($conn, $string));	
}

function mysql_fix_string($conn, $string){
	$string = stripslashes($string);
	return $conn->real_escape_string($string);
}



?>

<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>

