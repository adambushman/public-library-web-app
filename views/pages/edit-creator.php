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
    $creatorId = prepSanitaryData($conn, $_GET['creatorId']);

    $queryFramework = <<<_END
        SELECT 
        lc.CreatorID, lc.Name, lc.Gender, lc.DateBorn, lc.DateDied, lc.Bio, lc.ImagePath, lct.Name AS `CreatorType`, 
        CONCAT('[', 
        GROUP_CONCAT(
            DISTINCT CONCAT(
                '{"id":', li.ItemID, 
                ',"title":"', li.Title, 
                '","description":"', li.Description, 
                '","image":"', li.ImagePath, '"}'
            )
            SEPARATOR ','
        ), 
        ']') AS `Works`
        FROM LIB_ITEM_CREATOR lic
        INNER JOIN LIB_CREATOR lc ON lc.CreatorID = lic.CreatorID
        INNER JOIN LIB_CREATOR_TYPE lct ON lct.CreatorTypeID = lc.CreatorTypeID
        LEFT JOIN LIB_ITEM li ON li.ItemID = lic.ItemID
        WHERE lc.CreatorID = ?
    _END;
    $queryStmt = $conn->prepare($queryFramework);
    $queryStmt->bind_param("i", $creatorId);
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
                <h1 class="display-5 text-center">Edit creator</h1>
                <p class="text-center"><i>* required inputs</i></p>
                <?php
                require_once '../partials/creator-form.php';
                renderCreatorForm(
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