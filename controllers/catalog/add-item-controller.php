<?php

require_once '../../config/dbauth.php';
require_once '../../helpers.php';

$conn = connect();

// Handle image upload
if($_FILES) {
    $imgPath = createFullImgPath($_FILES['imgUpload']['name'], "item_img_");
    move_uploaded_file($_FILES['imgUpload']['tmp_name'], "../../$imgPath");
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

// Validate the inputs


// Add library item values
$queryFramework = <<<_END
    INSERT INTO LIB_ITEM (Isbn, Title, Description, Year, IssueNumber, LibCopies, ImagePath, LibLocation, ItemTypeID, MediaTypeID, GenreID)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
_END;

$queryStmt = $conn->prepare($queryFramework);

$queryStmt->bind_param(
    "sssiiissiii", $r['isbn'], $r['title'], $r['description'], $r['year'], $r['issue'], $r['copies'], $r['image'], $r['location'], $r['itemType'], $r['mediaType'], $r['genre']
);

$queryStmt->execute();
$result = $queryStmt->get_result();
if(!$result) echo $conn->error; //saveMsg("Could not add gift card; Error: $conn->error", 'failure', '../Views/Pages/card-add.php');
$queryStmt->close();

$itemId = $conn->insert_id;


// Add creator values
foreach($r['creators'] as $entry) {
    $queryFramework = <<<_END
        INSERT INTO LIB_ITEM_CREATOR (ItemID, CreatorID)
        VALUES (?, ?)
    _END;
    $queryStmt = $conn->prepare($queryFramework);

    $queryStmt->bind_param(
        "ii", $itemId, $entry
    );

    $queryStmt->execute();
    $result = $queryStmt->get_result();
    if(!$result) echo $conn->error;
}

$queryStmt->close();

// Add publisher values
foreach($r['publishers'] as $entry) {
    $queryFramework = <<<_END
        INSERT INTO LIB_ITEM_PUBLISHER (ItemID, PublisherID)
        VALUES (?, ?)
    _END;
    $queryStmt = $conn->prepare($queryFramework);

    $queryStmt->bind_param(
        "ii", $itemId, $entry
    );

    $queryStmt->execute();
    $result = $queryStmt->get_result();
    if(!$result) echo $conn->error;
}

$queryStmt->close();
$conn->close();

header("Location: ../../views/pages/view-item.php?itemId=$itemId"); // Redirect back to the product list page

exit();