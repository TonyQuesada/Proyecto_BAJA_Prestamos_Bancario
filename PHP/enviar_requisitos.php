<?php

//librerias
include '../conection.php';
session_start();
setlocale(LC_TIME, "spanish");

$result = "";
require '../PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer();
//indico a la clase que use SMTP
$mail -> IsSMTP();
//permite modo debug para ver mensajes de las cosas que van ocurriendo
// $mail -> SMTPDebug = 2;
//Debo de hacer autenticación SMTP
$mail -> SMTPAuth = true;
$mail -> SMTPSecure = "tls";
//indico el servidor de Gmail para SMTP
$mail -> Host = "smtp.gmail.com";
//indico el puerto que usa Gmail
$mail -> Port = 587;
//
$mail -> isHTML(true);
//indico un usuario / clave de un usuario de gmail
$mail -> Username = "TonyQuesadaxd@gmail.com";
$mail -> Password = "Rock123456789";
$mail -> SetFrom('TonyQuesadaxd@gmail.com', 'Administración de BAJA');
$mail -> AddReplyTo("TonyQuesadaxd@gmail.com","Administración de BAJA");
$mail -> Subject = "Envío de email usando SMTP de Gmail";
$mail -> body = "Hola que tal, esto es el cuerpo del mensaje!";
//indico destinatario
$address = ($_SESSION['u_Correo_electronico']);
$mail-> AddAddress($address, ($_SESSION['u_Nombre_Usuario']));

if(!$mail-> Send()) {
echo "Error al enviar: " . $mail -> ErrorInfo;
} else {
echo "Mensaje enviado!";
}
