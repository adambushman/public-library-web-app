<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

<!-- Authorization Code -->
<?php
require_once '../../config/dbauth.php';
require_once '../../helpers.php';

$conn = connect();

$roles = isset($_SESSION['accountId']) ? getAccountRoles($conn, $_SESSION['accountId']) : [];
preventMembers($roles); // Redirect if "Member"
?>

<?php
// Get all author names from db
$query = "SELECT Name, CreatorID FROM lib_creator";
$result = $conn->query($query);
if (!$result) die($conn->error);

// Put names in array
$authors = [];
while ($row = $result->fetch_assoc()) {
    $authors[] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $creatorID = $_POST['CreatorID'];
    $newName = $_POST['Name'];
    $newGender = $_POST['Gender'];
    $newDateBorn = $_POST['DateBorn'];
    $newDateDied = $_POST['DateDied'];
    $newBio = $_POST['Bio'];
    $newImagePath = $_POST['ImagePath'];

    if (isset($_POST['update'])) {
        // Update author details in the database
        $updateQuery = "UPDATE lib_creator SET 
                        Name='$newName', 
                        Gender='$newGender', 
                        DateBorn='$newDateBorn', 
                        DateDied='$newDateDied', 
                        Bio='$newBio', 
                        ImagePath='$newImagePath' 
                        WHERE CreatorID='$creatorID'";

        if ($conn->query($updateQuery)) {
            echo "Author details updated successfully!";
        } else {
            echo "Error updating Author: " . $conn->error;
        }
    }

    if (isset($_POST['delete'])) {
        // Delete the author from the database
        $deleteQuery = "DELETE FROM lib_creator WHERE CreatorID='$creatorID'";

        if ($conn->query($deleteQuery)) {
            echo "Author deleted successfully!";
        } else {
            echo "Error deleting Author: " . $conn->error;
        }
    }
}
?>

<!html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Author Information</title>
</head>
<body>
    <h1>Update Author Information</h1>

    <form method="POST" action="update-author.php">
        <!-- Dropdown for author names -->
        <label for="CreatorID">Select Author Name:</label>
        <select name="CreatorID" id="CreatorID" required>
            <option value="">Select an Author</option>
            <?php
            // Populate the dropdown with author names
            foreach ($authors as $author) {
                echo "<option value='" . $author['CreatorID'] . "'>" . htmlspecialchars($author['Name']) . "</option>";
            }
            ?>
        </select>
        <br><br>

        <!-- Name input -->
        <label for="Name">Name:</label>
        <input type="text" id="Name" name="Name" required>
        <br><br>

        <!-- Gender input -->
        <label for="Gender">Gender:</label>
        <input type="text" id="Gender" name="Gender" required>
        <br><br>

        <!-- DateBorn input -->
        <label for="DateBorn">Date of Birth:</label>
        <input type="date" id="DateBorn" name="DateBorn" required>
        <br><br>

        <!-- DateDied input -->
        <label for="DateDied">Date of Death:</label>
        <input type="date" id="DateDied" name="DateDied">
        <br><br>

        <!-- Bio input -->
        <label for="Bio">Biography:</label>
        <textarea id="Bio" name="Bio" required></textarea>
        <br><br>

        <!-- ImagePath input -->
        <label for="ImagePath">Image Path:</label>
        <input type="text" id="ImagePath" name="ImagePath">
        <br><br>

        <!-- Update Button -->
        <button type="submit" name="update">Update Author</button>
        <br><br>

        <!-- Delete Button -->
        <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this author?');">Delete Author</button>
    </form>

</body>
</html>

<?php
$conn->close();
?>

<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>
