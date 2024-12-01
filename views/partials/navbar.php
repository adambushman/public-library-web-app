<?php

require_once '../../config/dbauth.php';
require_once '../../helpers.php';

$conn = connect();

session_start();

$authenticated = isset($_SESSION['accountId']);
$roles = isset($_SESSION['accountId']) ? getAccountRoles($conn, $_SESSION['accountId']) : [];

$conn->close();

$authPath = $authenticated ? "../../controllers/authentication/logout-controller.php" : "login.php";
$authLang = $authenticated ? "Logout" : "Login";

echo <<<_END

<header>
	<nav class="navbar navbar-expand-lg bg-body-tertiary">
		<div class="container-fluid">
			<a class="navbar-brand d-inline-flex align-items-center" href="home.php">
				<h1><i class="bi bi-book-fill"></i></h1>
				<h3 class="ps-3">Public Library</h3>
			</a>
			<div>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<li class="nav-item">
							<a class="nav-link" href="view-catalog.php">Catalog</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="view-classes.php">Classes</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="view-events.php">Events</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="view-schedule.php">Schedule</a>
						</li>
_END;
if($authenticated) {
	if(array_intersect($roles, array("Admin", "Staff"))) {
		echo <<<_END
						<li class="nav-item">
							<a class="nav-link" href="application-settings.php">Application</a>
						</li>
		_END;
	}

	echo <<<_END
						<li class="nav-item">
							<a class="nav-link" href="view-account.php">Account</a>
						</li>
	_END;
}
echo <<<_END

						<li class="nav-item">
							<a class="nav-link" href="$authPath">$authLang</a>
						</li>
					</ul>
				</div>
			</div>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
		</div>
	</nav>
</header>

_END;