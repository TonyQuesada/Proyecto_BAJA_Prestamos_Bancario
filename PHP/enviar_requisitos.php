<?php

//librerias
include '../conection.php';
session_start();
setlocale(LC_TIME, "spanish");

date_default_timezone_set('Amrerica/Costa Rica');
require_once '../PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->CharSet  = 'UTF-8';

$mail->Host = 'localhost';
$mail->Port = 25;
$mail->SMTPSecure = 'tls';
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer'  => true,
        'verify_depth' => 3,
        'allow_self_signed' => true,
        'peer_name' => 'Plesk',
    )
);

$mail->SMTPAuth = true;
$mail->Username = "TonyQuesadaxd@gmail.com";
$mail->Password = "Rock123456789";

$mail->setFrom('TonyQuesadaxd@gmail.com', 'Administración de BAJA');
$mail->addAddress(($_SESSION['u_Correo_electronico']), ($_SESSION['u_Nombre_Usuario']));
$mail->Subject = 'Envío de email usando SMTP de Gmail';
$mail->msgHTML('Email content with <strong>html</strong>');

// $mail->addReplyTo("TonyQuesadaxd@gmail.com", "Administración de BAJA");
// $mail->isHTML(true);
// $mail->Body = 'Hola que tal, esto es el cuerpo del mensaje!';
// $mail->MsgHTML("Hola que tal, esto es el cuerpo del mensaje!");


if (!$mail->send()) {
    echo "Error al enviar: " . $mail->ErrorInfo;
} else {
    echo "Mensaje enviado!";
}


// $mail -> SMTPDebug = 2;
