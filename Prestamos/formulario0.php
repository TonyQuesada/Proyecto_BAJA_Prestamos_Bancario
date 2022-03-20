<?php

include '../conection.php';
session_start();
setlocale(LC_TIME, "spanish");

// Obtener el Tipo de Cambio //
$consulta = "SELECT * FROM Tipo_Cambio";
$ejecutar = sqlsrv_query($con, $consulta);
$compra = 0;
$venta = 0;
$i = 0;
while ($fila = sqlsrv_fetch_array($ejecutar)) {
    $Nombre_Tipo = $fila['Nombre_Tipo'];
    $Monto = $fila['Monto'];
    if ($i == 0) {
        $compra = $fila['Monto'];
    } else {
        $venta = $fila['Monto'];
    }
    $i++;
}

$sesionRol = null;
if (isset($_SESSION['u_idRol'])) {
    $sesionRol = $_SESSION['u_idRol'];
}

// Busca a la persona //
$cedula = '';
$id_id = '';
$nombre = '';
$ape1 = '';
$ape2 = '';
$sesion_idCliente = '';
$correo = '';

if (isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];
}

if (isset($_SESSION['u_idCliente']) && ($cedula == NULL)) {

    $cedula = $_SESSION['u_idCliente'];

    $datos = json_decode(file_get_contents("http://aaron040291-001-site1.ctempurl.com/api/Personas/" . $cedula), true);

    if ($datos == '') {
        $noExiste = 'Número de identificación de la sesión incorrecto.';
        echo $noExiste;
    } else {
        $cedula = $datos["CEDULA"];
        $nombre = $datos["NOMBRE_COMPLETO"];
        $ape1 = $datos["PRIMER_APELLIDO"];
        $ape2 = $datos["SEGUNDO_APELLIDO"];
        $correo = $_SESSION['u_Correo_electronico'];

        $id_id_cantidad = strlen(str_replace(",", "", number_format($cedula)));
        if($id_id_cantidad == 9){
            $id_id = 1;
        } else {
            $id_id = 2;
        }
    }
} else if ($cedula != NULL) {

    if (isset($_POST['cedula'])) {

        $cedula = preg_replace('/[^0-9.]+/', '', $_POST['cedula']);

        $datos = json_decode(file_get_contents("http://aaron040291-001-site1.ctempurl.com/api/Personas/" . $cedula), true);

        if ($datos == '') {
            $noExiste = 'Número de identificación incorrecta.';
            echo $noExiste;
        } else {
            $cedula = $datos["CEDULA"];
            $nombre = $datos["NOMBRE_COMPLETO"];
            $ape1 = $datos["PRIMER_APELLIDO"];
            $ape2 = $datos["SEGUNDO_APELLIDO"];
        }
        
        $id_id_cantidad = strlen(str_replace(",", "", number_format($cedula)));
        if($id_id_cantidad == 9){
            $id_id = 1;
        } else {
            $id_id = 2;
        }
    }
} else {

    $noExiste = 'Ingrese un número de identificación porfavor.';
    echo $noExiste;
}

// Conserva los datos de la calculadora
if (isset($_POST['monto_solicita_col']) or isset($_POST['monto_solicita_dol'])) {

    $monto_solicita_col = $_POST['monto_solicita_col'];
    $monto_solicita_dol = $_POST['monto_solicita_dol'];
    $mon = '';

    if ($monto_solicita_dol == NUll) {
        $mon = 'col';
    } else {
        $mon = 'dol';
    }

    $monto_solicita_ = 'monto_solicita_' . $mon;
    $range_ = 'range_' . $mon;
    $tasa_ = 'tasa_' . $mon;
    $cuota_mensual_ = 'cuota_mensual_' . $mon;
    $moneda_ = 'moneda_' . $mon;
    $cuota_mensual_natural_ = 'cuota_mensual_natural_' . $mon;
    $id_Categoria_Prestamo = 'id_Categoria_Prestamo';
    $id_Tipo_Prestamo = 'id_Tipo_Prestamo';

    $_SESSION['monto_solicita_final'] = $_POST[$monto_solicita_];
    $_SESSION['range_final'] = $_POST[$range_];
    $_SESSION['tasa_final'] = $_POST[$tasa_];
    $_SESSION['cuota_mensual_final'] = $_POST[$cuota_mensual_];
    $_SESSION['moneda_final'] = $_POST[$moneda_];
    $_SESSION['cuota_mensual_natural_final'] = $_POST[$cuota_mensual_natural_];
    $_SESSION['id_Categoria_Prestamo_final'] = $_POST[$id_Categoria_Prestamo];
    $_SESSION['id_Tipo_Prestamo_final'] = $_POST[$id_Tipo_Prestamo];
}


echo "monto_solicita: " . $_SESSION['monto_solicita_final'];
echo '<br>';
echo "range: " . $_SESSION['range_final'];
echo '<br>';
echo "tasa: " . $_SESSION['tasa_final'];
echo '<br>';
echo "cuota_mensual: " . $_SESSION['cuota_mensual_final'];
echo '<br>';
echo  "ID: " . $cedula;
echo '<br>';
echo  "Correo: " . $correo;
echo '<br>';
echo "moneda: " . $_SESSION['moneda_final'];
echo '<br>';
echo "id_Identificacion: " . $id_id;
echo '<br>';
echo "id_Cate: " . $_SESSION['id_Categoria_Prestamo_final'];
echo '<br>';
echo "id_Tipo: " . $_SESSION['id_Tipo_Prestamo_final'];
echo '<br>';
echo "cuota_mensual_natural: " . $_SESSION['cuota_mensual_natural_final'];
echo '<br>';
echo "Fecha que ve el usuario: " . strftime("%A, %d de %B de %Y");
echo '<br>';
echo "Fecha que guarda la base: " . strftime("%Y-%m-%d");
// echo ' --- ';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <H1>Formulario</H1>

    <form method="POST">
        <p>Número de identificación:<input type="text" name="cedula">
            <input type="submit" value="Consultar">
        </p>
    </form>
    <p>Cédula: <input type='text' name="cedula" id="cedula" readonly value='<?php echo ($cedula); ?>' />
        Nombre: <input type='text' name="nombre" id="nombre" readonly value='<?php echo $_SESSION['nombre_formu'] ?>' />
        Primer Apellido: <input type='text' name="ape1" id="ape1" readonly value='<?php echo $_POST['email'] ?>' />
        Segundo Apellido: <input type='text' name="ape2" id="ape2" readonly value='<?php echo ($ape2); ?>' />
    </p>
</body>

</html>