<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

<?php
require_once '../../config/dbauth.php';
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

// Get all genre names from db
$query = "SELECT Name, GenreID FROM lib_genre";
$result = $conn->query($query);
if (!$result) die($conn->error);

// Put genre names in array
$genres = [];
while ($row = $result->fetch_assoc()) {
    $genres[] = $row;
}

// Handle form submission to update genre info
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $genreID = $_POST['GenreID'];
    $newName = $_POST['Name'];
    $newDescription = $_POST['Description'];

    if (isset($_POST['update'])) {
        // Update genre details in the database
        $updateQuery = "UPDATE lib_genre SET 
                        Name='$newName', 
                        Description='$newDescription' 
                        WHERE GenreID='$genreID'";

        if ($conn->query($updateQuery)) {
            echo "Genre details updated successfully!";
        } else {
            echo "Error updating Genre: " . $conn->error;
        }
    }

    if (isset($_POST['delete'])) {
        // Delete the genre from the database
        $deleteQuery = "DELETE FROM lib_genre WHERE GenreID='$genreID'";

        if ($conn->query($deleteQuery)) {
            echo "Genre deleted successfully!";
        } else {
            echo "Error deleting Genre: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Genre Information</title>
</head>
<body>
    <h1>Update Genre Information</h1>

    <form method="POST" action="update-genre.php">
        <!-- Dropdown for genre names -->
        <label for="GenreID">Select Genre:</label>
        <select name="GenreID" id="GenreID" required>
            <option value="">Select a Genre</option>
            <?php
            // Populate the dropdown with genre names
            foreach ($genres as $genre) {
                echo "<option value='" . $genre['GenreID'] . "'>" . htmlspecialchars($genre['Name']) . "</option>";
            }
            ?>
        </select>
        <br><br>

        <!-- Name input -->
        <label for="Name">Name:</label>
        <input type="text" id="Name" name="Name" required>
        <br><br>

        <!-- Description input -->
        <label for="Description">Description:</label>
        <textarea id="Description" name="Description" required></textarea>
        <br><br>

        <!-- Update Button -->
        <button type="submit" name="update">Update Genre</button>
        <br><br>

        <!-- Delete Button -->
        <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this genre?');">Delete Genre</button>
    </form>

</body>
</html>

<?php
$conn->close();
?>

<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>
