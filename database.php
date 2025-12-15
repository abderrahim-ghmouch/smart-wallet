<?php
$host = "localhost";      
$dbname = "smart_wallet";
$username = "abdo";      
$password = "abdoabdo";

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
