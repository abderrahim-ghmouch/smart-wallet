<?php 

session_start();



$otp= random_int(10000,99999);


$_SESSION["otp"] = $otp;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require 'vendor/autoload.php';

//Create an instance; passing true enables exceptions
$mail = new PHPMailer(true);

  try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = "abderrahimghmouch47@gmail.com";
        $mail->Password = "neie yupe szud vjim";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom("abderrahimghmouch47@gmail.com", 'OTP System');
        $mail->addAddress($_SESSION["email"]);

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "<h2>Your OTP is: <b>$otp</b></h2>";
        $mail->SMTPOptions = [
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true,
    ],
];

        $mail->send();
    } catch (Exception $e) {
        echo $mail->ErrorInfo;
    } 



?> 
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <script src="https://cdn.tailwindcss.com"></script>
    <title>login</title>
</head>

<body class="bg-gray-200 flex items-center justify-center ">

  <form  method="POST" action="verify.php" class="bg-white w-800 h-auto p-6 rounded-lg shadow-md flex flex-col gap- items-center flex flex-cols gap-8 justify-evenly">

      <label class="text-lg font-semibold">
        Check your inbox
      </label>
<input  name="validotp"
        class="border-2 border-gray-700 h-12 w-200 px-3 rounded"
        placeholder="Enter your code">
<button class="bg-gray-800 hover:bg-gray-600 h-20 w-60">confirm</button>
</form> 

</body>
</html>