<?php

$hn = 'localhost:3306';
$db = 'LibraryDB';
$un = 'root';
$pw = '';

function connect() {
    global $hn, $un, $pw, $db;
    $conn = new mysqli($hn, $un, $pw, $db);
    if($conn->connect_error) die($conn->connect_error);
    return $conn;
};