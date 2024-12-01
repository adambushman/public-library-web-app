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

<main>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-sm-6">
            <?php
            require_once '../partials/item-field-form.php';
            renderFieldForm(
                '../../controllers/catalog/add-item-field-controller.php', 
                'POST', 
                $_GET['table'], 
                NULL, 
                "Add"
            );
            ?>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>