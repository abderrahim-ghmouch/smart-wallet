<?php
include_once __DIR__ . "/database.php";

$stmt = $db->query("select round(sum(amount), 2) as total from expenses", PDO::FETCH_ASSOC);
$total_Expenses = $stmt->fetchColumn(0);

?>