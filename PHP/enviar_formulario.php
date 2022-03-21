<?php

include '../conection.php';
session_start();
setlocale(LC_TIME, "spanish");

$sesionRol = null;
if (isset($_SESSION['u_idRol'])) {
    $sesionRol = $_SESSION['u_idRol'];
}

echo "id_Identificacion: " . $_SESSION['id_id'];
echo '<br>';
echo  "ID: " . $_POST['cedulaForm'];
echo '<br>';
echo "nombre: " . $_POST['nombreForm'];
echo '<br>';
echo "apellido 1: " . $_POST['ape1Form'];
echo '<br>';
echo "apellido 2: " . $_POST['ape2Form'];
echo '<br>';
echo  "Correo: " . $_POST['email'];
echo '<br>';
echo "id_Cate: " . $_SESSION['id_Categoria_Prestamo_final'];
echo '<br>';
echo "id_Tipo: " . $_SESSION['id_Tipo_Prestamo_final'];
echo '<br>';
echo "monto_solicita: " . $_SESSION['monto_solicita_final'];
echo '<br>';
echo "range: " . $_SESSION['range_final'];
echo '<br>';
echo "cuota_mensual_natural: " . $_SESSION['cuota_mensual_natural_final'];
echo '<br>';
echo '<br>';
echo 'EXTRAS:';
echo '<br>';
echo "tasa: " . $_SESSION['tasa_final'];
echo '<br>';
echo "cuota_mensual: " . $_SESSION['cuota_mensual_final'];
echo '<br>';
echo "moneda: " . $_SESSION['moneda_final'];
echo '<br>';
echo "Fecha que ve el usuario: " . strftime("%A, %d de %B de %Y");


$_SESSION['cedulaFormulario'] = $_POST['cedulaForm'];
$_SESSION['nombreFormulario'] = $_POST['nombreForm'];
$_SESSION['apellido1Formulario'] = $_POST['ape1Form'];
$_SESSION['apellido2Formulario'] = $_POST['ape2Form'];
$_SESSION['emailFormulario'] = $_POST['email'];
$_SESSION['fechaFormulario'] = strftime("%A, %d de %B de %Y");

$params = array(

    $_SESSION['id_id'],
    $_POST['cedulaForm'],
    $_POST['nombreForm'],
    $_POST['ape1Form'],
    $_POST['ape2Form'],
    $_POST['email'],
    $_SESSION['id_Categoria_Prestamo_final'],
    $_SESSION['id_Tipo_Prestamo_final'],
    $_SESSION['monto_solicita_final'],
    $_SESSION['range_final'],
    $_SESSION['cuota_mensual_natural_final']

);


$procedure_call = "{call Ingresar_Clientes(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";

$query = sqlsrv_query( $con, $procedure_call, $params);
if( $query == false)
{
        header("Location:../Prestamos/recibo.php#recibo");
    } else {
        echo "<script>alert('Error al intentar ingresar la solicitud de préstamo.')</script>";
         header("Location:../index.php");
    }

?>
