<?php
include 'conection.php';


$tsql_callSP = "{call Asignar_Solicitudes(?, ?)}";
$solicitud = 4;
if (isset($_POST['asignar'])) {
    $analista = $_POST['analistas'];
}

$params = array(
        $solicitud,
        $analista
    );

    $stmt3 = sqlsrv_query($con, $tsql_callSP, $params);
    if ($stmt3 === false) {
        echo "Error in executing statement 3.\n";
        die(print_r(sqlsrv_errors(), true));
    }

    header("Location: asignar_solicitudes1.php");;
 ?>   