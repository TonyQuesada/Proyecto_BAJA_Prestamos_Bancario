<?php
include 'conection.php';
//session_start();
// if(isset($_SESSION['u_ID']))
// {
//     header('Location: administrador.php');
// }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="StyleSheet" href="estilos.css" type="text/css">
  <title>Análisis de solicitudes</title>
</head>

<body>

  <table class="table">
    <caption>ANÁLISIS DE SOLICITUDES DE CRÉDITO</caption>
    <thead tr>
      <th># Solicitud</th>

      <th>Fecha solicitud</th>

      <th>Identificación</th>

      <th>Nombre</th>

      <th>Tipo de préstamo</th>

      <th>Monto</th>

      <th>Cuota</th>

      <th>Nivel Endeudamiento</th>

      <th>Salario Neto</th>

      <th>Calificación SUGEF</th>

      <th>Respuesta</th>

      </tr>

    <tbody>
      <tr>
        <?php
        $query = "SELECT * FROM ANALIZAR_SOLICITUD";
        $ejecutar = sqlsrv_query($con, $query);
        $num_soli = 0;
        $fecha_soli = date_create("YYYY-MM-DD");
        $num_id = 0;
        $nombre = '';
        $tip_pres = '';
        $monto_sol = 0;
        $cuota = 0;
        $nivel_end = '';
        $salario_neto = 0;
        $cal_sugef = '';


        while ($fila = sqlsrv_fetch_array($ejecutar)) {
          $num_soli = $fila['#_SOLICITUD'];
          $fecha_soli = $fila['FECHA_DE_SOLICITUD'];
          $num_id = $fila['IDENTIFICACION'];
          $nombre = $fila['NOMBRE'];
          $tip_pres = $fila['TIPO_DE_PRESTAMO'];
          $monto_sol = $fila['MONTO_SOLICITADO'];
          $cuota = $fila['CUOTA'];
          $nivel_end = $fila['NIVEL_ENDEUDAMIENTO'];
          $salario_neto = $fila['SALARIO_NETO'];
          $cal_sugef = $fila['CALIFICACION_SUGEF'];

          echo '
              <th>' . $num_soli . '</th>
              <td>' . date_format($fecha_soli, "d-m-Y") . '</td>
              <td>' . $num_id . '</td>
              <td>' . $nombre . '</td>
              <td>' . $tip_pres . '</td>
              <td>' . $monto_sol . '</td>
              <td>' . $cuota . '</td>
              <td>' . $nivel_end . ' %</td>
              <td>¢ ' . $salario_neto . '</td>
              <td>' . $cal_sugef . '</td>
              <td><input type="submit" name="" value="APROBAR" id="boton1" onclick = "funcion();">
              <input type="submit" name="" value="RECHAZAR" id="boton1" onclick = "funcion();"></td>
              </tr>';
        }
        ?>
    <tbody>
  </table>
</body>

</html>