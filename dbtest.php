<?php 
error_reporting(E_ALL); 
ini_set("display_errors", 1); 
require __DIR__ . "/common/config/env.php";
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE . ";port=" . DB_DATABASE_PORT, DB_USER, DB_PASSWORD);
    echo "Database connection successful";
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage();
}

