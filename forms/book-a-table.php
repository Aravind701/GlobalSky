<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
ini_set('display_errors', '1');

//Load Composer's autoloader
require '../vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer();

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'kishorejohnp@gmail.com';                     //SMTP username
    $mail->Password   = 'dcjgoipxrvivbckz';                               //SMTP password
    $mail->SMTPSecure = 'TLS';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('kishorejohnp@gmail.com', 'Global Sky');
    $mail->addAddress("globalskybiz@gmail.com", $_POST['name']);     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $replacements = array(
      ':MESSAGE' => ($_POST['message'] != '') ? $_POST['message'] : 'This is a custom message.',
      ':NAME' =>  $_POST['name'],
      ':EMAIL' =>  $_POST['email'],
      ':PHONE' =>  $_POST['phone'],
  );
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $_POST['subject'];
    $mail->Body    = str_replace(array_keys($replacements), $replacements, file_get_contents('mail.html'));
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    // echo 'Message has been sent';
    // echo json_encode(['status'=>200, "message"=> "ok"]);
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>