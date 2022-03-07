<?php

session_start();
require_once('../conection.php');

if (isset($_POST['insert'])) {

    $usuario = $_POST['usuario'];
    $password = $_POST['passwd'];

    $query = "SELECT * FROM Usuarios WHERE Usuario = '$usuario' AND Contrasena = '$password'";
    if ($query == false) {
        echo 'Datos Erroneos';
    } else {

        $results = sqlsrv_query($con, $query); //ejecuta la query
        $row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC);

        $_SESSION['u_idUsuario'] = $row['idUsuario'];
        $_SESSION['u_Usuario'] = $row['Usuario'];
        $_SESSION['u_Nombre_Usuario'] = $row['Nombre_Usuario'];
        $_SESSION['u_Correo_electronico'] = $row['Correo_electronico'];
        $_SESSION['u_Contrasena'] = $row['Contrasena'];
        $_SESSION['u_idRol'] = $row['idRol'];
        $_SESSION['u_idEmpleado'] = $row['idEmpleado'];
        $_SESSION['u_idCliente'] = $row['idCliente'];

        // echo $_SESSION['u_Nombre_Usuario'];
        header("Location:../index.php");
    }
}
