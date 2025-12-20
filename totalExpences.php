<?php
include_once __DIR__ . "/database.php";

$stmt = $db->prepare("select round(sum(amount), 2) as total from expenses where card_id = ?");
$stmt->execute([$_SESSION["card_id"]]);
$total_Expenses = $stmt->fetchColumn(0);

?>