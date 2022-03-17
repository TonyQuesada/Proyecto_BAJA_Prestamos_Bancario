formulario

<?php 

$monto_solicita_col = $_POST['monto_solicita_col'];
$monto_solicita_dol = $_POST['monto_solicita_dol'];
$mon = '';

if($monto_solicita_dol == NUll){
 $mon = 'col';
} else {
    $mon = 'dol';
}

$monto_solicita_ = 'monto_solicita_' . $mon;
$range_ = 'range_' . $mon;
$tasa_ = 'tasa_' . $mon;
$cuota_mensual_ = 'cuota_mensual_' . $mon;
$moneda_ = 'moneda_' . $mon;

$monto_solicita_final = $_POST[$monto_solicita_];
$range_final = $_POST[$range_];
$tasa_final = $_POST[$tasa_];
$cuota_mensual_final = $_POST[$cuota_mensual_];
$moneda_final = $_POST[$moneda_];


echo $monto_solicita_final;
echo '//';
echo $range_final;
echo '//';
echo $tasa_final;
echo '//';
echo $cuota_mensual_final;
echo '//';
echo $moneda_final;
echo '//';

// echo $monto_solicita_col;
// echo $monto_solicita_dol;



?>