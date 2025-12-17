<?php

require_once __DIR__ . "/../database.php";


try{

    $username=$_POST["username"];

    $email=$_POST["email"];

    $password=$_POST["password"];

    $hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt= $db->prepare("insert into users(name,email,password) values(?, ?, ?);");

    $status = $stmt->execute([$username, $email, $hash]);

    if($status)
    {
        header("location: /login.php");
        exit();
    }

}
catch( PDOException $e){
    echo $e->getmessage();
}

?>