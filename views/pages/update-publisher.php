<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

<!-- Auth Code -->
<?php
require_once '../../config/dbauth.php';
require_once '../../helpers.php';

// Redirect to login if user is logged in
if(!isset($_SESSION['accountId'])) {
    header('Location: login.php');
	exit();
}

$conn = connect();

$roles = isset($_SESSION['accountId']) ? getAccountRoles($conn, $_SESSION['accountId']) : [];
preventMembers($roles); // Redirect if "Member"
?>

<?php

// Get all publisher names from db
$query = "SELECT Name, PublisherID FROM lib_publisher";
$result = $conn->query($query);
if (!$result) die($conn->error);

// put names in array
$publishers = [];
while ($row = $result->fetch_assoc()) {
    $publishers[] = $row;
}

// get info to update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $publisherID = $_POST['PublisherID'];
    $newDescription = $_POST['Description'];

    // Update the publisher details in the database
    $updateQuery = "UPDATE lib_publisher SET Description='$newDescription' WHERE PublisherID='$publisherID'";

    if ($conn->query($updateQuery)) {
        echo "Publisher details updated successfully!";
    } else {
        echo "Error updating Publisher: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Publisher Information</title>
</head>
<body>
    <h1>Update Publisher Information</h1>

    <form method="POST" action="update-publisher.php">
        <!-- Dropdown for publisher names -->
        <label for="PublisherID">Select Publisher Name:</label>
        <select name="PublisherID" id="PublisherID" required>
            <option value="">Select a Publisher</option>
            <?php
            // Populate the dropdown with publisher names
            foreach ($publishers as $publisher) {
                echo "<option value='" . $publisher['PublisherID'] . "'>" . ($publisher['Name']) . "</option>";
            }
            ?>
        </select>
        <br><br>

        <!-- Description input -->
        <label for="Description">Description:</label>
        <input type="text" id="Description" name="Description" required>
        <br><br>

        <button type="submit">Update Publisher</button>
		<br><br>
		   <!-- Delete Button -->
        <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this publisher?');">Delete Publisher</button>
    </form>

</body>
</html>

<?php
$conn->close();
?>

<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>
