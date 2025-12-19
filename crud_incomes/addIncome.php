<?php
session_start();
include_once "../database.php";

$destination = $_POST["destination"];
$amount = $_POST["amount"];
$description = $_POST["description"];
$date_income = $_POST["date_income"];
$card_id  = $_SESSION["card_id"];

$stmt = $db->prepare("insert into incomes (destination,amount,description,date_income,card_id) values (?,?,?,?,?)");
$status = $stmt->execute([$destination,$amount,$description,$date_income,$card_id]);


if ($status) {
     header("location: /incomes.php");
     exit();
 }

 echo "Faild Insert Income";    