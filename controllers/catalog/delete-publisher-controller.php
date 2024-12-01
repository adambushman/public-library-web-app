<?php

require_once '../../config/dbauth.php';
require_once '../../helpers.php';


$conn = connect();
$publisherId = prepSanitaryData($conn, $_GET['publisherId']);

$queryFramework = <<<_END
    DELETE FROM LIB_PUBLISHER
    WHERE PublisherID = ?
_END;
$queryStmt = $conn->prepare($queryFramework);
$queryStmt->bind_param("i", $publisherId);
$queryStmt->execute();

$result = $queryStmt->get_result();
if(!$result) "Could not delete publisher"; // saveMsg("Could not delete <span class='fw-bold'>$cardName</span>; Error: $conn->error", 'failure', "../Views/Pages/card-list.php?cardId=$cardId");
$queryStmt->close();
$conn->close();

header("Location: ../../views/pages/application-settings.php");
//saveMsg("Successfully deleted <span class='fw-bold'>$cardName</span>!", 'success', '../Views/Pages/card-list.php');
exit();