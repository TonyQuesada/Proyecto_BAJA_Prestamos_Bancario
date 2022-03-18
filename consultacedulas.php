<?php

$cedula = '';
$nombre = '';
$ape1 = '';
$ape2 = '';

if (isset($_POST['cedula'])) {
	$datos = json_decode(file_get_contents("http://aaron040291-001-site1.ctempurl.com/api/Personas/" . $_POST["cedula"]), true);

	$cedula = $datos["CEDULA"];
	$nombre = $datos["NOMBRE_COMPLETO"];
	$ape1 = $datos["PRIMER_APELLIDO"];
	$ape2 = $datos["SEGUNDO_APELLIDO"];
}
?>

<!DOCTYPE html>
<html lang="en">

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
		Nombre: <input type='text' name="nombre" id="nombre" readonly value='<?php echo ($nombre); ?>' />
		Primer Apellido: <input type='text' name="ape1" id="ape1" readonly value='<?php echo ($ape1); ?>' />
		Segundo Apellido: <input type='text' name="ape2" id="ape2" readonly value='<?php echo ($ape2); ?>' />
	</p>
</body>

</html>