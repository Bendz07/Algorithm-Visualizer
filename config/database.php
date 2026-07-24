<?php
// Database connection - hardcoded for XAMPP
$host = 'localhost';
$db   = 'algorithm_visualizer';
$user = 'root';
$pass = ''; // XAMPP default is empty password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

return $pdo;
?>