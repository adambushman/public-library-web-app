<?php

function formatISBN($isbn) {
    return preg_replace('/(\d{3})(\d{1})(\d{5})(\d{3})(\d{1})/', '$1-$2-$3-$4-$5', $isbn);
} 

function formatDate($date_str) {
    $date = new DateTime($date_str);
    return $date->format('F d, Y');
}

function prepSanitaryData($conn, $string) {
    // Trim leading/lagging white space, cariage returns, tabs, etc.
    $trimmed = trim($string);

    return $trimmed;
}

function createFullImgPath($uploadedFileName, $prefix) {
    $fileExtension = pathinfo($uploadedFileName, PATHINFO_EXTENSION); // Get the file extension
    $newImgName = uniqid($prefix, true) . '.' . $fileExtension; // Append the extension to the new name
    $imgPath = "ImageDirectory/$newImgName";
    return $imgPath;
}

function getAccountRoles($conn, $accountId) {
    $queryFramework = <<<_END
        SELECT lat.Name AS `Role`
        FROM LIB_ACCOUNT la
        INNER JOIN LIB_ACCOUNT_TYPE lat ON lat.AccountTypeID = la.AccountTypeID
        WHERE la.AccountID = 1
    _END;

    $queryStmt = $conn->prepare($queryFramework);
    $queryStmt->bind_param('i', $accountId);
    
    $queryStmt->execute();
    $result = $queryStmt->get_result();
    if(!$result) echo $conn->error;

    $result->data_seek(0);
    $accountRoles = array($result->fetch_array(MYSQLI_ASSOC)['Role']);
    $queryStmt->close();

    return $accountRoles;
}