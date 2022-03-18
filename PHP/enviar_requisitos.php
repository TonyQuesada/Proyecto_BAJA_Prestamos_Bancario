<?php

//librerias
include '../conection.php';
session_start();
setlocale(LC_TIME, "spanish");

require_once ('../PHPMailer/PHPMailerAutoload.php');

$mail = new PHPMailer();
//indico a la clase que use SMTP
$mail -> IsSMTP();
//permite modo debug para ver mensajes de las cosas que van ocurriendo
$mail -> SMTPDebug = 2;

$mail -> $smtp_debug = true;

//Debo de hacer autenticación SMTP
$mail -> SMTPAuth = true;
$mail -> SMTPSecure = "ssl";
//indico el servidor de Gmail para SMTP
$mail -> Host = "smtp.gmail.com";
//indico el puerto que usa Gmail
$mail -> Port = 465;
//indico un usuario / clave de un usuario de gmail
$mail -> Username = "TonyQuesadaxd@gmail.com";
$mail -> Password = "Rock123456789";
$mail -> SetFrom('TonyQuesadaxd@gmail.com', 'Administración de BAJA');
$mail -> AddReplyTo("TonyQuesadaxd@gmail.com","Administración de BAJA");
$mail -> Subject = "Envío de email usando SMTP de Gmail";
$mail -> MsgHTML("Hola que tal, esto es el cuerpo del mensaje!");
//indico destinatario
$address = ($_SESSION['u_Correo_electronico']);
$mail-> AddAddress($address, ($_SESSION['u_Nombre_Usuario']));
if(!$mail-> Send()) {
echo "Error al enviar: " . $mail -> ErrorInfo;
} else {
echo "Mensaje enviado!";
}
