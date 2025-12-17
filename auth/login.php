<?php

require_once __DIR__ . "/../database.php";
session_start();

try{


    $email=$_POST["email"];

    $password=$_POST["password"];

   $stmt= $db->prepare("select * from users where email=?;");
   $stmt->execute([$email]);

   if($stmt->rowCount() === 1){
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if(password_verify($password, $user["password"])){
            $_SESSION["user_id"] = $user["id"];
            header("location: /index.php");
            exit();
        }else{
            $_SESSION["error"] = "Invalid";
            header("location: /login.php");
            exit();
        }
   }else{
        $_SESSION["error"] = "Invalid";
        header("location: /login.php");
        exit();
   }

}
catch( PDOException $e){
    echo $e->getmessage();
}

?>