<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

<?php
require_once '../../config/dbauth.php';
require_once '../../controllers/Staff/GET_EmployeeDetails.php';

$conn = new mysqli($hn, $un, $pw, $db);

if (isset($_GET['AccountID'])) {
    $accountId = $_GET['AccountID'];

    // Defining the employee function
    function getEmployeeDetails($conn, $accountId) {
        $stmt = $conn->prepare("SELECT * FROM LIB_ACCOUNT WHERE AccountID = ?");
        $stmt->bind_param("i", $accountId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
	
    $employee = getEmployeeDetails($conn, $accountId);

}
?>

<html>
<head>
    <title>Employee Details</title>
    </head>
<body>
    <div class="container mt-5">
        <h2>Employee Details</h2>
        <?php if (isset($employee)):?>
            <div class="mb-3">


			
		<form action="../../controllers/Staff/update-employee.php" method="POST">
				
            <div class="mb-3">
                <label for="FirstName">First Name</label>
                <input type="text" class="form-control" id="FirstName" name="FirstName" value="<?php echo $employee['FirstName'];?>">
            </div>
			
            <div class="mb-3">
                <label for="LastName">Last Name</label>
                <input type="text" class="form-control" id="LastName" name="LastName" value="<?php echo $employee['LastName'];?>">
            </div>
			
            <div class="mb-3">
                <label for="Phone">Phone</label>
                <input type="text" class="form-control" id="Phone" name="Phone" value="<?php echo $employee['Phone'];?>">
            </div>
			
            <div class="mb-3">
                <label for="Email">Email</label>
                <input type="text" class="form-control" id="Email" name="Email" value="<?php echo $employee['Email'];?>">
            </div>
			
			<div class="mb-3">
                <label for="City">City</label>
                <input type="text" class="form-control" id="City" name="City" value="<?php echo $employee['City'];?>">
            </div>
			
			<div class="mb-3">
                <label for="Street">Street</label>
                <input type="text" class="form-control" id="Street" name="Street" value="<?php echo $employee['Street'];?>">
            </div>
			
			<div class="mb-3">
                <label for="State">State</label>
                <input type="text" class="form-control" id="State" name="State" value="<?php echo $employee['State'];?>">
            </div>
			
			<div class="mb-3">
                <label for="Zip">Zip</label>
                <input type="text" class="form-control" id="Zip" name="Zip" value="<?php echo $employee['Zip'];?>">
            </div>
			
			<div class="mb-3">
                <label for="StartDate">StartDate</label>
                <input type="text" class="form-control" id="StartDate" name="StartDate" value="<?php echo $employee['StartDate'];?>">
            </div>
			
			<div class="mb-3">
                <label for="AccountTypeID">AccountTypeID</label>
                <input type="text" class="form-control" id="AccountTypeID" name="AccountTypeID" value="<?php echo $employee['AccountTypeID'];?>">
            </div>
			
		
			<div class="d-flex justify-content-end">
				<a href="view-employees.php" class="btn btn-secondary me-2">Back</a>
				<button type="submit" class="btn btn-primary">Update</button>
            </div>
		</form>
        <?php else: ?>
            <p>Employee not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>



<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>