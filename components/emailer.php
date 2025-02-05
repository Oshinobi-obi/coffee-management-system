<?php
include_once '../admin/placed_orders.php';

if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    //Server settings                                 
    $mail->isSMTP();                                      
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;                               
    $mail->Username = 'loristaste@gmail.com';                 
    $mail->Password = 'fhuegseonfornykn';                           
    $mail->SMTPSecure = 'tls';                            
    $mail->Port = 587;                                   

    //Recipients
    $mail->setFrom('loristaste@gmail.com');
    if(isset($_SESSION['email'])) {
        $mail->addAddress($_SESSION['email']); 
        $mail->isHTML(true);
        if(isset($_SESSION['name'], $_SESSION['total_products'])) {
            $mail->Subject = 'Your order is ready and to be delivered!';
            $mail->Body    = 'Hey <b>'.$_SESSION['name'].'</b>! your ' . '<b>' . $_SESSION['total_products'] . '</b>' . ' is ready to be delivered! Please wait for our delivery rider to arrive. Please prepare exact payment.';
            $mail->AltBody = '';
        }                                  
        $mail->send();
        echo 'Message has been sent';
    }
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
?>