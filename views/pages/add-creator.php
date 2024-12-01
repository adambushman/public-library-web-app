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

$query = "SELECT * FROM LIB_CREATOR_TYPE";
$result = $conn->query($query);
$rows = $result->num_rows;

$items = [];
for($i = 0; $i < $rows; $i++) {
    $result->data_seek($i);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    array_push($items, ["id" => $row['CreatorTypeID'], "name" => $row['Name']]);
}

$conn->close();
?>

<main>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-sm-6">
            <h1 class="display-5 text-center">Add creator</h1>
            <p class="text-center"><i>* required inputs</i></p>
            <?php
            require_once '../partials/creator-form.php';
            renderCreatorForm(
                $items, 
                false
            );
            ?>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>