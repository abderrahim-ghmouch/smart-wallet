<?php
include_once "../database.php";

$destination = $_POST["destination"];
$amount = $_POST["amount"];
$description = $_POST["description"];
$date_income = $_POST["date_income"];

$stmt = $db->prepare("insert into incomes (destination,amount,description,date_income) values (?,?,?,?)");
$status = $stmt->execute([$destination,$amount,$description,$date_income]);


if ($status) {
     header("location: /incomes.php");
     exit();
 }

 echo "Faild Insert Income";    