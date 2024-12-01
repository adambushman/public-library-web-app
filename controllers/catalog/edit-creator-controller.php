<?php

require_once '../../config/dbauth.php';
require_once '../../helpers.php';

$conn = connect();

$creatorId = $_GET['creatorId'];

// Handle image upload
$imgPath = null;
$oldImgPath = null;

if(isset($_FILES['imgUpload']) && $_FILES['imgUpload']['error'] === UPLOAD_ERR_OK) {
    // Prep new image for upload
    $imgPath = createFullImgPath($_FILES['imgUpload']['name'], "item_img_");
    move_uploaded_file($_FILES['imgUpload']['tmp_name'], "../../$imgPath");

    $queryFramework = <<<_END
        SELECT ImagePath FROM LIB_CREATOR WHERE creatorId = ?
    _END;
    $queryStmt = $conn->prepare($queryFramework);
    $queryStmt->bind_param("i", $creatorId);
    $queryStmt->execute();

    $result = $queryStmt->get_result();
    $result->data_seek(0); 
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $oldImgPath = $row['ImagePath'];
};


// Clean the inputs
// `prepSanitaryData()` comes from "helpers.php"
$name = prepSanitaryData($conn, $_POST['name']); 
$gender = prepSanitaryData($conn, $_POST['gender']); 
$bio = prepSanitaryData($conn, $_POST['bio']); 
$creatorType = prepSanitaryData($conn, $_POST['creatorType']); 
$bdate = prepSanitaryData($conn, $_POST['dateBorn']);
$ddate = prepSanitaryData($conn, $_POST['dateDied']);
$dateBorn = sprintf("%s", date("Y-m-d", strtotime($bdate)));
$dateDied = $ddate == '' ? null : sprintf("%s", date("Y-m-d", strtotime($ddate)));


// Validate the inputs


// Add the "creator"
$queryFramework = <<<_END
    UPDATE LIB_CREATOR
    SET 
        Name = ?,
        Gender = ?,
        DateBorn = ?,
        DateDied = ?,
        Bio = ?,
        CreatorTypeID = ?
    WHERE
        CreatorID = ?
_END;

$queryStmt = $conn->prepare($queryFramework);

$queryStmt->bind_param(
    "sssssii", $name, $gender, $dateBorn, $dateDied, $bio, $creatorType, $creatorId
);

$queryStmt->execute();
$result = $queryStmt->get_result();
if(!$result) echo $conn->error; //saveMsg("Could not add gift card; Error: $conn->error", 'failure', '../Views/Pages/card-add.php');
$queryStmt->close();

// Remove Old Image (if necessary)
if(!is_null($oldImgPath)) {
    if(!unlink("../../$oldImgPath")) echo "Could not delete creator image"; //saveMsg("Could not delete gift card image; Error: $conn->error", 'failure', "../Views/Pages/card-list.php?cardId=$cardId");

    $queryFramework = <<<_END
        UPDATE LIB_CREATOR
        SET 
            ImagePath = ?
        WHERE
            CreatorID = ?
    _END;

    $queryStmt = $conn->prepare($queryFramework);
    $queryStmt->bind_param(
        "si", $imgPath, $creatorId
    );

    $queryStmt->execute();
    $result = $queryStmt->get_result();
    if(!$result) echo $conn->error; //saveMsg("Could not add gift card; Error: $conn->error", 'failure', '../Views/Pages/card-add.php');
    $queryStmt->close();
}

header('Location: ../../views/pages/application-settings.php');

$conn->close();
exit();