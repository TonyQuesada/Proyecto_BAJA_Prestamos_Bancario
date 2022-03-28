<?php
// Uncomment next line if you're not using a dependency loader (such as Composer)
require_once 'sendgrid-php/sendgrid-php.php';

#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

use SendGrid\Mail\Mail;

$email = new Mail();
$email->setFrom("bancoangular@gmail.com", "Info BAJA");
$email->setSubject("ESTO ES UNA PRUEBA DE SENDGRID CON EL CORREO DEL BANCO");
$email->addTo("tonyquesadaxd@gmail.com", "Banco Angular Jerarquico Asociado");
$email->addContent("text/plain", "Hola esto es una prueba con SENDGRID CON EL CORREO DEL BANCO");
$email->addContent(
    "text/html", "<strong>Prueba exitosa con el correo BAJA</strong>"
);
$sendgrid = new \SendGrid(('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'));
try {
    $response = $sendgrid->send($email);
    echo "<pre>";
        print $response->statusCode() . "\n";
        print_r($response->headers());
        print $response->body() . "\n";
    echo "</pre>";
} catch (Exception $e) {
    echo 'Caught exception: '.  $e->getMessage(). "\n";
}