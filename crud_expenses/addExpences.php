<?php
session_start();
include_once "../database.php";

$destination = $_POST["destination"];  
$amount = (int) $_POST["amount"];
$description = $_POST["description"];
$date_expense = $_POST["date_expense"];  


$stmt = $db->prepare("select sum(amount) from expenses where destination = ? and card_id = ? and Month(date_expense) = Month(NOW())");
$stmt->execute([$destination, $_SESSION["card_id"]]);
$total_Expenses = $stmt->fetchColumn(0) + $amount;

//enum('shoping','food','bills','transport','trips')

if(
    ($destination === "shoping" && $total_Expenses >= 1500)
    || ($destination === "food" && $total_Expenses >= 500)
    || ($destination === "bills" && $total_Expenses >= 300)
    || ($destination === "transport" && $total_Expenses >= 250)
    || ($destination === "trips" && $total_Expenses >= 600)
    ){
        
        $_SESSION["error"] = "tu a depacer le limit de cette category";
        header("Location: /expences.php");
        exit();
}



// Insert into expenses table with YOUR column names
$stmt = $db->prepare("INSERT INTO expenses (destination, amount, description, date_expense, card_id) VALUES (?, ?, ?, ?, ?)");
$status = $stmt->execute([$destination, $amount, $description, $date_expense, $_SESSION["card_id"]]);

if ($status) {
    header("location: ../expences.php");
    exit();
}

echo "Failed to insert expense";