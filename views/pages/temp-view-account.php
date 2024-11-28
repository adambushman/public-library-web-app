<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>


<main class="my-auto text-center">
    <h1>Hello 👋</h1>
    <h1 class="display-5 mt-4"><span class="px-3 py-1 rounded-4 text-bg-primary">
    <?php
    if(isset($_SESSION['email'])) {
        echo "$_SESSION[email]";
    }
    ?>
    </span></h1>
</main>


<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>