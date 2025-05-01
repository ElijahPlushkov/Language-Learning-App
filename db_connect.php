<?php

$config = require dirname(__DIR__) . '/language app/config.php';

$conn = new mysqli(
    $config['db_host'],
    $config['db_name'],
    $config['db_password'],
    $config['db_username']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");