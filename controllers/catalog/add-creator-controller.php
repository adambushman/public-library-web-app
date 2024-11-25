<?php

require_once '../../config/dbauth.php';
$conn = connect();

// Handle image upload
if($_FILES) {
    $imgName = 'creator-img-' . $_FILES['imgUpload']['name'];
    $imgPath = "ImageDirectory/$imgName";
    move_uploaded_file($_FILES['imgUpload']['tmp_name'], "../../$imgPath");
};


// Add the creator
$name = $_POST['name']; 
$gender = $_POST['gender']; 
$bio = $_POST['bio']; 
$dateBorn = sprintf("%s", date("Y-m-d", strtotime($_POST['dateBorn'])));
$dateDied = sprintf("%s", date("Y-m-d", strtotime($_POST['dateDied'])));
$creatorType = $_POST['creatorType']; 

$query = <<<_END
    INSERT INTO LIB_CREATOR (Name, Gender, DateBorn, DateDied, Bio, ImagePath, CreatorTypeID) VALUES
    ('$name', '$gender', '$dateBorn', '$dateDied', '$bio', '$imgPath', $creatorType)
_END;

$result = $conn->query($query);
if(!$result) echo $conn->error; //saveMsg("Could not add gift card; Error: $conn->error", 'failure', '../Views/Pages/card-add.php');
$itemId = $conn->insert_id;

// Respond with the creator 'id' and 'name'
echo "{\"id\": $itemId, \"name\": \"$name\"}";