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

$query = "SELECT * FROM LIB_PUBLISHER_TYPE";
$result = $conn->query($query);
$rows = $result->num_rows;

$items = [];
for($i = 0; $i < $rows; $i++) {
    $result->data_seek($i);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    array_push($items, ["id" => $row['PublisherTypeID'], "name" => $row['Name']]);
}

$publisherId = $_GET['publisherId'];

$queryFramework = <<<_END
SELECT *
FROM LIB_PUBLISHER lp
WHERE lp.PublisherID = ?
_END;
$queryStmt = $conn->prepare($queryFramework);
$queryStmt->bind_param("i", $publisherId);
$queryStmt->execute();

$result = $queryStmt->get_result();
$result->data_seek(0); 
$row = $result->fetch_array(MYSQLI_ASSOC);

$queryStmt->close();
$conn->close();
?>

<main>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-sm-6">
            <h1 class="display-5 text-center">Edit publisher</h1>
            <p class="text-center"><i>* required inputs</i></p>
            <?php
            require_once '../partials/publisher-form.php';
            renderPublisherForm(
                $items, 
                false, 
                $row
            );
            ?>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>