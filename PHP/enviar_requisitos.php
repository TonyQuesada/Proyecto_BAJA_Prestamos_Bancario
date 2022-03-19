<?php

//librerias
include '../conection.php';
session_start();
setlocale(LC_TIME, "spanish");

require '../PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer();
$mail->Host = 'intelligent-hellman.138-59-135-33.plesk.page';
$mail->IsSMTP();
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Username = "TonyQuesadaxd@gmail.com";
$mail->Password = "Rock123456789";

$mail->setFrom('TonyQuesadaxd@gmail.com', 'Administración de BAJA');
$mail->addAddress(($_SESSION['u_Correo_electronico']), ($_SESSION['u_Nombre_Usuario']));
$mail->addReplyTo("TonyQuesadaxd@gmail.com", "Administración de BAJA");

$mail->isHTML(true);
$mail->Subject = 'Envío de email usando SMTP de Gmail';
$mail->Body = 'Hola que tal, esto es el cuerpo del mensaje!';
// $mail->MsgHTML("Hola que tal, esto es el cuerpo del mensaje!");


$mail->SMTPOptions = array(
    'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
   )
 );
//  $mail->SMTPDebug = 3;



if (!$mail->send()) {
    echo "Error al enviar: " . $mail->ErrorInfo;
} else {
    echo "Mensaje enviado!";
}


// $mail -> SMTPDebug = 2;
