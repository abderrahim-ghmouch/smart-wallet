<?php  
include "../database.php";

$id = (int) $_POST["id"];
$destination = $_POST["destination"];
$amount = $_POST["amount"];
$description = $_POST["description"];
$date_expense = $_POST["date_expense"]; 

// UPDATE EXPENSES table with correct column names
$stmt = $db->prepare("UPDATE expenses SET destination = ?, amount = ?, description = ?, date_expense = ? WHERE id = ?");

$status = $stmt->execute([$destination, $amount, $description, $date_expense,$id]);

if ($status) {
    header("location: /expences.php");
    exit();
}

echo "Failed to update expense";