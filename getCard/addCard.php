<?php 

session_start();
require_once __DIR__ . "/../database.php";

$bankname=$_POST["bank"];
$card_number=$_POST["card_number"];
$cvc=$_POST["cvc_code"];
$id = $_SESSION["user_id"];

$stmt = $db->prepare("insert into cards(bank,card_number,cvc,user_id) values (?,?,?,?)");
$status = $stmt->execute([$bankname,$card_number,$cvc, $id]);

if($status)
    {
        header("location: /cards.php");
    }