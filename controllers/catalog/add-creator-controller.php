<?php

require_once '../../config/dbauth.php';
require_once '../../helpers.php';

$conn = connect();

// Handle image upload
if($_FILES) {
    $imgPath = createFullImgPath($_FILES['imgUpload']['name'], "creator_img_");
    move_uploaded_file($_FILES['imgUpload']['tmp_name'], "../../$imgPath");
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
    INSERT INTO LIB_CREATOR (Name, Gender, DateBorn, DateDied, Bio, ImagePath, CreatorTypeID) 
    VALUES (?, ?, ?, ?, ?, ?, ?)
_END;

$queryStmt = $conn->prepare($queryFramework);

$queryStmt->bind_param(
    "ssssssi", $name, $gender, $dateBorn, $dateDied, $bio, $imgPath, $creatorType
);

$queryStmt->execute();
$result = $queryStmt->get_result();
if(!$result) echo $conn->error; //saveMsg("Could not add gift card; Error: $conn->error", 'failure', '../Views/Pages/card-add.php');
$creatorId = $conn->insert_id;

// Respond with the creator 'id' and 'name'
if(isset($_GET['echo'])) {
    header('Location: ../../views/pages/application-settings.php');
} else {
    echo json_encode(['id' => $creatorId, 'name' => htmlspecialchars($name)]);
}

$queryStmt->close();
$conn->close();
exit();