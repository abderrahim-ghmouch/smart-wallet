<?php
include_once "../database.php";
$id=$_POST["id"];
$stmt = $db->prepare("delete from expenses where id=?");
$status = $stmt->execute([$id]);

if ($status) {
    header("location: /expences.php");
    exit();
}

echo "Failed delete expences" ;
