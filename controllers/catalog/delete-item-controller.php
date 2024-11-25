<?php

require_once '../../config/dbauth.php';

if(!$_GET['itemId']) echo "Something went wrong"; //saveMsg('Something went wrong; could not find gift card', 'failure', "../Views/Pages/card-list.php?cardId=$cardId");
$itemId = $_GET['itemId'];

$conn = connect();

$query = "SELECT Title, ImagePath FROM LIB_ITEM WHERE ItemId = $itemId";
$result_2 = $conn->query($query);
$result_2->data_seek(0); 
$row_2 = $result_2->fetch_array(MYSQLI_ASSOC);
$imgPath = $row_2['ImagePath'];
$itemName = $row_2['Title'];

if(!unlink("../../$imgPath")) echo "Could not delete"; //saveMsg("Could not delete gift card image; Error: $conn->error", 'failure', "../Views/Pages/card-list.php?cardId=$cardId");

// Delete creator and publisher instances first
$query = "DELETE FROM LIB_ITEM_CREATOR WHERE itemID = $itemId";
$result = $conn->query($query);
if(!$result) "Could not delete item creators"; // saveMsg("Could not delete <span class='fw-bold'>$cardName</span>; Error: $conn->error", 'failure', "../Views/Pages/card-list.php?cardId=$cardId");

$query = "DELETE FROM LIB_ITEM_PUBLISHER WHERE itemID = $itemId";
$result = $conn->query($query);
if(!$result) "Could not delete item publishers"; // saveMsg("Could not delete <span class='fw-bold'>$cardName</span>; Error: $conn->error", 'failure', "../Views/Pages/card-list.php?cardId=$cardId");


// Delete the catalog item itself
$query = "DELETE FROM LIB_ITEM WHERE itemID = $itemId";
$result = $conn->query($query);
if(!$result) "Could not delete item"; // saveMsg("Could not delete <span class='fw-bold'>$cardName</span>; Error: $conn->error", 'failure', "../Views/Pages/card-list.php?cardId=$cardId");


$conn->close();
header("Location: ../../views/pages/view-catalog.php");
//saveMsg("Successfully deleted <span class='fw-bold'>$cardName</span>!", 'success', '../Views/Pages/card-list.php');