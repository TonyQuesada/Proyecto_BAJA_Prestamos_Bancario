<?php
include 'conection.php';


$tsql_callSP = "{call Asignar_Solicitudes(?, ?)}";
//$solicitud = 4;
if (isset($_POST['asignar'])) {
    $analista = $_POST['analistas'];
    $solicitud = $_POST['num_soli'];
}

$params = array(
        $solicitud,
        $analista
    );

echo "Id Analista: " . $analista . "<br>";
echo "Solicitud: " . $solicitud . "<br>";


    /*
    $stmt3 = sqlsrv_query($con, $tsql_callSP, $params);
    if ($stmt3 === false) {
        echo "Error in executing statement 3.\n";
        die(print_r(sqlsrv_errors(), true));
    }

    header("Location: asignar_solicitudes1.php");
    */





    
    // NOTAAAAAA

    // <a href='asignar_solicitud.php?num_soli=$num_soli&analistas=$analistas'>Enviar variables</a>

    // $analista = $_GET['analistas'];
    // $solicitud = $_GET['num_soli'];


 ?>   

