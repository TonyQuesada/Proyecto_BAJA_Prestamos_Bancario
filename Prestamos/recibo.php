<?php
include '../conection.php';
session_start();
setlocale(LC_TIME, "spanish");
// echo "<script>alert('Solicitud de préstamo ingresada correctamente.')</script>";

// Obtener el Tipo de Cambio //
$consulta = "SELECT * FROM Tipo_Cambio";
$ejecutar = sqlsrv_query($con, $consulta);
$compra = 0;
$venta = 0;
$i = 0;
while ($fila = sqlsrv_fetch_array($ejecutar)) {
    $Nombre_Tipo = $fila['Nombre_Tipo'];
    $Monto = $fila['Monto'];
    if ($i == 0) {
        $compra = $fila['Monto'];
    } else {
        $venta = $fila['Monto'];
    }
    $i++;
}

$sesionRol = null;
if (isset($_SESSION['u_idRol'])) {
    $sesionRol = $_SESSION['u_idRol'];
}

if ($_SESSION['id_id'] == 1) {
    $tipo_id = "Nacional";
} else {
    $tipo_id = "Extranjero";
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--=============== FAVICON ===============-->
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">

    <!--=============== BOXICONS ===============-->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../assets/css/styles.css">

    <!--=============== API ===============-->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <title>Recibo de la Solicitud</title>
</head>

<body>

    <!--==================== NAV ====================-->
    <nav class="nav" id="nav">
        <div class="nav__menu container" id="nav-menu">
            <div class="nav__shape demo"></div>

            <div class="nav__close" id="nav-close">
                <i class='bx bx-x'></i>
            </div>

            <?php
            if ($sesionRol == NULL) {
            ?>
                <div class="nav__data">
                    <div class="nav__mask">
                        <img src="../assets/img/unknown.png" alt="" class="nav__img">
                    </div>

                    <h2 style="color: hsl(197, 100%, 65%);">BANCA <br> EN LÍNEA</h2>
                </div>

                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="../Prestamos/login.php" class="nav__link i__scroll">
                            <i class='bx bx-user'></i> Iniciar Sesión
                        </a>
                    </li>
                <?php
            } else if ($sesionRol == 3 || $sesionRol == 2 || $sesionRol == 1) {
                ?>
                    <div class="nav__data">
                        <div class="nav__mask">
                            <img src="../assets/img/userAdmin.png" alt="" class="nav__img">
                        </div>

                        <span class="nav__greeting">Bienvenid@</span>
                        <h1 class="nav__name"><?php echo $_SESSION['u_Nombre_Usuario'] ?></h1>
                    </div>

                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="../Prestamos/empleado_perfil.php" class="nav__link i__scroll">
                                <i class='bx bx-user'></i> Perfil
                            </a>
                        </li>
                    <?php
                } else if ($sesionRol == 4) {
                    ?>
                        <div class="nav__data">
                            <div class="nav__mask">
                                <img src="../assets/img/userMale.png" alt="" class="nav__img">
                            </div>

                            <span class="nav__greeting">Bienvenid@</span>
                            <h1 class="nav__name"><?php echo $_SESSION['u_Nombre_Usuario'] ?></h1>
                        </div>

                        <ul class="nav__list">
                            <li class="nav__item">
                                <a href="../Prestamos/cliente_perfil.php" class="nav__link i__scroll">
                                    <i class='bx bx-user'></i> Perfil
                                </a>
                            </li>
                        <?php
                    }
                        ?>
                        <li class="nav__item">
                            <a href="#home" class="nav__link i__scroll active-link">
                                <i class='bx bx-home'></i> Inicio
                            </a>
                        </li>

                        <?php
                        if ($sesionRol == 1) {
                        ?>

                            <li class="nav__item">
                                <a href="../contador/dashboard.php" class="nav__link i__scroll">
                                    <i class='bx bx-line-chart'></i> Tablero
                                </a>
                            </li>
                            <li class="nav__item">
                                <a href="../Tramitador/asignar_prestamos.php" class="nav__link i__scroll">
                                    <i class='bx bx-folder-open'></i> Asignar Préstamos
                                </a>
                            </li>
                            <li class="nav__item">
                                <a href="../Tramitador/configuracion.php" class="nav__link i__scroll">
                                    <i class='bx bx-cog'></i> Configuración
                                </a>
                            </li>

                        <?php
                        }
                        ?>

                        <?php
                        if ($sesionRol == 2) {
                        ?>

                            <li class="nav__item">
                                <a href="../Analista/solicitudes.php" class="nav__link i__scroll">
                                    <i class='bx bx-file-find'></i> Solicitudes
                                </a>
                            </li>

                            <li class="nav__item">
                                <a href="../Analista/historial.php" class="nav__link i__scroll">
                                    <i class='bx bx-calendar'></i> Historial
                                </a>
                            </li>

                        <?php
                        }
                        ?>

                        <?php
                        if ($sesionRol == 3) {
                        ?>

                            <li class="nav__item">
                                <a href="../Administrador/roles.php" class="nav__link i__scroll">
                                    <i class='bx bx-user-plus'></i> Roles
                                </a>
                            </li>

                        <?php
                        }
                        ?>

                        <li class="nav__item">
                            <a href="#recibo" class="nav__link i__scroll">
                                <i class='bx bx-receipt'></i> Recibo
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="#products" class="nav__link i__scroll">
                                <i class='bx bx-money'></i> Préstamos
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="#footer" class="nav__link i__scroll">
                                <i class='bx bx-message-square-detail'></i> Contacto
                            </a>
                        </li>

                        <?php
                        if ($sesionRol != NULL) {
                        ?>
                            <li class="nav__item">
                                <a href="../PHP/logout.php" class="nav__link i__scroll">
                                    <i class='bx bx-log-out'></i> Cerrar Sesión
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                        </ul>
        </div>
    </nav>

    <!--==================== MAIN ====================-->
    <main class="main" id="main">

        <!-- ==================== HEADER ====================-->
        <header class="header" id="header">
            <nav class="header__nav container">

                <a href="../index.php" class="nav__log" style="margin-bottom: 40px; margin-left: -17px;">
                    <img src="../assets/img/logo.png" alt="" class="nav__logo-img" style="position: fixed;">

                    <h2>
                        <span class="nav__title">BAJA</span>
                    </h2>

                    <h3 class="nav__style">
                        <span style="color: hsl(197, 100%, 42%);">B</span>anco
                        <span style="color: hsl(197, 100%, 42%);">A</span>ngular
                        <span style="color: hsl(197, 100%, 42%);">J</span>erárquico
                        <span style="color: hsl(197, 100%, 42%);">A</span>sociado
                    </h3>

                </a>

                <!-- Toggle button -->
                <div class="header__toggle" id="header-toggle">
                    <i class='bx bx-grid-alt'></i>
                </div>
            </nav>
        </header>

        <!--==================== HOME ====================-->
        <section class="home grid" id="home">
            <div class="home__container">
                <div class="home__content container">
                    <h1 class="home__title">
                        ¡SOLICITUD ENVIADA <span style="color: hsl(197, 100%, 42%);">EXITOSAMENTE</span>!
                    </h1>
                    <p class="home__description">
                        <!-- Solicitá tu préstamo de <span style="color: hsla(197, 100%, 42%, 0.8);">gastos personales</span> y hacé realidad todos tus planes<span style="color: hsla(197, 100%, 42%, 0.8);">.</span> -->
                    </p>
                    <div class="home__data">
                        <div class="home__data-group">
                            <h3 class="home__data-title">Compra USD</h3>
                            <h2 class="home__data-number"><?php echo $compra ?></h2>
                            <p class="home__data-description">
                            </p>
                        </div>

                        <div class="home__data-group">
                            <h3 class="home__data-title">Venta USD</h3>
                            <h2 class="home__data-number"><?php echo $venta ?></h2>
                            <p class="home__data-description">
                            </p>
                        </div>
                    </div>

                    <br><br>
                    <form class="f" name="f">
                        <h3 class="home__data-title">Convertir Monedas
                            <a onclick="myFunction('compra_cambio', 'venta_cambio')" class="button_convertir pulse" id="compra_cambio" style="background-color: #009ad6;"><span>Compra</span></a>
                            <a onclick="myFunction2('venta_cambio', 'compra_cambio')" class="button_convertir pulse" id="venta_cambio"><span>Venta</span></a>
                        </h3>
                        <br>

                        <div id="myDIV">
                            <h4><input class="input__convert" type="number" name="num1_1" id="num1_1" value="" onchange="cal_1()" onkeyup="cal_1()" autocomplete="off" style="margin-left: -2px;" placeholder="0" />
                                <- Dólar</h4>
                                    <p hidden>Número 2: <input type="number" name="num2_1" value="<?php echo $compra ?>" onchange="cal_1()" onkeyup="cal_1()" /></p>
                                    <h4><input class="input__convert" type="number" name="sum_1" id="sum_1" value="" readonly="readonly" placeholder="0" />
                                        <- Cólon</h4>
                        </div>
                        <div id="myDIV2" style="display:none">
                            <h4><input class="input__convert" type="number" name="num1_2" id="num1_2" value="" onchange="cal_2()" onkeyup="cal_2()" autocomplete="off" placeholder="0" />
                                <- Cólon</h4>
                                    <p hidden>Número 2: <input type="number" name="num2_2" value="<?php echo $venta ?>" onchange="cal_2()" onkeyup="cal_2()" /></p>
                                    <h4><input class="input__convert" type="number" name="sum_2" id="sum_2" value="" readonly="readonly" style="margin-left: -2px;" placeholder="0" />
                                        <- Dólar</h4>
                        </div>
                    </form>

                    <!-- <a href="#calculador">
                        <img src="../assets/img/scroll.png" alt="" class="home__scroll">
                    </a> -->
                </div>
            </div>

            <!-- <img src="../assets/img/home.gif" alt="" class="home__img"> -->
            <video src="../assets/video/Personal1.mp4" class="home__video" type="video/mp4" autoPlay loop muted playsInline></video>

        </section>

        <script>
            function cal_1() {
                try {
                    var a = parseFloat(document.f.num1_1.value),
                        b = parseFloat(document.f.num2_1.value);
                    var c = a * b;
                    var twoPlacedFloat_1 = parseFloat(c).toFixed(2);
                    document.f.sum_1.value = twoPlacedFloat_1;
                } catch (e) {}
            }

            function cal_2() {
                try {
                    var a = parseFloat(document.f.num1_2.value),
                        b = parseFloat(document.f.num2_2.value);
                    var c = a / b;
                    var twoPlacedFloat_2 = parseFloat(c).toFixed(2);
                    document.f.sum_2.value = twoPlacedFloat_2;
                } catch (e) {}
            }

            function myFunction(id, id2) {

                document.getElementById(id).style.backgroundColor = "#009ad6";
                document.getElementById(id2).style.backgroundColor = "#004480";

                document.getElementById("num1_1").value = "";
                document.getElementById("sum_1").value = "";

                var x = document.getElementById("myDIV");
                var y = document.getElementById("myDIV2");
                if (x.style.display === "none") {
                    y.style.display = "none";
                    x.style.display = "block";
                } else {}
            }

            function myFunction2(id, id2) {

                document.getElementById(id).style.backgroundColor = "#009ad6";
                document.getElementById(id2).style.backgroundColor = "#004480";

                document.getElementById("num1_2").value = "";
                document.getElementById("sum_2").value = "";

                var x = document.getElementById("myDIV");
                var y = document.getElementById("myDIV2");
                if (y.style.display === "none") {
                    x.style.display = "none";
                    y.style.display = "block";
                } else {}
            }
        </script>

        <!--==================== BENEFITS ====================-->
        <section class="section container specialty" id="recibo">
            <div class="specialty__container">
                <h2 class="section__title">
                    ¡Solicitud enviada con <span style="color: hsl(197, 100%, 42%);">EXITO</span>!
                </h2>

                <div class="specialty__category_formulario">
                    <div class="specialty__group specialty__line_formulario">

                        <h1 style="color: #fff;">Información de la solicitud</h1>

                        <div class="l_formulario" name="l_formulario" style="margin-top: -19px;">
                            <div>
                                <br>
                                <!-- <h3 class="" style="color: #fff;">Moneda de la solicitud<span style="color: hsl(197, 100%, 42%);">:</span>
                                    <a class="button_convertir pulse" id="col" <?php if ($_SESSION['moneda_final'] == 'COLONES') { ?> style="margin-left: 0.3rem; background-color: #009ad6;" <?php } else { ?> style="display:none;" <?php } ?>><span>Colones</span></a>
                                    <a class="button_convertir pulse" id="dol" <?php if ($_SESSION['moneda_final'] != 'COLONES') { ?> style="margin-left: 0.3rem; background-color: #009ad6;" <?php } else { ?> style="display:none;" <?php } ?>><span>Dólares</span></a>
                                </h3> -->
                                <form>
                                    <div id="DIV_col" <?php if ($_SESSION['moneda_final'] != 'COLONES') { ?> style="display:none" <?php } ?>>

                                        <?php
                                        $sql = "SELECT * FROM VER_TIPOS_PRESTAMOS WHERE CATEGORIA = 'Personales' AND PRESTAMO = 'Gastos Personales Colones'";
                                        $result = sqlsrv_query($con, $sql);
                                        while ($row = sqlsrv_fetch_array($result)) {
                                            $min_col = $row['MONTO_MINIMO'];
                                            $max_col = $row['MONTO_MAXIMO'];
                                            $plazoMin_col = $row['PLAZO_MINIMO'];
                                            $plazoMax_col = $row['PLAZO_MAXIMO'];
                                            $tasaInteres_col = $row['TASA_DE_INTERES'];
                                        }
                                        ?>

                                        <h3 style="color: #fff;">Monto solicitado<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                        <h4>
                                            <input class="input__convert input__convert_prestamo" type="text" name="monto_solicita_col" id="monto_solicita_col" value="<?php if ($_SESSION['moneda_final'] == 'COLONES') {
                                                                                                                                                                            echo 'CRC ' . number_format($_SESSION['monto_solicita_final'], 2);
                                                                                                                                                                        } else {
                                                                                                                                                                            echo "";
                                                                                                                                                                        } ?>" placeholder="0" autocomplete="off" readonly />
                                            <h5 style="color: hsl(197, 100%, 35%);">Monto Maximo: <?php echo 'CRC ' . number_format($max_col, 2) ?> | Monto Minimo: <?php echo 'CRC ' . number_format($min_col, 2) ?></h5>
                                        </h4>
                                        <br>

                                        <h3 style="color: #fff;">Plazo de la solicitud<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                        <h4>
                                            <input class="input__convert input__convert_prestamo" type="text" name="monto_solicita_col" id="monto_solicita_col" value="<?php if ($_SESSION['moneda_final'] == 'COLONES') {
                                                                                                                                                                            if ($_SESSION['range_final'] == 1) {
                                                                                                                                                                                echo $_SESSION['range_final'] . ' año';
                                                                                                                                                                            } else {
                                                                                                                                                                                echo $_SESSION['range_final'] . ' años';
                                                                                                                                                                            }
                                                                                                                                                                        } else {
                                                                                                                                                                            echo "";
                                                                                                                                                                        } ?>" placeholder="0" autocomplete="off" readonly />
                                        </h4>
                                        <br><br>

                                        <h3 style="color: #fff;">Tasa de la solicitud (%)<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                        <h4>
                                            <input class="input__convert input__convert_prestamo" type="number" name="tasa_col" id="tasa_col" value="<?php if ($_SESSION['moneda_final'] == 'COLONES') {
                                                                                                                                                            echo $_SESSION['tasa_final'];
                                                                                                                                                        } else {
                                                                                                                                                            echo $tasaInteres_col;
                                                                                                                                                        } ?>" placeholder="0" readonly />
                                        </h4>
                                        <br><br>

                                        <h3 style="color: #fff;">Cuota mensual de la solicitud<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                        <h4>
                                            <input class="input__convert input__convert_prestamo" type="text" name="cuota_mensual_col" id="cuota_mensual_col" value="<?php if ($_SESSION['moneda_final'] == 'COLONES') {
                                                                                                                                                                            echo $_SESSION['cuota_mensual_final'];
                                                                                                                                                                        } else {
                                                                                                                                                                            echo "";
                                                                                                                                                                        } ?>" placeholder="0" readonly="readonly" />
                                        </h4>
                                        <br><br>

                                    </div>
                                </form>

                                <form>
                                    <div id="DIV_dol" <?php if ($_SESSION['moneda_final'] == 'COLONES') { ?> style="display:none" <?php } ?>>

                                        <?php
                                        $sql = "SELECT * FROM VER_TIPOS_PRESTAMOS WHERE CATEGORIA = 'Personales' AND PRESTAMO = 'Gastos Personales Dolares'";
                                        $result = sqlsrv_query($con, $sql);
                                        while ($row = sqlsrv_fetch_array($result)) {
                                            $min_dol = $row['MONTO_MINIMO'];
                                            $max_dol = $row['MONTO_MAXIMO'];
                                            $plazoMin_dol = $row['PLAZO_MINIMO'];
                                            $plazoMax_dol = $row['PLAZO_MAXIMO'];
                                            $tasaInteres_dol = $row['TASA_DE_INTERES'];
                                        }
                                        ?>


                                        <h3 style="color: #fff;">Monto solicitado<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                        <h4>
                                            <input class="input__convert input__convert_prestamo" type="text" name="monto_solicita_dol" id="monto_solicita_dol" value="<?php if ($_SESSION['moneda_final'] != 'COLONES') {
                                                                                                                                                                            echo '$ ' . $_SESSION['monto_solicita_final'];
                                                                                                                                                                        } else {
                                                                                                                                                                            echo "";
                                                                                                                                                                        } ?>" placeholder="0" autocomplete="off" readonly />
                                            <h5 style="color: hsl(197, 100%, 35%);">Monto Maximo: <?php echo '$ ' . number_format($max_dol, 2) ?> | Monto Minimo: <?php echo '$ ' . number_format($min_dol, 2) ?></h5>
                                        </h4>
                                        <br>

                                        <h3 style="color: #fff;">Plazo de la solicitud<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                        <h4>
                                            <input class="input__convert input__convert_prestamo" type="text" name="monto_solicita_dol" id="monto_solicita_dol" value="<?php if ($_SESSION['moneda_final'] != 'COLONES') {
                                                                                                                                                                            if ($_SESSION['range_final'] == 1) {
                                                                                                                                                                                echo $_SESSION['range_final'] . ' año';
                                                                                                                                                                            } else {
                                                                                                                                                                                echo $_SESSION['range_final'] . ' años';
                                                                                                                                                                            }
                                                                                                                                                                        } else {
                                                                                                                                                                            echo "";
                                                                                                                                                                        } ?>" placeholder="0" autocomplete="off" readonly />
                                        </h4>
                                        <br><br>

                                        <h3 style="color: #fff;">Tasa de la solicitud (%)<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                        <h4>
                                            <input class="input__convert input__convert_prestamo" type="number" name="tasa_dol" id="tasa_dol" value="<?php if ($_SESSION['moneda_final'] != 'COLONES') {
                                                                                                                                                            echo $_SESSION['tasa_final'];
                                                                                                                                                        } else {
                                                                                                                                                            echo $tasaInteres_dol;
                                                                                                                                                        } ?>" placeholder="0" readonly />
                                        </h4>
                                        <br><br>

                                        <h3 style="color: #fff;">Cuota mensual de la solicitud<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                        <h4>
                                            <input class="input__convert input__convert_prestamo" type="text" name="cuota_mensual_dol" id="cuota_mensual_dol" value="<?php if ($_SESSION['moneda_final'] != 'COLONES') {
                                                                                                                                                                            echo $_SESSION['cuota_mensual_final'];
                                                                                                                                                                        } else {
                                                                                                                                                                            echo "";
                                                                                                                                                                        } ?>" placeholder="0" readonly="readonly" />
                                        </h4>
                                        <br><br>

                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>

                    <div class="specialty__group ">

                        <h1 style="color: #fff; margin-left: -50px;">Información personal</h1>

                        <div class="l_formulario l_formulario_2" name="l_formulario">

                            <div class="specialty__category_formulario_2">

                                <div class="">
                                    <h3 style="color: #fff;">Tipo identificación<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                    <h4>
                                        <input class="input__convert input__convert_prestamo input__convert_formulario" type="text" name="tipo_id" id="tipo_id" value='<?php echo $tipo_id; ?>' style="width: 235px;" placeholder="" autocomplete="off" readonly />
                                    </h4>
                                </div>
                                <div class="">
                                    <h3 style="color: #fff;">Identificación<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                    <h4>
                                        <input class="input__convert input__convert_prestamo input__convert_formulario" type="text" name="cedula" id="cedula" value='<?php echo $_SESSION['cedulaFormulario'] ?>' style="width: 235px;" placeholder="" autocomplete="off" readonly />
                                    </h4>
                                    <br><br>
                                </div>

                            </div>

                            <div class="specialty__category_formulario_3">

                                <div class="">
                                    <h3 style="color: #fff;">Nombre<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                    <h4>
                                        <input class="input__convert input__convert_prestamo input__convert_formulario" type="text" name="nombre" id="nombre" value='<?php echo $_SESSION['nombreFormulario'] ?>' style="width: 180px;" placeholder="" autocomplete="off" readonly />
                                    </h4>
                                </div>

                                <div class="medio">
                                    <h3 style="color: #fff;">Primer apellido<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                    <h4>
                                        <input class="input__convert input__convert_prestamo input__convert_formulario" type="text" name="ape1" id="ape1" value='<?php echo $_SESSION['apellido1Formulario'] ?>' style="width: 145px;" placeholder="" autocomplete="off" readonly />
                                    </h4>
                                </div>

                                <div class="derecha">
                                    <h3 style="color: #fff;">Segundo apellido<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                    <h4>
                                        <input class="input__convert input__convert_prestamo input__convert_formulario" type="text" name="ape2" id="ape2" value='<?php echo $_SESSION['apellido2Formulario'] ?>' style="width: 158px;" placeholder="" autocomplete="off" readonly />
                                    </h4>
                                    <br><br>
                                </div>

                            </div>


                            <h3 style="color: #fff;">Correo electrónico<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                            <h4>
                                <input class="input__convert input__convert_prestamo" style="width: 97%;" type="email" name="email" id="email" value='<?php echo $_SESSION['emailFormulario'] ?>' placeholder="" autocomplete="off" readonly />
                            </h4>
                            <br><br>

                            <div class="specialty__category_formulario_2">

                                <div class="">
                                    <h3 style="color: #fff;">Categoría de préstamo<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                    <h4>
                                        <input class="input__convert input__convert_prestamo input__convert_formulario" type="text" name="tipo_id" id="tipo_id" value='<?php echo $_SESSION['cate'] ?>' style="width: 230px;" placeholder="" autocomplete="off" readonly />
                                    </h4>
                                </div>
                                <div class="">
                                    <h3 style="color: #fff;">Tipo de préstamo<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                    <h4>
                                        <input class="input__convert input__convert_prestamo input__convert_formulario" type="text" name="cedula" id="cedula" value='<?php echo $_SESSION['prest'] ?>' style="width: 242px;" placeholder="" autocomplete="off" readonly />
                                    </h4>
                                </div>
                            </div>

                            <br><br>

                            <div class="specialty__category_formulario_2">

                                <div class="">
                                </div>

                                <form action="../index.php">
                                    <div class="">
                                        <div style="text-align: right; margin-top: -5px; margin-top: 11px;">
                                            <button type="submit" class="button specialty__button pulse" style="margin-right: 15px;"><span>CONTINUAR</span></button>
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>

                    </div>

                </div>
            </div>

            </div>
        </section>

        <!--==================== BENEFITS ====================-->
        <div class="section container specialty" id="specialty">
            <div class="specialty__container">
                <div class="specialty__box">
                    <h2 class="section__title">
                        ¡Te ayudamos a cumplir tus metas!
                    </h2>

                    <div>
                        <a href="#products" class="button specialty__button pulse"><span>Ver más</span></a>
                    </div>
                </div>

                <div class="specialty__category">
                    <div class="specialty__group specialty__line">
                        <img src="../assets/img/BAJA_online.png" alt="" class="specialty__img">

                        <h3 class="specialty__title">BAJA Online</h3>
                        <p class="specialty__description">
                            Administrá tus préstamo por medio de la sucursal BAJA Online.
                        </p>
                    </div>
                    <div class="specialty__group specialty__line">
                        <img src="../assets/img/Tramites_Rapidos.png" alt="" class="specialty__img">

                        <h3 class="specialty__title">Trámites rápidos</h3>
                        <p class="specialty__description">
                            Lográ la aprobación de tu préstamo de forma rápida y sencilla.
                        </p>
                    </div>
                    <div class="specialty__group">
                        <img src="../assets/img/Pago.png" alt="" class="specialty__img">

                        <h3 class="specialty__title">Pagos</h3>
                        <p class="specialty__description">
                            Pagá tu préstamo en cualquiera de nuestras sucursales alrededor del país.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!--==================== LOANS (Prestamos) ====================-->
        <section class="section products" id="products">
            <div class="products__container container">
                <h2 class="section__title">
                    Descubrí todas tus opciones financieras
                </h2>

                <ul class="products__filters">
                    <li class="products__item products__line active-product" data-filter=".Personal">
                        <h3 class="products__title">Personal</h3>
                        <span class="products__stock">2 Prestamos</span>
                    </li>

                    <li class="products__item products__line" data-filter=".Vivienda">
                        <h3 class="products__title">Vivienda</h3>
                        <span class="products__stock">2 Prestamos</span>
                    </li>

                    <li class="products__item products__line" data-filter=".Vehiculos">
                        <h3 class="products__title">Vehiculos</h3>
                        <span class="products__stock">2 Prestamos</span>
                    </li>

                    <li class="products__item products__line" data-filter=".Viajes">
                        <h3 class="products__title">Viajes</h3>
                        <span class="products__stock">2 Prestamos</span>
                    </li>

                    <li class="products__item" data-filter=".UniDeudas">
                        <h3 class="products__title">Unificación de Deudas</h3>
                        <span class="products__stock">2 Prestamos</span>
                    </li>
                </ul>

                <div class="products__content grid">
                    <!--========== Personal ==========-->
                    <article class="products__card Personal" onclick="window.location.href='../Prestamos/Personal/gastos_personales.php'">
                        <div class="products__shape">
                            <img src="../assets/img/personal1.png" alt="" class="products__img">
                        </div>

                        <div class="products__data">
                            <h2 class="products__price">Gastos Personales</h2>
                            <h3 class="products__name">Solicitá tu préstamo personal y hacé realidad todos tus planes.</h3>

                            <button class="button products__button">
                                <i class='bx bxs-calculator'></i>
                            </button>
                        </div>
                    </article>

                    <article class="products__card Personal" onclick="window.location.href='../Prestamos/Personal/rapidos.php'">
                        <div class="products__shape">
                            <img src="../assets/img/personal2.png" alt="" class="products__img">
                        </div>

                        <div class="products__data">
                            <h2 class="products__price">Rápidos</h2>
                            <h3 class="products__name">Te brindamos un crédito de rápida aprobación para tus necesidades inmediatas.</h3>

                            <button class="button products__button">
                                <i class='bx bxs-calculator'></i>
                            </button>
                        </div>
                    </article>

                    <!--========== Vivienda ==========-->
                    <article class="products__card Vivienda" onclick="window.location.href='../Prestamos/Vivienda/construccion_vivienda.php'">
                        <div class="products__shape">
                            <img src="../assets/img/house1.png" alt="" class="products__img">
                        </div>

                        <div class="products__data">
                            <h2 class="products__price">Construcción Vivienda</h2>
                            <h3 class="products__name">Te ofrecemos un crédito hecho a tu medida para la construcción de tu casa.</h3>

                            <button class="button products__button">
                                <i class='bx bxs-calculator'></i>
                            </button>
                        </div>
                    </article>

                    <article class="products__card Vivienda" onclick="window.location.href='../Prestamos/Vivienda/vivienda_interes_social.php'">
                        <div class="products__shape">
                            <img src="../assets/img/house2.png" alt="" class="products__img">
                        </div>

                        <div class="products__data">
                            <h2 class="products__price">Vivienda Interés Social</h2>
                            <h3 class="products__name">Te ofrecemos una solución ágil de financiamiento para que estrenés en menor tiempo tu nuevo hogar.</h3>

                            <button class="button products__button">
                                <i class='bx bxs-calculator'></i>
                            </button>
                        </div>
                    </article>

                    <!--========== Vehiculos ==========-->
                    <article class="products__card Vehiculos" onclick="window.location.href='../Prestamos/Vehiculo/vehiculo_nuevo.php'">
                        <div class="products__shape">
                            <img src="../assets/img/car1.png" alt="" class="products__img">
                        </div>

                        <div class="products__data">
                            <h2 class="products__price">Vehículo Nuevo</h2>
                            <h3 class="products__name">Te ofrecemos tasas competitivas y rápidos tiempos de respuesta para comprar tu carro nuevo.</h3>

                            <button class="button products__button">
                                <i class='bx bxs-calculator'></i>
                            </button>
                        </div>
                    </article>

                    <article class="products__card Vehiculos" onclick="window.location.href='../Prestamos/Vehiculo/vehiculo_usado.php'">
                        <div class="products__shape">
                            <img src="../assets/img/car2.png" alt="" class="products__img">
                        </div>

                        <div class="products__data">
                            <h2 class="products__price">Vehículo Usado</h2>
                            <h3 class="products__name">Te ofrecemos tasas competitivas y rápidos tiempos de respuesta para comprar tu carro usado.</h3>

                            <button class="button products__button">
                                <i class='bx bxs-calculator'></i>
                            </button>
                        </div>
                    </article>

                    <!--========== Viajes ==========-->
                    <article class="products__card Viajes" onclick="window.location.href='../Prestamos/Viajes/viajes_internacionales.php'">
                        <div class="products__shape">
                            <img src="../assets/img/travel3.png" alt="" class="products__img">
                        </div>

                        <div class="products__data">
                            <h2 class="products__price">Viajes Internacionales</h2>
                            <h3 class="products__name">Planifique el viaje, prepare las maletas con tranquilidad, nosotros le financiamos.</h3>

                            <button class="button products__button">
                                <i class='bx bxs-calculator'></i>
                            </button>
                        </div>
                    </article>

                    <article class="products__card Viajes" onclick="window.location.href='../Prestamos/Viajes/viajes_nacionales.php'">
                        <div class="products__shape">
                            <img src="../assets/img/travel2.png" alt="" class="products__img">
                        </div>

                        <div class="products__data">
                            <h2 class="products__price">Viajes Nacionales</h2>
                            <h3 class="products__name">Nosotros le ayudamos a cumplir sus sueños de viajar y disfrutar de las bellezas nacionales.</h3>

                            <button class="button products__button">
                                <i class='bx bxs-calculator'></i>
                            </button>
                        </div>
                    </article>

                    <!--========== UniDeudas ==========-->
                    <article class="products__card UniDeudas" onclick="window.location.href='../Prestamos/Unificacion/pagos_tarjeta_credito.php'">
                        <div class="products__shape">
                            <img src="../assets/img/pay1.png" alt="" class="products__img">
                        </div>

                        <div class="products__data">
                            <h2 class="products__price">Pagos De Tarjetas De Crédito</h2>
                            <h3 class="products__name">Unifique sus pagos de tarjeta con una cuota única.</h3>

                            <button class="button products__button">
                                <i class='bx bxs-calculator'></i>
                            </button>
                        </div>
                    </article>

                    <article class="products__card UniDeudas" onclick="window.location.href='../Prestamos/Unificacion/prestamos_de_otras_instituciones.php'">
                        <div class="products__shape">
                            <img src="../assets/img/pay2.png" alt="" class="products__img">
                        </div>

                        <div class="products__data">
                            <h2 class="products__price">Préstamos De Otras Instituciones</h2>
                            <h3 class="products__name">Gane paz y liquidez al unificar sus deudas con BAJA.</h3>

                            <button class="button products__button">
                                <i class='bx bxs-calculator'></i>
                            </button>
                        </div>
                    </article>


                </div>
            </div>
        </section>

        <!--==================== TREND (Tendencia) ====================-->
        <section class="section blog" id="blog">
        </section>

        <!--==================== FOOTER ====================-->
        <section class="section footer" id="footer">
            <div class="footer__container container">
                </br>
                <h1 class="footer__title">BAJA</h1>

                <div class="footer__content grid">
                    <div class="footer__data">
                        <p class="footer__description">
                            Para nosotros será un placer poder atender sus consultas.
                        </p>
                        </br>
                        </br>
                        <!-- <div class="footer__newsletter">
                            <input type="email" placeholder="Ingrese su dirección de correo electrónico" class="footer__input">
                            <button class="footer__button">
                                <i class='bx bx-right-arrow-alt'></i>
                            </button>
                        </div> -->
                    </div>

                    <div class="footer__data">
                        <h2 class="footer__subtitle">Dirección</h2>
                        <p class="footer__information">
                            Avenidas 1 y 3, Calle 4 Cartago Costa Rica. <br>
                            Cartago, Cartago, Costa Rica
                            <img src="../assets/img/footerflag.png" alt="" class="footer__flag">
                        </p>
                    </div>

                    <div class="footer__data">
                        <h2 class="footer__subtitle">Contacto</h2>
                        <p class="footer__information">
                            6190 3211 <br>
                            info@baja.cr
                        </p>
                    </div>

                    <div class="footer__data">
                        <h2 class="footer__subtitle">Oficinas</h2>
                        <p class="footer__information">
                            Lunes - Sabado <br>
                            8AM - 6PM
                        </p>
                    </div>
                </div>

                <div class="footer__group">
                    <ul class="footer__social">
                        <a href="https://www.facebook.com/" target="_blank" class="footer__social-link">
                            <!-- <i class='bx bxl-facebook'></i> -->
                        </a>
                        <a href="https://www.instagram.com/" target="_blank" class="footer__social-link">
                            <!-- <i class='bx bxl-instagram'></i> -->
                        </a>
                        <a href="https://twitter.com/" target="_blank" class="footer__social-link">
                            <!-- <i class='bx bxl-twitter'></i> -->
                        </a>
                    </ul>

                    <span class="footer__copy">
                        &#169; 2022 Banco Angular Jerárquico Asociado. Todos los derechos reservados.
                    </span>
                </div>
            </div>
        </section>
    </main>

    <!--========== SCROLL UP ==========-->
    <a href="#" class="scrollup pulse" id="scroll-up">
        <i class='bx bx-up-arrow-alt'></i>
    </a>

    <!--=============== MIXITUP FILTER ===============-->
    <script src="../assets/js/mixitup.min.js"></script>

    <!--=============== MAIN JS ===============-->
    <script src="../assets/js/main.js"></script>
</body>

</html>