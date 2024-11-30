<?php

header('Content-Type: application/json');
require_once '../../config/dbauth.php';
require_once '../../helpers.php';

$conn = connect();


// Clean the inputs
// `prepSanitaryData()` comes from "helpers.php"
$name = prepSanitaryData($conn, $_POST['name']); 
$publisherType = prepSanitaryData($conn, $_POST['publisherType']); 


// Validate the inputs



// Add the "publisher"
$queryFramework = <<<_END
    INSERT INTO LIB_PUBLISHER (Name, PublisherTypeID)
    VALUES (?, ?)
_END;

$queryStmt = $conn->prepare($queryFramework);

$queryStmt->bind_param(
    "si", $name, $publisherType
);

$result = $queryStmt->execute();
if(!$result) echo $conn->error; //saveMsg("Could not add gift card; Error: $conn->error", 'failure', '../Views/Pages/card-add.php');
$publisherId = $conn->insert_id;

// Respond with the publisher 'id' and 'name'
echo json_encode(['id' => $publisherId, 'name' => htmlspecialchars($name)]);

$queryStmt->close();
$conn->close();
exit();