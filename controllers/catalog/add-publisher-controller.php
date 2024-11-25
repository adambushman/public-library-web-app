<?php

require_once '../../config/dbauth.php';
$conn = connect();

// Add the publisher
$name = $_POST['name']; 
$publisherType = $_POST['publisherType']; 

$query = <<<_END
    INSERT INTO LIB_PUBLISHER (Name, PublisherTypeID) VALUES
    ('$name', $publisherType)
_END;

$result = $conn->query($query);
if(!$result) echo $conn->error; //saveMsg("Could not add gift card; Error: $conn->error", 'failure', '../Views/Pages/card-add.php');
$itemId = $conn->insert_id;

// Respond with the creator 'id' and 'name'
echo "{\"id\": $itemId, \"name\": \"$name\"}";