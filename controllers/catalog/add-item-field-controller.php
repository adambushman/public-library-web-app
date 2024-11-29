<?php

header('Content-Type: application/json');
require_once '../../config/dbauth.php';
require_once '../../helpers.php';

$conn = connect();

// Clean the inputs
// `prepSanitaryData()` comes from "helpers.php"
$name = prepSanitaryData($conn, $_POST['name']); 
$table = prepSanitaryData($conn, $_POST['table']);
$inputField = prepSanitaryData($conn, $_POST['inputField']);
$reopen = prepSanitaryData($conn, $_POST['reopen']);


// Validate the inputs


// Add the field value
$queryFramework = <<<_END
    INSERT INTO $table (Name)
    VALUES (?)
_END;

$queryStmt = $conn->prepare($queryFramework);

$queryStmt->bind_param(
    "s", $name
);

$result = $queryStmt->execute();
if(!$result) echo $conn->error; //saveMsg("Could not add gift card; Error: $conn->error", 'failure', '../Views/Pages/card-add.php');
$fieldId = $conn->insert_id;

// Respond with the creator 'id' and 'name'

echo json_encode([
    'id' => $fieldId, 
    'name' => prepOutput($name), 
    'input_field' => $inputField, 
    'reopen' => $reopen
]);

$queryStmt->close();
$conn->close();
exit();