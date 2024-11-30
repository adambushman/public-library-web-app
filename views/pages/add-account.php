<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>

<?php
// Redirect to account if user is logged in
if(isset($_SESSION['accountId'])) {
    header('Location: view-account.php');
}
?>


<div class="main">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <h1 class="display-4 text-center">Create Library Account</h1>
                <p class="text-center"><i>* required inputs</i></p>
                <?php
                require_once '../partials/account-form.php';

                renderAccountForm(
                    '../../controllers/account/add-account-controller.php' // Controller for action=""
                    ,false // Flag for including "accountType" field
                );
                ?>
            </div>
        </div>
    </div>
</div>


<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>