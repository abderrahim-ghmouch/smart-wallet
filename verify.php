<?php
session_start();
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* 1️⃣ Generate + send OTP ONLY ONCE */
if (!isset($_SESSION["otp"])) {

    $otp = random_int(10000, 99999);
    $_SESSION["otp"] = $otp;

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = "abderrahimghmouch47@gmail.com";
        $mail->Password = "neie yupe szud vjim"; // ⚠️ move to env later
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom("abderrahimghmouch47@gmail.com", 'OTP System');
        $mail->addAddress($_SESSION["email"]);

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "<h2>Your OTP is: <b>$otp</b></h2>";

        $mail->send();
    } catch (Exception $e) {
        echo $mail->ErrorInfo;
        exit;
    }
}

/* 2️⃣ Verify OTP ONLY when form is submitted */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $otprecive = $_POST["validotp"] ?? '';

    if ($otprecive == $_SESSION["otp"]) {
        unset($_SESSION["otp"]); // destroy OTP
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid code";
    }
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