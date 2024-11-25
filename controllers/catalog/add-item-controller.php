<?php

require_once '../../config/dbauth.php';

$conn = connect();

// Handle image upload
if($_FILES) {
    $imgName = 'creator-img-' . $_FILES['imgUpload']['name'];
    $imgPath = "ImageDirectory/$imgName";
    move_uploaded_file($_FILES['imgUpload']['tmp_name'], "../../$imgPath");
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

// Add library item values
$query = <<<_END
    INSERT INTO LIB_ITEM (Isbn, Title, Description, Year, IssueNumber, LibCopies, ImagePath, LibLocation, ItemTypeID, MediaTypeID, GenreID) VALUES
    ('$r[isbn]','$r[title]', '$r[description]', $r[year], $r[issue], $r[copies], '$r[image]', '$r[location]', $r[itemType], $r[mediaType], $r[genre])
_END;
$result = $conn->query($query);

if(!$result) echo $conn->error; //saveMsg("Could not add gift card; Error: $conn->error", 'failure', '../Views/Pages/card-add.php');
$itemId = $conn->insert_id;

//var_dump($r['publishers']);
//die();

// Add creator values
foreach($r['creators'] as $entry) {
    $query = <<<_END
        INSERT INTO LIB_ITEM_CREATOR (ItemID, CreatorID) VALUES
        ($itemId, $entry)
    _END;
    $result = $conn->query($query);
    if(!$result) echo $conn->error;
}

// Add creator values
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