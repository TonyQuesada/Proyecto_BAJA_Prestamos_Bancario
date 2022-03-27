<?php
include 'conection.php';

$tsql_callSP = "{call Aprobar_Solicitud (?)}";
$tsql_callSP1 = "{call Rechazar_Solicitud (?)}";

if (isset($_POST['aprobar'])) {
    $solicitud = $_POST['num_soli'];

    $params = array(
        $solicitud
    );

    $stmt3 = sqlsrv_query($con, $tsql_callSP, $params);
    if ($stmt3 === false) {
        echo "Error in executing statement 3.\n";
        die(print_r(sqlsrv_errors(), true));
    }
} elseif (isset($_POST['rechazar'])) {
    $solicitud = $_POST['num_soli'];

    $params = array(
        $solicitud
    );
    $stmt3 = sqlsrv_query($con, $tsql_callSP1, $params);
    if ($stmt3 === false) {
        echo "Error in executing statement 3.\n";
        die(print_r(sqlsrv_errors(), true));
    }
}

//header("Location: analizar_solicitudes.php");
header("Location: analizar_solicitudes1.php");
?>