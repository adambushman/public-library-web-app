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

<a href="update-publisher.php"> Update Publisher </a>
<a href="update-author.php"> Update Author </a>
<a href="update-genre.php"> Update Genre </a>

<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>
