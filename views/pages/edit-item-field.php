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

$table = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['table']);
$idName = transformTableName($table);

$conn = connect();
$queryFramework = <<<_END
    SELECT * FROM $table WHERE $idName = ?
_END;
$queryStmt = $conn->prepare($queryFramework);
$queryStmt->bind_param("i", $_GET['id']);
$queryStmt->execute();
$result = $queryStmt->get_result();
$result->data_seek(0);
$row = $result->fetch_array(MYSQLI_ASSOC);
?>

<main>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-sm-6">
            <?php
            require_once '../partials/item-field-form.php';
            renderFieldForm(
                "../../controllers/catalog/edit-item-field-controller.php?table=$_GET[table]&id=$_GET[id]", 
                'POST', 
                $_GET['table'], 
                $row['Name'],
                "Edit"
            );
            ?>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
<?php include_once '../partials/footer.php'; ?>