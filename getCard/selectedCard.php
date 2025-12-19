<?php

session_start();

$_SESSION["card_id"] = (int) $_POST["id"];

header("location: /cards.php");

exit();




