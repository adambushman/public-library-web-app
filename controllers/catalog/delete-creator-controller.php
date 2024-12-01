<?php

require_once '../../config/dbauth.php';
require_once '../../helpers.php';


$conn = connect();
$creatorId = prepSanitaryData($conn, $_GET['creatorId']);

// Get existing creator image page
$queryFramework = <<<_END
    SELECT ImagePath FROM LIB_CREATOR WHERE CreatorID = ?
_END;
$queryStmt = $conn->prepare($queryFramework);
$queryStmt->bind_param("i", $creatorId);
$queryStmt->execute();
$result = $queryStmt->get_result();
$result->data_seek(0);
$row = $result->fetch_array(MYSQLI_ASSOC);
$curImgPath = $row['ImagePath'];

// Delete creator
$queryFramework = <<<_END
    DELETE FROM LIB_CREATOR
    WHERE CreatorID = ?
_END;
$queryStmt = $conn->prepare($queryFramework);
$queryStmt->bind_param("i", $creatorId);
$queryStmt->execute();

$result = $queryStmt->get_result();
if(!$result) "Could not delete creator"; // saveMsg("Could not delete <span class='fw-bold'>$cardName</span>; Error: $conn->error", 'failure', "../Views/Pages/card-list.php?cardId=$cardId");
$queryStmt->close();
$conn->close();

// Remove creator image
if(!unlink("../../$curImgPath")) echo "Could not delete creator image"; //saveMsg("Could not delete gift card image; Error: $conn->error", 'failure', "../Views/Pages/card-list.php?cardId=$cardId");


header("Location: ../../views/pages/application-settings.php");
//saveMsg("Successfully deleted <span class='fw-bold'>$cardName</span>!", 'success', '../Views/Pages/card-list.php');
exit();