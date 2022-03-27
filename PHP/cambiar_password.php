<?php

include '../conection.php';
session_start();
setlocale(LC_TIME, "spanish");

$sesionRol = null;
if (isset($_SESSION['u_idRol'])) {
    $sesionRol = $_SESSION['u_idRol'];
}

// echo "Usuario: " . $_POST['usuario'] . '<br>';
// echo "Contrasena: " . $_POST['contrasena'] . '<br>';
// echo "Contrasena Nueva: " . $_POST['contrasenaNew'] . '<br>';

$_SESSION['Usuario'] = $_POST['usuario'];
$_SESSION['Contrasena'] = $_POST['contrasena'];
$_SESSION['ContrasenaNew'] = $_POST['contrasenaNew'];

$u_veri = $_SESSION['Usuario'];
$p_veri = $_SESSION['ContrasenaNew'];

$params = array(
    $_SESSION['Usuario'],
    $_SESSION['Contrasena'],
    $_SESSION['ContrasenaNew']
);

$procedure_call = "{call Modificar_Contrasenia(?, ?, ?)}";

$query = sqlsrv_query($con, $procedure_call, $params);


$verificar = "SELECT COUNT(*) AS NUM FROM Usuarios WHERE Usuario = '$u_veri' AND Contrasena = '$p_veri'";
$results = sqlsrv_query($con, $verificar);
$row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC);
$NUM = $row['NUM'];
// echo $NUM;

if ($NUM != 0) {
    echo "<script>
            alert('Contraseña restablecida.');
            window.location= '../Prestamos/login.php'
        </script>";
} else {
    echo "<script>
                alert('Error al intentar restablecer la contraseña.');
                window.location= '../Prestamos/login.php'
          </script>";
}
