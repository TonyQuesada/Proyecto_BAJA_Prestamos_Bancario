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

        $ID_ROl_EMPLEADO = $_SESSION['u_idRol'];

        if(!is_null($ID_ROl_EMPLEADO)){
            $categoria = "SELECT * FROM VER_CAT_ROLES WHERE ID_ROL = '$ID_ROl_EMPLEADO'";
            $categoria_resultado = sqlsrv_query($con, $categoria);
            
            while ($fila = sqlsrv_fetch_array($categoria_resultado)) {
                $_SESSION['u_NombreRol'] = $fila['NOMBRE'];
            }
        }



        // echo "ID: " . $_SESSION['u_idUsuario'] . '<br>';
        // echo "Usuario: " . $_SESSION['u_Usuario'] . '<br>';
        // echo "Pass: " . $_SESSION['u_Contrasena'] . '<br>';
        // echo "Nombre: " . $_SESSION['u_Nombre_Usuario'] . '<br>';
        // echo "Correo: " . $_SESSION['u_Correo_electronico'] . '<br>';
        // echo "idRol: " . $_SESSION['u_idRol'] . '<br>';
        // echo "idEmpleado: " . $_SESSION['u_idEmpleado'] . '<br>';
        // echo "NombreRolEmpleado: " . $_SESSION['u_NombreRol'] . '<br>';
        // echo "idCliente: " . $_SESSION['u_idCliente'] . '<br>';


        // header("Location:../index.php");

        echo '<script type="text/javascript">
        history.back();
        </script>';
    }
}
