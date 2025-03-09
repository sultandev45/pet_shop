<?php

// Replace this with your own email address
$to = 'mubashersultanmehmood@gmail.com';

function url(){
  return sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME']
  );
}

if($_POST) {
  require_once 'mailConfig.php';
    $name = trim(stripslashes($_POST['name']));
    $email = trim(stripslashes($_POST['email']));
    $subject = trim(stripslashes($_POST['subject']));
    $contact_message = trim(stripslashes($_POST['message']));
    
    if ($subject == '') { $subject = "Contact Form Submission"; }

    // Set Message
    $message = "Email from: " . $name . "<br />";
    $message .= "Email address: " . $email . "<br />";
    $message .= "Message: <br />";
    $message .= nl2br($contact_message);
    $message .= "<br /> ----- <br /> This email was sent from furever-homes " . url() . " contact form. <br />";

    // Set From: header
    $from =  $name . " <" . $email . ">";

    // Set mailer to use SMTP
    $mail->isSMTP();
    // Set From and Reply-To
    $mail->setFrom($email, $name);
    $mail->addReplyTo($email, $name);

    // Add recipient
    $mail->addAddress($to);

    // Email subject
    $mail->Subject = $subject;

    // Email body
    $mail->msgHTML($message);

    // Send the email
    if($mail->send()) {
        echo "OK";
    } else {
        echo "Something went wrong. Please try again.";
    }
}
?>
