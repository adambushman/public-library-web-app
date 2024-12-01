<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

<?php
require_once '../../config/dbauth.php';
require_once '../../helpers.php';

$conn = connect();

// Redirect to login if user is logged in
$includeAccountType = false;
if(!isset($_SESSION['accountId'])) {
    header('Location: login.php');
}
$accountId = $_GET['accountId'] ?? '';
if($accountId != $_SESSION['accountId']) {
    $includeAccountType = true;
}

$queryFramework = "SELECT * FROM LIB_ACCOUNT WHERE AccountID = ?";
$queryStmt = $conn->prepare($queryFramework);
$queryStmt->bind_param("i", $accountId);
$queryStmt->execute();
$results = $queryStmt->get_result();
$results->data_seek(0);
$row = $results->fetch_array(MYSQLI_ASSOC);
?>


<div class="main">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <h1 class="display-4 text-center">Edit Library Account</h1>
                <p class="text-center"><i>* required inputs</i></p>
                <?php
                require_once "../partials/account-form.php";

                renderAccountForm(
                    "../../controllers/account/edit-account-controller.php?accountId=$accountId" // Controller for action=""
                    ,$includeAccountType // Flag for including "accountType" field
                    ,$row
                );
                ?>
            </div>
        </div>
    </div>
</div>


<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>