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
  <title>Vista general de solicitudes</title>
</head>

<body>

  <table class="table">
    <caption>VISTA GENERAL DE SOLICITUDES DE CRÉDITO</caption>
    <thead tr>
      <th># Solicitud</th>

      <th>Fecha de solicitud</th>

      <th>Identificación</th>

      <th>Categoría</th>

      <th>Tipo de préstamo</th>

      <th>Moneda</th>

      <th>Monto</th>

      <th>Tasa</th>

      <th>Cuota</th>

      <th>Plazo</th>

      <th>Terminos</th>

      <th>Estado Actual</th>

    </tr>

    <tbody>
    <tr>
      <?php
      $query = "SELECT * FROM VER_SOLICITUDES_TOTALES";
      $ejecutar = sqlsrv_query($con, $query);
      $num_soli = 0;
      $fecha_soli = date_create("YYYY-MM-DD");
      $fecha_resp = date_create("YYYY-MM-DD");
      $num_id = 0;
      $cat_pres = '';
      $tip_pres = '';
      $moneda = '';
      $monto_sol = 0;
      $tasa = 0;
      $cuota = 0;
      $plazo = 0;
      $terminos = '';
      $estado = '';
      $i = 0;
      while ($fila = sqlsrv_fetch_array($ejecutar)) {
        $num_soli = $fila['NUMERO_SOLICITUD'];
        $fecha_soli = $fila['FECHA_DE_SOLICITUD'];
        $num_id = $fila['NUMERO_IDENTIFICACION'];
        $cat_pres = $fila['CATEGORÍA_PRESTAMO'];
        $tip_pres = $fila['TIPO_DE_PRESTAMO'];
        $moneda = $fila['MONEDA'];
        $monto_sol = $fila['MONTO_SOLICITADO'];
        $tasa = $fila['TASA_DE_INTERES'];
        $cuota = $fila['CUOTA_MENSUAL'];
        $plazo = $fila['PLAZO_EN_ANIOS'];
        $terminos = $fila['TERMINOS_CONDICIONES'];
        $estado = $fila['ESTADO_ACTUAL'];

        echo '
              <th>' . $num_soli . '</th>
              <td>' . date_format($fecha_soli, "d-m-Y"). '</td>
              <td>' . $num_id . '</td>
              <td>' . $cat_pres . '</td>
              <td>' . $tip_pres. '</td>
              <td>' . $moneda . '</td>
              <td>' . $monto_sol . '</td>
              <td>' . $tasa. ' %</td>
              <td>' . $cuota . '</td>
              <td>' . $plazo . '</td>
              <td>' . $terminos . '</td>
              <td>' . $estado . '</td>
              </tr>';
      }
      ?>
      <tbody>
  </table>
</body>

</html>