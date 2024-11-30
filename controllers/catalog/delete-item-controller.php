<?php

require_once '../../config/dbauth.php';
require_once '../../helpers.php';

if(!$_GET['itemId']) echo "Something went wrong"; //saveMsg('Something went wrong; could not find gift card', 'failure', "../Views/Pages/card-list.php?cardId=$cardId");

$conn = connect();
$itemId = prepSanitaryData($conn, $_GET['itemId']);

$queryFramework = <<<_END
    SELECT Title, ImagePath FROM LIB_ITEM WHERE itemId = ?
_END;
$queryStmt = $conn->prepare($queryFramework);
$queryStmt->bind_param("i", $itemId);
$queryStmt->execute();

$result = $queryStmt->get_result();
$row = $result->fetch_array(MYSQLI_ASSOC);
$imgPath = $row['ImagePath'];
$itemName = $row['Title'];


// Delete creator instances
$queryFramework = <<<_END
    DELETE FROM LIB_ITEM_CREATOR WHERE itemID = ?
_END;
$queryStmt = $conn->prepare($queryFramework);
$queryStmt->bind_param("i", $itemId);
$queryStmt->execute();

$result = $queryStmt->get_result();
if(!$result) "Could not delete item creators"; // saveMsg("Could not delete <span class='fw-bold'>$cardName</span>; Error: $conn->error", 'failure', "../Views/Pages/card-list.php?cardId=$cardId");
$queryStmt->close();

// Delete publisher instances
$queryFramework = <<<_END
    DELETE FROM LIB_ITEM_PUBLISHER WHERE itemID = ?
_END;
$queryStmt = $conn->prepare($queryFramework);
$queryStmt->bind_param("i", $itemId);
$queryStmt->execute();

$result = $queryStmt->get_result();
if(!$result) "Could not delete item publishers"; // saveMsg("Could not delete <span class='fw-bold'>$cardName</span>; Error: $conn->error", 'failure', "../Views/Pages/card-list.php?cardId=$cardId");
$queryStmt->close();


// Delete the catalog item itself
$queryFramework = <<<_END
    DELETE FROM LIB_ITEM WHERE itemID = ?
_END;
$queryStmt = $conn->prepare($queryFramework);
$queryStmt->bind_param("i", $itemId);
$queryStmt->execute();

$result = $queryStmt->get_result();
if(!$result) "Could not delete item"; // saveMsg("Could not delete <span class='fw-bold'>$cardName</span>; Error: $conn->error", 'failure', "../Views/Pages/card-list.php?cardId=$cardId");
$queryStmt->close();

// Delte item image
if(!unlink("../../$imgPath")) echo "Could not delete"; //saveMsg("Could not delete gift card image; Error: $conn->error", 'failure', "../Views/Pages/card-list.php?cardId=$cardId");


$conn->close();

header("Location: ../../views/pages/view-catalog.php");
//saveMsg("Successfully deleted <span class='fw-bold'>$cardName</span>!", 'success', '../Views/Pages/card-list.php');
exit();