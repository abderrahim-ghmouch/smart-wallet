<?php 

include_once __DIR__ . "/database.php";

$stmt = $db->prepare("select round(sum(amount), 2) as total from incomes where card_id = ?");
$stmt->execute([$_SESSION["card_id"]]);
$total_Income = $stmt->fetchColumn(0);

?>