<?php

$url = 'mysql:host=127.0.0.1;port=3306;dbname=registration;charset=utf8';

$user = 'root';
$password = '';

try {
    $database = new PDO($url, $user, $password);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed');
}