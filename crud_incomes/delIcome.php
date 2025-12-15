<?php
include_once "../database.php";
$id=$_POST["id"];
$stmt = $db->prepare("delete from incomes where id=?");

$status = $stmt->execute([$id]);

if ($status) {
    header("location: /incomes.php");
    exit();
}

echo "Failed" ;

