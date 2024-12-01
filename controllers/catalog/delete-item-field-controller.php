<?php

require_once '../../config/dbauth.php';
require_once '../../helpers.php';


$conn = connect();
$id = prepSanitaryData($conn, $_GET['id']);
$table = prepSanitaryData($conn, $_GET['table']);
$idName = transformTableName($table);

$queryFramework = <<<_END
    DELETE FROM $table
    WHERE $idName = ?
_END;
$queryStmt = $conn->prepare($queryFramework);
$queryStmt->bind_param("i", $id);
$queryStmt->execute();

$result = $queryStmt->get_result();
if(!$result) "Could not delete fielditem"; // saveMsg("Could not delete <span class='fw-bold'>$cardName</span>; Error: $conn->error", 'failure', "../Views/Pages/card-list.php?cardId=$cardId");
$queryStmt->close();
$conn->close();

header("Location: ../../views/pages/application-settings.php");
//saveMsg("Successfully deleted <span class='fw-bold'>$cardName</span>!", 'success', '../Views/Pages/card-list.php');
exit();