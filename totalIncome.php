<?php 

include_once __DIR__ . "/database.php";
$stmt = $db->query("select round(sum(amount), 2) as total from incomes", PDO::FETCH_ASSOC);
$total_Income = $stmt->fetchColumn(0);

?>