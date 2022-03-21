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
  <title>Document</title>
</head>

<body>

  <table class="default">
    <h2>SOLICITUDES DE CRÉDITO TRAMITADAS</h2>
    <tr>
      <th># Solicitud</th>

      <th>Fecha solicitud</th>

      <th>Feha de respuesta</th>

      <th>Identificación</th>

      <th>Categoría</th>

      <th>Tipo de préstamo</th>

      <th>Moneda</th>

      <th>Monto</th>

      <th>Tasa</th>

      <th>Cuota</th>

      <th>Plazo</th>

      <th>Estado</th>

      <th>Analista</th>

    </tr>

    <tr>
      <?php
      $query = "SELECT * FROM VER_SOLICITUDES_TRAMITADAS";
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
      $estado = '';
      $analista = '';
      while ($fila = sqlsrv_fetch_array($ejecutar)) {
        $num_soli = $fila['NUMERO_SOLICITUD'];
        $fecha_soli = $fila['FECHA_DE_SOLICITUD'];
        $fecha_resp = $fila['FECHA_DE_RESPUESTA'];
        $num_id = $fila['NUMERO_IDENTIFICACION'];
        $cat_pres = $fila['CATEGORÍA_PRESTAMO'];
        $tip_pres = $fila['TIPO_DE_PRESTAMO'];
        $moneda = $fila['MONEDA'];
        $monto_sol = $fila['MONTO_SOLICITADO'];
        $tasa = $fila['TASA_DE_INTERES'];
        $cuota = $fila['CUOTA_MENSUAL'];
        $plazo = $fila['PLAZO_EN_ANIOS'];
        $estado = $fila['ESTADO_ACTUAL'];
        $analista = $fila['ANALISTA'];

        echo '
              <td>' . $num_soli . '</td>
              <td>' . date_format($fecha_soli, "Y-m-d") . '</td>
              <td>' . date_format($fecha_resp, "Y-m-d") . '</td>
              <td>' . $num_id . '</td>
              <td>' . $cat_pres . '</td>
              <td>' . $tip_pres . '</td>
              <td>' . $moneda. '</td>
              <td>' . $monto_sol. '</td>
              <td>' . $tasa. '</td>
              <td>' . $cuota . '</td>
              <td>' . $plazo . '</td>
              <td>' . $estado . '</td>
              <td>' . $analista . '</td>
              </tr>';
      }
      ?>
  </table>
</body>

</html>