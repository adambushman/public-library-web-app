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