<?php

require_once '../../config/dbauth.php';


$itemId = $_GET['itemId'];

$conn = connect();

// Handle image upload
if($_FILES) {
    $imgName = 'creator-img-' . $_FILES['imgUpload']['name'];
    $imgPath = "ImageDirectory/$imgName";
    move_uploaded_file($_FILES['imgUpload']['tmp_name'], "../../$imgPath");
};

$imgPath = null;
$oldImgPath = null;

if(isset($_FILES['imgUpload']) && $_FILES['imgUpload']['error'] === UPLOAD_ERR_OK) {
    // Prep new image for upload
    $imgName = 'creator-img-' . $_FILES['imgUpload']['name'];
    $imgPath = "ImageDirectory/$imgName";
    move_uploaded_file($_FILES['imgUpload']['tmp_name'], "../../$imgPath");

    $query = "SELECT ImagePath FROM LIB_ITEM WHERE itemId = $itemId";
    $result = $conn->query($query);
    $result->data_seek(0); 
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $oldImgPath = $row['ImagePath'];
};

// Get multi-value elements (creator, publisher)
function getListValues($type) {
    $i = 1;
    $active = TRUE;
    $multi_vals = array();
    do {
        if(isset($_POST[$type . $i])) {
            array_push($multi_vals, $_POST[$type . $i]);
        } else {
            $active = FALSE;
        }
        $i++; 
    } while($active);

    return $multi_vals;
}

// Consolidate values
$r = array(
    'title' => $_POST['title'], 
    'year' => $_POST['year'], 
    'description' => $_POST['description'], 
    'itemType' => $_POST['itemType'], 
    'mediaType' => $_POST['mediaType'], 
    'genre' => $_POST['genre'], 
    'copies' => $_POST['copies'], 
    'issue' => $_POST['issue'], 
    'isbn' => $_POST['isbn'], 
    'location' => $_POST['location'], 
    'creators' => getListValues('creator'), 
    'publishers' => getListValues('publisher'), 
    'image' => $imgPath
);

//var_dump($_POST);
//die();

// Update library item values
$query = <<<_END
    UPDATE LIB_ITEM 
    SET Isbn = '$r[isbn]', 
        Title = '$r[title]', 
        Description = '$r[description]', 
        Year = $r[year], 
        IssueNumber = $r[issue], 
        LibCopies = $r[copies],
        LibLocation = '$r[location]', 
        ItemTypeID = $r[itemType], 
        MediaTypeID = $r[mediaType], 
        GenreID = $r[genre]
    WHERE ItemID = $itemId
_END;
$result = $conn->query($query);

if(!$result) echo $conn->error; //saveMsg("Could not add gift card; Error: $conn->error", 'failure', '../Views/Pages/card-add.php');

// Remove old image
if($oldImgPath) {
    $query_3 = "UPDATE LIB_ITEM SET ImagePath = '$imgPath' WHERE itemID = $itemId";
    $result_3 = $conn->query($query_3);

    if(!$result_3) echo $conn->error; //saveMsg("Could not change gift card image; Error: $conn->error", 'failure', "../Views/Pages/card-update.php?cardId=$cardId");
    if(!unlink("../../$oldImgPath")) echo "Could not delete old file"; // saveMsg("Could not delete previous gift card image; Error: $conn->error", 'failure', "../Views/Pages/card-update.php?cardId=$cardId");
}

// Update creator values
$query = "DELETE FROM LIB_ITEM_CREATOR WHERE ItemId = $itemId";
$result = $conn->query($query);
if(!$result) echo $conn->error;

foreach($r['creators'] as $entry) {
    $query = <<<_END
        INSERT INTO LIB_ITEM_CREATOR (ItemID, CreatorID) VALUES
        ($itemId, $entry)
    _END;
    $result = $conn->query($query);
    if(!$result) echo $conn->error;
}

// Update publisher values
$query = "DELETE FROM LIB_ITEM_PUBLISHER WHERE ItemId = $itemId";
$result = $conn->query($query);
if(!$result) echo $conn->error;

foreach($r['publishers'] as $entry) {
    $query = <<<_END
        INSERT INTO LIB_ITEM_PUBLISHER (ItemID, PublisherID) VALUES
        ($itemId, $entry)
    _END;
    $result = $conn->query($query);
    if(!$result) echo $conn->error;
}

$conn->close();

header("Location: ../../views/pages/view-item.php?itemId=$itemId"); // Redirect back to the product list page
exit();