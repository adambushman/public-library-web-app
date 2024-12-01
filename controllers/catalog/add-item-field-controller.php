<?php

require_once '../../config/dbauth.php';
require_once '../../helpers.php';

$conn = connect();

// Clean the inputs
// `prepSanitaryData()` comes from "helpers.php"
$name = prepSanitaryData($conn, $_POST['name']); 
$table = prepSanitaryData($conn, $_POST['table'] ?? '');
$inputField = prepSanitaryData($conn, $_POST['inputField'] ?? '');
$reopen = prepSanitaryData($conn, $_POST['reopen'] ?? '');


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

$queryStmt->execute();
$result = $queryStmt->get_result();
if(!$result) echo $conn->error; //saveMsg("Could not add gift card; Error: $conn->error", 'failure', '../Views/Pages/card-add.php');
$fieldId = $conn->insert_id;

// Respond with the creator 'id' and 'name'
if(count(array_intersect([''], [$name, $inputField, $reopen])) > 0) {
    header('Location: ../../views/pages/application-settings.php');
} else {
    echo json_encode([
        'id' => $fieldId, 
        'name' => htmlspecialchars($name), 
        'input_field' => $inputField, 
        'reopen' => $reopen
    ]);
}

$queryStmt->close();
$conn->close();
exit();