<?php

require_once '../../config/dbauth.php';
$conn = connect();

// Add the new field
$name = $_POST['name']; 
$table = $_POST['table'];
$inputField = $_POST['inputField'];
$reopen = $_POST['reopen'];

$query = <<<_END
    INSERT INTO $table (Name) VALUES
    ('$name')
_END;

$result = $conn->query($query);
if(!$result) echo $conn->error; //saveMsg("Could not add gift card; Error: $conn->error", 'failure', '../Views/Pages/card-add.php');
$itemId = $conn->insert_id;

// Respond with the creator 'id' and 'name'
echo "{\"id\": $itemId, \"name\": \"$name\", \"input_field\": \"$inputField\", \"reopen\": \"$reopen\"}";