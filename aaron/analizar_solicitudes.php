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
    <h2>ANÁLISIS DE SOLICITUDES</h2>
    <tr>
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

      <th>Asignación</th>

    </tr>

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

      $query2 = "SELECT * FROM VER_ANALISTAS";
      $ejecutar2 = sqlsrv_query($con, $query2);
      $nom_ana = '';

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
              <td>' . $num_soli . '</td>
              <td>' . date_format($fecha_soli, "Y-m-d") . '</td>
              <td>' . $num_id . '</td>
              <td>' . $nombre . '</td>
              <td>' . $tip_pres . '</td>
              <td>' . $monto_sol . '</td>
              <td>' . $cuota . '</td>
              <td>' . $nivel_end . '</td>
              <td>' . $salario_neto . '</td>
              <td>' . $cal_sugef . '</td>

              <td><select name="analistas">
              <option selected disabled hidden>SELECCIONE EL ANALISTA</option>';

              while ($fila2 = sqlsrv_fetch_array($ejecutar2)) {
                echo '
                          <option value="' . $fila2['ID_ANALISTA'] . '">' . $fila2['NOMBRE_ANALISTA'] . '</option>';
              }
              echo '
              </select></td>
              </tr>';
      }
      ?>
  </table>
</body>

</html>