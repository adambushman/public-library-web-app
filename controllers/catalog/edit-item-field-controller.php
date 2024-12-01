<?php

require_once '../../config/dbauth.php';
require_once '../../helpers.php';

$conn = connect();

// Clean the inputs
// `prepSanitaryData()` comes from "helpers.php"
$id = prepSanitaryData($conn, $_GET['id']); 
$name = prepSanitaryData($conn, $_POST['name']); 
$table = prepSanitaryData($conn, $_POST['table'] ?? '');
$inputField = prepSanitaryData($conn, $_POST['inputField'] ?? '');
$reopen = prepSanitaryData($conn, $_POST['reopen'] ?? '');
$idName = transformTableName($table);

// Validate the inputs


// Add the field value
$queryFramework = <<<_END
    UPDATE $table 
    SET
        Name = ?
    WHERE $idName = ?
_END;

$queryStmt = $conn->prepare($queryFramework);

$queryStmt->bind_param(
    "si", $name, $id
);

$queryStmt->execute();
$result = $queryStmt->get_result();
if(!$result) echo $conn->error; //saveMsg("Could not add gift card; Error: $conn->error", 'failure', '../Views/Pages/card-add.php');

header('Location: ../../views/pages/application-settings.php');

$queryStmt->close();
$conn->close();
exit();