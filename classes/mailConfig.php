<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoload file
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Create a new PHPMailer instance
$mail = new PHPMailer();


    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';  // Specify SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'smehmat402@gmail.com';  // SMTP username
    $mail->Password   = 'rzsw jorl wbuw pqdd';    // SMTP password
    $mail->SMTPSecure = 'tls';               // Enable TLS encryption; `ssl` also accepted
    $mail->Port       = 587; ?>