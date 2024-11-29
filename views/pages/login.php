<!-- Header -->
<?php include_once '../partials/head.php'; ?>

<!-- Navbar -->
<?php include_once '../partials/navbar.php'; ?>


<main id="login" class="my-auto">
        <div class="container container-fluid d-flex flex-column align-items-evenly">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-xl-6 col-xxl-4">
                    <div class="card my-5">
						<img class="card-img-top" src="../../ImageDirectory/library1.jpeg" alt="">      
                        <div class="card-body">
							<h2>Login to Your Account</h2>
                            <form action="../../controllers/authentication/login-controller.php" method="POST" class="w-md-75 justify-content-center">
                                <div class="my-3">
                                    <label for="emailInput" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="emailInput" name="email" placeholder="name@example.com">
                                </div>
                                <div>
                                    <label for="passwordInput" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="passwordInput" name="password" placeholder="************">
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-dark my-3">Login</button>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between px-2 mb-3">
                                    <a href="#">
                                        <i class="bi bi-info-circle-fill pe-1"></i>
                                        Need Help Logging In?
                                    </a>
                                    <a href="add-user.php">
                                        Create an Account
                                        <i class="bi bi-book-fill ps-1"></i>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>

