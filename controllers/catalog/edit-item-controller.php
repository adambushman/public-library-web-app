<?php

require_once '../../config/dbauth.php';
require_once '../../helpers.php';


$conn = connect();
$itemId = prepSanitaryData($conn, $_GET['itemId']);

// Handle image upload
$imgPath = null;
$oldImgPath = null;

if(isset($_FILES['imgUpload']) && $_FILES['imgUpload']['error'] === UPLOAD_ERR_OK) {
    // Prep new image for upload
    $imgPath = createFullImgPath($_FILES['imgUpload']['name'], "item_img_");
    move_uploaded_file($_FILES['imgUpload']['tmp_name'], "../../$imgPath");

    $queryFramework = <<<_END
        SELECT ImagePath FROM LIB_ITEM WHERE itemId = ?
    _END;
    $queryStmt = $conn->prepare($queryFramework);
    $queryStmt->bind_param("i", $itemId);
    $queryStmt->execute();

    $result = $queryStmt->get_result();
    $result->data_seek(0); 
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $oldImgPath = $row['ImagePath'];
};

// Get multi-value elements (creator, publisher)
function getListValues($type) {
    global $conn;
    $i = 1;
    $active = TRUE;
    $multi_vals = array();
    do {
        if(isset($_POST[$type . $i])) {
            array_push($multi_vals, prepSanitaryData($conn, $_POST[$type . $i]));
        } else {
            $active = FALSE;
        }
        $i++; 
    } while($active);

    return $multi_vals;
}

// Consolidate values
$r = array(
    'title' => prepSanitaryData($conn, $_POST['title']), 
    'year' => prepSanitaryData($conn, $_POST['year']), 
    'description' => prepSanitaryData($conn, $_POST['description']), 
    'itemType' => prepSanitaryData($conn, $_POST['itemType']), 
    'mediaType' => prepSanitaryData($conn, $_POST['mediaType']), 
    'genre' => prepSanitaryData($conn, $_POST['genre']), 
    'copies' => prepSanitaryData($conn, $_POST['copies']), 
    'issue' => prepSanitaryData($conn, $_POST['issue']), 
    'isbn' => prepSanitaryData($conn, $_POST['isbn']), 
    'location' => prepSanitaryData($conn, $_POST['location']), 
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

$queryFramework = <<<_END
    UPDATE LIB_ITEM 
    SET Isbn = ?,  
        Title = ?, 
        Description = ?, 
        Year = ?, 
        IssueNumber = ?, 
        LibCopies = ?,
        LibLocation = ?, 
        ItemTypeID = ?, 
        MediaTypeID = ?, 
        GenreID = ?
    WHERE ItemID = ?
_END;

$queryStmt = $conn->prepare($queryFramework);

$queryStmt->bind_param(
    "sssiiisiiii", $r['isbn'], $r['title'], $r['description'], $r['year'], $r['issue'], $r['copies'], $r['location'], $r['itemType'], $r['mediaType'], $r['genre'], $itemId
);


$queryStmt->execute();
$result = $queryStmt->get_result();
if(!$result) echo $conn->error; //saveMsg("Could not add gift card; Error: $conn->error", 'failure', '../Views/Pages/card-add.php');

$queryStmt->close();

// Remove old image
if($oldImgPath) {
    $queryFramework = <<<_END
        UPDATE LIB_ITEM SET ImagePath = ? WHERE itemID = ?
    _END;

    $queryStmt = $conn->prepare($queryFramework);
    $queryStmt->bind_param(
        "si", $imgPath, $itemId
    );

    $queryStmt->execute();
    $result = $queryStmt->get_result();

    if(!$result) echo $conn->error; //saveMsg("Could not change gift card image; Error: $conn->error", 'failure', "../Views/Pages/card-update.php?cardId=$cardId");
    if(!unlink("../../$oldImgPath")) echo "Could not delete old file"; // saveMsg("Could not delete previous gift card image; Error: $conn->error", 'failure', "../Views/Pages/card-update.php?cardId=$cardId");
}

// Update creator values
$queryFramework = <<<_END
    DELETE FROM LIB_ITEM_CREATOR WHERE ItemId = ?
_END;

$queryStmt = $conn->prepare($queryFramework);
$queryStmt->bind_param("i", $itemId);

$queryStmt->execute();
$result = $queryStmt->get_result();
if(!$result) echo $conn->error;
$queryStmt->close();

foreach($r['creators'] as $entry) {
    $queryFramework = <<<_END
        INSERT INTO LIB_ITEM_CREATOR (ItemID, CreatorID)
        VALUES (?,?)
    _END;

    $queryStmt = $conn->prepare($queryFramework);
    $queryStmt->bind_param("ii", $itemId, $entry);

    $queryStmt->execute();
    $result = $queryStmt->get_result();
    if(!$result) echo $conn->error;
    $queryStmt->close();
}

// Update publisher values
$queryFramework = <<<_END
    DELETE FROM LIB_ITEM_PUBLISHER WHERE ItemId = ?
_END;

$queryStmt = $conn->prepare($queryFramework);
$queryStmt->bind_param("i", $itemId);

$queryStmt->execute();
$result = $queryStmt->get_result();
if(!$result) echo $conn->error;
$queryStmt->close();

foreach($r['publishers'] as $entry) {
    $queryFramework = <<<_END
        INSERT INTO LIB_ITEM_PUBLISHER (ItemID, PublisherID)
        VALUES (?,?)
    _END;

    $queryStmt = $conn->prepare($queryFramework);
    $queryStmt->bind_param("ii", $itemId, $entry);

    $queryStmt->execute();
    $result = $queryStmt->get_result();
    if(!$result) echo $conn->error;
    $queryStmt->close();
}

$conn->close();

header("Location: ../../views/pages/view-item.php?itemId=$itemId"); // Redirect back to the product list page
exit();