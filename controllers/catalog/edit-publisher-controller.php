<?php

require_once '../../config/dbauth.php';
require_once '../../helpers.php';

$conn = connect();
$publisherId = $_GET['publisherId'];


// Clean the inputs
// `prepSanitaryData()` comes from "helpers.php"
$name = prepSanitaryData($conn, $_POST['name']); 
$publisherType = prepSanitaryData($conn, $_POST['publisherType']); 


// Validate the inputs



// Add the "publisher"
$queryFramework = <<<_END
    UPDATE LIB_PUBLISHER
    SET
        Name = ?, 
        PublisherTypeID = ? 
    WHERE
        PublisherID = ?
_END;

$queryStmt = $conn->prepare($queryFramework);

$queryStmt->bind_param(
    "sii", $name, $publisherType, $publisherId
);

$result = $queryStmt->execute();
if(!$result) echo $conn->error; //saveMsg("Could not add gift card; Error: $conn->error", 'failure', '../Views/Pages/card-add.php');
$publisherId = $conn->insert_id;

header('Location: ../../views/pages/application-settings.php');

$queryStmt->close();
$conn->close();
exit();