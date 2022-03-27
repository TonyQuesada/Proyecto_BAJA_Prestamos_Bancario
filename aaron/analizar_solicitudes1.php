<?php
include 'conection.php';
//session_start();
// if(isset($_SESSION['u_ID']))
// {
//     header('Location: administrador.php');
// }
?>
 <h2>ANÁLISIS DE SOLICITUDES DE CRÉDITO</h2>
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

    while ($fila = sqlsrv_fetch_array($ejecutar)){
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

?>
<form action="respuesta_solicitud.php" method="POST" name="input">
<div style="width:100%;height: 300px;; border:0px solid blue; margin-bottom:10px; padding:10px
;">
<div style="width: 15%;height:320px; border:0px solid blue; position:relative; float:left;">
<img src="5.png">
</div>
<div style="width: 25%;height:320px; border:0px solid blue; position:relative; float:left;">
    <br>
    <h3>DATOS DE LA SOLICITUD</h3>
    <h3> # Solicitud: <?php echo $num_soli; ?></h3>
    <h3> Fecha de solicitud: <?php echo date_format($fecha_soli, "d-m-Y"); ?></h3>
    <h3>Tipo de préstamo: <?php echo $tip_pres; ?></h3>
    <h3>Monto Solicitado: <?php echo $monto_sol; ?></h3>
    <h3>Cuota: <?php echo $cuota; ?></h3>
    <input id="num_soli" type="hidden" name="num_soli" value="<?php echo $num_soli; ?>" /><br />
    </div>
    <div style="width: 25%;height:320px; border:0px solid blue; position:relative; float:left;">
    <br>
    <h3>DATOS DEL CLIENTE</h3>
    <h3> Identificación: <?php echo $num_id;?></h3>
    <h3>Nombre: <?php echo $nombre; ?></h3>
    <h3>Nivel de endeudamiento: <?php echo $nivel_end; ?>%</h3>
    <h3>Salario Neto: ¢<?php echo $salario_neto; ?></h3>
    <h3>Calificación SUGEF: <?php echo $cal_sugef; ?></h3>
    </div>
    <div style="width: 30%;height:320px; border:0px solid blue; position:relative; float:left;">
    <br>
    <h3>RESPUESTA SOLICITUD</h3>
    <input type="submit" name="aprobar" value="APROBAR" style="color:green" id="boton1" onclick = "funcion();">
    <br>
    <br>
    <br>
    <br>
    <input type="submit" name="rechazar" value="RECHAZAR" style="color:red" id="boton1" onclick = "funcion();">
    </div>    
</div>
</form>
<?php 
}
?>