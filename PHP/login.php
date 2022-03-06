<?php

//    require_once('../conection.php');
//    session_start();

//    if(isset($_POST['Login']))
//    {
        // $email = mysqli_real_escape_string($con, $_POST['user-correo']);
        // $password = mysqli_real_escape_string($con, $_POST['user-contrasena']);
        
//        if ($email != "" && $password != ""){
//            $sql_query = "CALL BuscarUsuario('".$email."');";
            // $result = mysqli_query($con, $sql_query);
//            $row = mysqli_fetch_array($result);
//            if ($row['Estado'] == 'ERROR') {
//                $_COOKIE["error"] = $row['Mensaje'];
//                header('Location: ../index.php');
//           } else {
//                $match = false;
//                if (preg_match('/\$\d+\w\$\d+\$.*/m', $row["Contrasena"])) {
//                    $match = password_verify($password, $row["Contrasena"]);
//                } else {
//                    $match = strcmp($password, $row["Contrasena"]) == 0;
//                }
//                if ($match) {
//                    $_SESSION['u_ID'] = $row['idUsuario'];
//                    $_SESSION['u_Nombre'] = $row['Nombre'];
//                    $_SESSION['u_Email'] = $row['Email'];
//                    $_SESSION['u_idRol'] = $row['idRol'];
//                    $_SESSION['u_Rol'] = $row['Rol'];
//                    $_SESSION['u_Subrol'] = $row['Subrol'];
//                    $_SESSION['u_Direccion'] = $row['Direccion'];
//                    $_SESSION['u_Departamento'] = $row['Departamento'];
        
//                    header('Location: ../administrador.php');
//                } else {
//                    header("location:../index.php?Invalid=Correo Electronico o Contraseña invalidos.");
//                }
//            }
//        } elseif ($email == ""){
//            $_COOKIE["error"] = "Debe llenar el campo de email.";
//            header('Location: ../index.php');
//        } else {
//            $_COOKIE["error"] = "Debe de llenar el campo de contraseña.";
//            header('Location: ../index.php');
//        }

//    }


    require_once('../conection.php');
    session_start();

    $_SESSION['logged'] = true;
    $_SESSION['user'] = $usuario;

    if(isset($_POST['insert'])){
    
        $usuario = $_POST['usuario'];
        $password =($_POST['passwd']);

        $stmt = "SELECT Correo_electronico, idRol, idCliente, FROM Usuarios WHERE Usuario = '$usuario' 'AND Contrasena = '$password'";
        if($stmt == false){
            echo 'Datos Erroneos';
        }else{
            
           $row = sqlsrv_fetch_array($stmt);
            $_SESSION['u_Nombre'] = $row['idRol'];


            header("Location:../index.php");
        }
    }

?>