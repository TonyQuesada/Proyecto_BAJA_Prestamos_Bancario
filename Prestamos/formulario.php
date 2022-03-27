<?php
include '../conection.php';
session_start();
setlocale(LC_TIME, "spanish");

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

// Busca a la persona //
$cedula = '';
$id_id = '';
$tipo_id = '';
$nombre = '';
$ape1 = '';
$ape2 = '';
$sesion_idCliente = '';
$correo = '';
$noExiste = '';
$CATEGORIA = '';
$PRESTAMO_COL = '';
$PRESTAMO_DOL = '';

if (isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];
}

if (isset($_SESSION['u_idCliente']) && ($cedula == NULL)) {

    $cedula = $_SESSION['u_idCliente'];

    $datos = json_decode(file_get_contents("http://aaron040291-001-site1.ctempurl.com/api/Personas/" . $cedula), true);

    if ($datos == '') {
        $noExiste = 'Número de identificación de la sesión incorrecto.';
    } else {

        $_SESSION['cedula_formu'] = $datos["CEDULA"];
        $_SESSION['nombre_formu'] = $datos["NOMBRE_COMPLETO"];
        $_SESSION['ape1_formu'] = $datos["PRIMER_APELLIDO"];
        $_SESSION['ape2_formu'] = $datos["SEGUNDO_APELLIDO"];
        $_SESSION['correo_formu'] = $_SESSION['u_Correo_electronico'];

        $id_id_cantidad = strlen(str_replace(",", "", number_format($cedula)));
        if ($id_id_cantidad == 9) {
            $_SESSION['id_id'] = 1;
            $tipo_id = "Nacional";
        } else if ($id_id_cantidad == 12) {
            $_SESSION['id_id'] = 2;
            $tipo_id = "Extranjero";
        } else {
            $_SESSION['id_id'] = 3;
            $tipo_id = "";
        }
    }
    // } else if (preg_replace('/[^0-9.]+/', '', $_POST['cedula']) == '134000086902') {

    //     $cedula = preg_replace('/[^0-9.]+/', '', $_POST['cedula']);

    //     $_SESSION['cedula_formu'] = '134000086902';
    //     $_SESSION['nombre_formu'] = 'DUNIA MARIA';
    //     $_SESSION['ape1_formu'] = 'LAGOS';
    //     $_SESSION['ape2_formu'] = 'BACA';

    //     $id_id_cantidad = strlen(str_replace(",", "", number_format($cedula)));
    //     if ($id_id_cantidad == 9) {
    //         $_SESSION['id_id'] = 1;
    //         $tipo_id = "Nacional";
    //     } else if ($id_id_cantidad == 12) {
    //         $_SESSION['id_id'] = 2;
    //         $tipo_id = "Extranjero";
    //     } else {
    //         $_SESSION['id_id'] = 3;
    //         $tipo_id = "";
    //     }
} else if ($cedula != NULL) {

    if (isset($_POST['cedula'])) {

        $cedula = preg_replace('/[^0-9.]+/', '', $_POST['cedula']);
        $datos = json_decode(file_get_contents("http://aaron040291-001-site1.ctempurl.com/api/Personas/" . $cedula), true);


        if ($datos == '') {
            $noExiste = 'Número de identificación incorrecta.';
        } else {

            $_SESSION['cedula_formu'] = $datos["CEDULA"];
            $_SESSION['nombre_formu'] = $datos["NOMBRE_COMPLETO"];
            $_SESSION['ape1_formu'] = $datos["PRIMER_APELLIDO"];
            $_SESSION['ape2_formu'] = $datos["SEGUNDO_APELLIDO"];
            $_SESSION['correo_formu'] = "";
        }

        $id_id_cantidad = strlen(str_replace(",", "", number_format($cedula)));
        if ($id_id_cantidad == 9) {
            $_SESSION['id_id'] = 1;
            $tipo_id = "Nacional";
        } else if ($id_id_cantidad == 12) {
            $_SESSION['id_id'] = 2;
            $tipo_id = "Extranjero";
        } else {
            $_SESSION['id_id'] = 3;
            $tipo_id = "";
        }
    }
} else {
    $_SESSION['cedula_formu'] = "";
    $_SESSION['nombre_formu'] = "";
    $_SESSION['ape1_formu'] = "";
    $_SESSION['ape2_formu'] = "";
    $_SESSION['correo_formu'] = "";
}

// Conserva los datos de la calculadora

if (isset($_POST['monto_solicita_col']) or isset($_POST['monto_solicita_dol'])) {

    $mon = '';

    if (isset($_POST['monto_solicita_col'])) {
        $mon = 'col';
    } else if (isset($_POST['monto_solicita_dol'])) {
        $mon = 'dol';
    }

    $monto_solicita_ = 'monto_solicita_' . $mon;
    $range_ = 'range_' . $mon;
    $tasa_ = 'tasa_' . $mon;
    $cuota_mensual_ = 'cuota_mensual_' . $mon;
    $moneda_ = 'moneda_' . $mon;
    $cuota_mensual_natural_ = 'cuota_mensual_natural_' . $mon;
    $id_Categoria_Prestamo = 'id_Categoria_Prestamo';
    $id_Tipo_Prestamo = 'id_Tipo_Prestamo';

    $_SESSION['monto_solicita_final'] = $_POST[$monto_solicita_];
    $_SESSION['range_final'] = $_POST[$range_];
    $_SESSION['tasa_final'] = $_POST[$tasa_];
    $_SESSION['cuota_mensual_final'] = $_POST[$cuota_mensual_];
    $_SESSION['moneda_final'] = $_POST[$moneda_];
    $_SESSION['cuota_mensual_natural_final'] = $_POST[$cuota_mensual_natural_];
    $_SESSION['id_Categoria_Prestamo_final'] = $_POST[$id_Categoria_Prestamo];
    $_SESSION['id_Tipo_Prestamo_final'] = $_POST[$id_Tipo_Prestamo];

    $_POST['monto_solicita_col'] = array();
    $_POST['monto_solicita_dol'] = array();

    $query = "SELECT * FROM aalvarado.VER_PRESTAMOS WHERE ID_CATEGORIA = '$_SESSION[id_Categoria_Prestamo_final]' AND ID_PRESTAMO = '$_SESSION[id_Tipo_Prestamo_final]'";
    if ($query == false) {
        $_SESSION['cate'] = "";
        $_SESSION['prest'] = "";
    } else {
        $results = sqlsrv_query($con, $query); //ejecuta la query
        $row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC);

        $_SESSION['cate'] = $row['CATEGORIA'];
        $_SESSION['prest'] = substr($row['PRESTAMO'], 0, -7);
    }
}


$_SESSION['CATEGORIA'] = $_POST['Categoria_Prestamo_name'];
$_SESSION['PRESTAMO_COL'] = $_POST['Tipo_Prestamo_name_col'];
$_SESSION['PRESTAMO_DOL'] = $_POST['Tipo_Prestamo_name_dol'];

$CATEGORIA = $_SESSION['CATEGORIA'];
$PRESTAMO_COL = $_SESSION['PRESTAMO_COL'];
$PRESTAMO_DOL = $_SESSION['PRESTAMO_DOL'];

$ID_CATEGORIA = $_POST['id_Categoria_Prestamo'];
$ID_PRESTAMO = $_POST['id_Tipo_Prestamo'];
// echo "monto_solicita: " . $_SESSION['monto_solicita_final'];
// echo '<br>';
// echo "range: " . $_SESSION['range_final'];
// echo '<br>';
// echo "tasa: " . $_SESSION['tasa_final'];
// echo '<br>';
// echo "cuota_mensual: " . $_SESSION['cuota_mensual_final'];
// echo '<br>';
// echo  "ID: " . $_SESSION['cedula_formu'];
// echo '<br>';
// echo  "Correo: " . $_SESSION['correo_formu'];
// echo '<br>';
// echo "moneda: " . $_SESSION['moneda_final'];
// echo '<br>';
// echo "id_Identificacion: " . $_SESSION['id_id'];
// echo '<br>';
// echo "id_Cate: " . $_SESSION['id_Categoria_Prestamo_final'];
// echo '<br>';
// echo "id_Tipo: " . $_SESSION['id_Tipo_Prestamo_final'];
// echo '<br>';
// echo "cuota_mensual_natural: " . $_SESSION['cuota_mensual_natural_final'];
// echo '<br>';
// echo "Fecha que ve el usuario: " . strftime("%A, %d de %B de %Y");
// echo '<br>';
// echo "Fecha que guarda la base: " . strftime("%Y-%m-%d");
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

    <title>Formulario de Solicitud de Prestamo</title>
</head>

<script>

</script>

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

                        <span class="nav__greeting">Bienvenid@ <?php echo $_SESSION['u_NombreRol'] ?></span>
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

                            <span class="nav__greeting">Bienvenid@ <?php echo $_SESSION['u_NombreRol'] ?></span>
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
                            <a href="#formulario" class="nav__link i__scroll">
                                <i class='bx bx-edit-alt'></i> Formulario
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
                        FORMULARIO DE SOLICITUD<span>.</span>
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
            <video src="../assets/video/formulario.mp4" class="home__video" type="video/mp4" autoPlay loop muted playsInline></video>

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

        <section class="section container specialty" id="formulario">
            <div class="specialty__container">
                <h2 class="section__title">
                    ¡A tan solo un paso de cumplir su sueño!
                </h2>

                <div class="specialty__category_formulario">
                    <div class="specialty__group specialty__line_formulario">

                        <h1 style="color: #fff;">Información de la solicitud</h1>

                        <form method="post" name="p" id="p">

                            <div class="l_formulario" name="l_formulario">
                                <div>
                                    <h3 class="" style="color: #fff;">Tipo de Monedas<span style="color: hsl(197, 100%, 42%);">:</span>
                                        <a onclick="myFunction_col('col', 'dol')" class="button_convertir pulse" id="col" style="margin-left: 0.3rem; <?php if ($_SESSION['moneda_final'] == 'COLONES') { ?> background-color: #009ad6; <?php } ?> "><span>Colones</span></a>
                                        <a onclick="myFunction_dol('dol', 'col')" class="button_convertir pulse" id="dol" <?php if ($_SESSION['moneda_final'] != 'COLONES') { ?> style="background-color: #009ad6;" <?php } ?>><span>Dólares</span></a>
                                    </h3>
                                    <br>

                                    <div id="DIV_col" <?php if ($_SESSION['moneda_final'] != 'COLONES') { ?> style="display:none" <?php } ?>>

                                        <?php
                                        $sql = "SELECT * FROM VER_TIPOS_PRESTAMOS WHERE CATEGORIA = '" . $_SESSION['CATEGORIA'] . "' AND PRESTAMO = '" . $_SESSION['PRESTAMO_COL'] . "'";
                                        $result = sqlsrv_query($con, $sql);
                                        while ($row = sqlsrv_fetch_array($result)) {
                                            $min_col = $row['MONTO_MINIMO'];
                                            $max_col = $row['MONTO_MAXIMO'];
                                            $plazoMin_col = $row['PLAZO_MINIMO'];
                                            $plazoMax_col = $row['PLAZO_MAXIMO'];
                                            $tasaInteres_col = $row['TASA_DE_INTERES'];
                                        }
                                        ?>

                                        <h3 style="color: #fff;">Monto a solicitar<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                        <h4>
                                            <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="input__convert input__convert_prestamo caja" type="number" name="monto_solicita_col" id="monto_solicita_col" value="<?php if ($_SESSION['moneda_final'] == 'COLONES') {
                                                                                                                                                                                                                                                                                                    echo $_SESSION['monto_solicita_final'];
                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                    echo "";
                                                                                                                                                                                                                                                                                                } ?>" placeholder="0" min="<?php echo $min_col ?>" max="<?php echo $max_col ?>" maxlength="<?php echo strlen(str_replace(",", "", number_format($max_col))); ?>" onchange="cuota_col()" onkeyup="cuota_col()" autocomplete="off" />
                                            <h5 style="color: hsl(197, 100%, 35%);">Monto Minimo: <?php echo 'CRC ' . number_format($min_col, 2) ?> | Monto Maximo: <?php echo 'CRC ' . number_format($max_col, 2) ?> </h5>
                                        </h4>
                                        <br><br>

                                        <h3 style="color: #fff;">Plazo estimado (Años)<span style="color: hsl(197, 100%, 42%);">:</span><span class="value_slider value_slider_formulario" id="demo_col" name="demo_col"></span></h3>
                                        <div class="slidecontainer" style="margin-top: 7px;">
                                            <input type="range" min="1" max="<?php echo $plazoMax_col ?>" value="<?php if ($_SESSION['moneda_final'] == 'COLONES') {
                                                                                                                        echo $_SESSION['range_final'];
                                                                                                                    } else {
                                                                                                                        echo $plazoMax_col;
                                                                                                                    } ?>" class="slider" name="range_col" id="range_col" onchange="cuota_col()" onkeyup="cuota_col()">
                                        </div>
                                        <br><br>

                                        <h3 style="color: #fff;">Tasa (%)<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                        <h4>
                                            <input class="input__convert input__convert_prestamo" type="number" name="tasa_col" id="tasa_col" value="<?php if ($_SESSION['moneda_final'] == 'COLONES') {
                                                                                                                                                            echo $_SESSION['tasa_final'];
                                                                                                                                                        } else {
                                                                                                                                                            echo $tasaInteres_col;
                                                                                                                                                        } ?>" placeholder="0" readonly="readonly" onchange="cuota_col()" onkeyup="cuota_col()" />
                                        </h4>
                                        <br><br>

                                        <h3 style="color: #fff;">Cuota mensual<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                        <h4>
                                            <input class="input__convert input__convert_prestamo" type="text" name="cuota_mensual_col" id="cuota_mensual_col" value="<?php if ($_SESSION['moneda_final'] == 'COLONES') {
                                                                                                                                                                            echo $_SESSION['cuota_mensual_final'];
                                                                                                                                                                        } else {
                                                                                                                                                                            echo "";
                                                                                                                                                                        } ?>" placeholder="0" readonly="readonly" />
                                        </h4>
                                        <br><br>

                                        <input hidden type="text" id="moneda_col" name="moneda_col" value="COLONES">

                                        <input hidden type="number" id="id_Categoria_Prestamo" name="id_Categoria_Prestamo" value="<?php echo $ID_CATEGORIA ?>" readonly="readonly">
                                        <input hidden type="number" id="id_Tipo_Prestamo" name="id_Tipo_Prestamo" value="<?php echo $ID_PRESTAMO ?>" readonly="readonly">

                                        <input hidden type="text" id="Categoria_Prestamo_name" name="Categoria_Prestamo_name" value="<?php echo $CATEGORIA ?>" readonly="readonly">
                                        <input hidden type="text" id="Tipo_Prestamo_name_col" name="Tipo_Prestamo_name_col" value="<?php echo $PRESTAMO_COL ?>" readonly="readonly">
                                        <input hidden type="text" id="Tipo_Prestamo_name_dol" name="Tipo_Prestamo_name_dol" value="<?php echo $PRESTAMO_DOL ?>" readonly="readonly">

                                        <input hidden type="number" id="cuota_mensual_natural_col" name="cuota_mensual_natural_col" value="" readonly="readonly">

                                        <div style="text-align: left;">
                                            <button type="submit" class="button button_formulario specialty__button pulse"><span>ACTUALIZAR SOLICITUD</span></button>
                                        </div>
                                    </div>

                        </form>

                        <form method="post" name="q" id="q">

                            <div id="DIV_dol" <?php if ($_SESSION['moneda_final'] == 'COLONES') { ?> style="display:none" <?php } ?>>

                                <?php
                                $sql = "SELECT * FROM VER_TIPOS_PRESTAMOS WHERE CATEGORIA = '" . $_SESSION['CATEGORIA'] . "' AND PRESTAMO = '" . $_SESSION['PRESTAMO_DOL'] . "'";
                                $result = sqlsrv_query($con, $sql);
                                while ($row = sqlsrv_fetch_array($result)) {
                                    $min_dol = $row['MONTO_MINIMO'];
                                    $max_dol = $row['MONTO_MAXIMO'];
                                    $plazoMin_dol = $row['PLAZO_MINIMO'];
                                    $plazoMax_dol = $row['PLAZO_MAXIMO'];
                                    $tasaInteres_dol = $row['TASA_DE_INTERES'];
                                }
                                ?>


                                <h3 style="color: #fff;">Monto a solicitar<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                <h4>
                                    <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="input__convert input__convert_prestamo caja" type="number" name="monto_solicita_dol" id="monto_solicita_dol" value="<?php if ($_SESSION['moneda_final'] != 'COLONES') {
                                                                                                                                                                                                                                                                                            echo $_SESSION['monto_solicita_final'];
                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                            echo "";
                                                                                                                                                                                                                                                                                        } ?>" placeholder="0" min="<?php echo $min_dol ?>" max="<?php echo $max_dol ?>" maxlength="<?php echo strlen(str_replace(",", "", number_format($max_dol))); ?>" onchange="cuota_dol()" onkeyup="cuota_dol()" autocomplete="off" />
                                    <h5 style="color: hsl(197, 100%, 35%);">Monto Minimo: <?php echo '$ ' . number_format($min_dol, 2) ?> | Monto Maximo: <?php echo '$ ' . number_format($max_dol, 2) ?></h5>
                                </h4>
                                <br><br>

                                <h3 style="color: #fff;">Plazo estimado (Años)<span style="color: hsl(197, 100%, 42%);">:</span><span class="value_slider value_slider_formulario" id="demo_dol" name="demo_dol"></span></h3>
                                <div class="slidecontainer" style="margin-top: 7px;">
                                    <input type="range" min="1" max="<?php echo $plazoMax_dol ?>" value="<?php if ($_SESSION['moneda_final'] != 'COLONES') {
                                                                                                                echo $_SESSION['range_final'];
                                                                                                            } else {
                                                                                                                echo $plazoMax_dol;
                                                                                                            } ?>" class="slider" name="range_dol" id="range_dol" onchange="cuota_dol()" onkeyup="cuota_dol()">
                                </div>
                                <br><br>

                                <h3 style="color: #fff;">Tasa (%)<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                <h4>
                                    <input class="input__convert input__convert_prestamo" type="number" name="tasa_dol" id="tasa_dol" value="<?php if ($_SESSION['moneda_final'] != 'COLONES') {
                                                                                                                                                    echo $_SESSION['tasa_final'];
                                                                                                                                                } else {
                                                                                                                                                    echo $tasaInteres_dol;
                                                                                                                                                } ?>" placeholder="0" readonly="readonly" onchange="cuota_dol()" onkeyup="cuota_dol()" />
                                </h4>
                                <br><br>

                                <h3 style="color: #fff;">Cuota mensual<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                <h4>
                                    <input class="input__convert input__convert_prestamo" type="text" name="cuota_mensual_dol" id="cuota_mensual_dol" value="<?php if ($_SESSION['moneda_final'] != 'COLONES') {
                                                                                                                                                                    echo $_SESSION['cuota_mensual_final'];
                                                                                                                                                                } else {
                                                                                                                                                                    echo "";
                                                                                                                                                                } ?>" placeholder="0" readonly="readonly" />
                                </h4>
                                <br><br>

                                <input hidden type="text" id="moneda_dol" name="moneda_dol" value="DÓLARES">

                                <input hidden type="number" id="id_Categoria_Prestamo" name="id_Categoria_Prestamo" value="<?php echo $ID_CATEGORIA ?>" readonly="readonly">
                                <input hidden type="number" id="id_Tipo_Prestamo" name="id_Tipo_Prestamo" value="<?php echo $ID_PRESTAMO ?>" readonly="readonly">

                                <input hidden type="text" id="Categoria_Prestamo_name" name="Categoria_Prestamo_name" value="<?php echo $CATEGORIA ?>" readonly="readonly">
                                <input hidden type="text" id="Tipo_Prestamo_name_col" name="Tipo_Prestamo_name_col" value="<?php echo $PRESTAMO_COL ?>" readonly="readonly">
                                <input hidden type="text" id="Tipo_Prestamo_name_dol" name="Tipo_Prestamo_name_dol" value="<?php echo $PRESTAMO_DOL ?>" readonly="readonly">

                                <input hidden type="number" id="cuota_mensual_natural_dol" name="cuota_mensual_natural_dol" value="" readonly="readonly">

                                <div style="text-align: left;">
                                    <button type="submit" class="button button_formulario specialty__button pulse"><span>ACTUALIZAR SOLICITUD</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <div class="specialty__group ">

                <h1 style="color: #fff; margin-left: -50px;">Información personal</h1>

                <form method="POST">

                    <div class="l_formulario l_formulario_2" name="l_formulario">


                        <input hidden type="number" id="id_Categoria_Prestamo" name="id_Categoria_Prestamo" value="<?php echo $ID_CATEGORIA ?>" readonly="readonly">
                        <input hidden type="number" id="id_Tipo_Prestamo" name="id_Tipo_Prestamo" value="<?php echo $ID_PRESTAMO ?>" readonly="readonly">

                        <input hidden type="text" id="Categoria_Prestamo_name" name="Categoria_Prestamo_name" value="<?php echo $CATEGORIA ?>" readonly="readonly">
                        <input hidden type="text" id="Tipo_Prestamo_name_col" name="Tipo_Prestamo_name_col" value="<?php echo $PRESTAMO_COL ?>" readonly="readonly">
                        <input hidden type="text" id="Tipo_Prestamo_name_dol" name="Tipo_Prestamo_name_dol" value="<?php echo $PRESTAMO_DOL ?>" readonly="readonly">

                        <h3 style="color: #fff;">Número de identificación<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                        <h4>
                            <input class="input__convert input__convert_prestamo input__convert_formulario caja" type="text" name="cedula" id="cedula" value="" maxlength="12" placeholder="X-XXXX-XXXX" autocomplete="off" />
                            <button class="button_convertir pulse btn_formulario_consulta" type="submit" value="Consultar">Consultar</button>
                            <h5 style="color: hsl(197, 100%, 35%);">Ejemplo: 1-2345-6789 | Ejemplo: 1-2345-6789-1011</h5>
                            <h5 style="color: #B22222;"> <?php echo $noExiste; ?> </h5>
                        </h4>

                    </div>

                </form>

                <div class="l_formulario l_formulario_3" name="l_formulario">

                    <form name="datos0" id="datos0">
                        <div class="specialty__category_formulario_2">

                            <div class="">
                                <h3 style="color: #fff;">Tipo identificación<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                <h4>
                                    <input class="input__convert input__convert_prestamo input__convert_formulario" type="text" name="tipo_id" id="tipo_id" value='<?php echo ($tipo_id); ?>' style="width: 235px;" placeholder="" autocomplete="off" readonly />
                                </h4>
                            </div>
                            <div class="">
                                <h3 style="color: #fff;">Identificación<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                <h4>
                                    <input class="input__convert input__convert_prestamo input__convert_formulario" type="text" name="cedula" id="cedula" value='<?php if ($_SESSION['cedula_formu'] != "") {
                                                                                                                                                                        echo $_SESSION['cedula_formu'];
                                                                                                                                                                    } else {
                                                                                                                                                                        echo "";
                                                                                                                                                                    } ?>' style="width: 235px;" placeholder="" autocomplete="off" readonly />
                                </h4>
                                <br>
                            </div>

                        </div>
                    </form>

                    <form name="datos1" id="datos1">
                        <div class="specialty__category_formulario_3">

                            <div class="">
                                <h3 style="color: #fff;">Nombre<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                <h4>
                                    <input class="input__convert input__convert_prestamo input__convert_formulario" type="text" name="nombre" id="nombre" value='<?php if ($_SESSION['nombre_formu'] != "") {
                                                                                                                                                                        echo $_SESSION['nombre_formu'];
                                                                                                                                                                    } else {
                                                                                                                                                                        echo "";
                                                                                                                                                                    } ?>' style="width: 180px;" placeholder="" autocomplete="off" readonly />
                                </h4>
                            </div>

                            <div class="medio">
                                <h3 style="color: #fff;">Primer apellido<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                <h4>
                                    <input class="input__convert input__convert_prestamo input__convert_formulario" type="text" name="ape1" id="ape1" value='<?php if ($_SESSION['ape1_formu'] != "") {
                                                                                                                                                                    echo $_SESSION['ape1_formu'];
                                                                                                                                                                } else {
                                                                                                                                                                    echo "";
                                                                                                                                                                } ?>' style="width: 145px;" placeholder="" autocomplete="off" readonly />
                                </h4>
                            </div>

                            <div class="derecha">
                                <h3 style="color: #fff;">Segundo apellido<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                <h4>
                                    <input class="input__convert input__convert_prestamo input__convert_formulario" type="text" name="ape2" id="ape2" value='<?php if ($_SESSION['ape2_formu'] != "") {
                                                                                                                                                                    echo $_SESSION['ape2_formu'];
                                                                                                                                                                } else {
                                                                                                                                                                    echo "";
                                                                                                                                                                } ?>' style="width: 158px;" placeholder="" autocomplete="off" readonly />
                                </h4>
                                <br>
                            </div>
                        </div>
                    </form>

                    <form action="../PHP/enviar_formulario.php" method="POST" onSubmit="return validar();" name="datos2" id="datos2">

                        <input hidden type="text" name="cedulaForm" id="cedulaForm" value='<?php echo $_SESSION['cedula_formu'] ?>' readonly="readonly">
                        <input hidden type="text" name="nombreForm" id="nombreForm" value='<?php echo $_SESSION['nombre_formu'] ?>' readonly="readonly">
                        <input hidden type="text" name="ape1Form" id="ape1Form" value='<?php echo $_SESSION['ape1_formu'] ?>' readonly="readonly">
                        <input hidden type="text" name="ape2Form" id="ape2Form" value='<?php echo $_SESSION['ape2_formu'] ?>' readonly="readonly">


                        <h3 style="color: #fff;">Correo electrónico<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                        <h4>
                            <input class="input__convert input__convert_prestamo caja" style="width: 97%;" type="email" name="email" id="email" value='<?php if ($_SESSION['correo_formu'] != "") {
                                                                                                                                                            echo $_SESSION['correo_formu'];
                                                                                                                                                        } else {
                                                                                                                                                            echo "";
                                                                                                                                                        } ?>' placeholder="" autocomplete="off" />
                        </h4>
                        <br>

                        <div class="specialty__category_formulario_2">

                            <div class="">
                                <h3 style="color: #fff;">Categoría de préstamo<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                <h4>
                                    <input class="input__convert input__convert_prestamo input__convert_formulario" type="text" name="cat_id" id="cat_id" value='<?php echo $_SESSION['cate'] ?>' style="width: 230px;" placeholder="" autocomplete="off" readonly />
                                </h4>
                            </div>
                            <div class="">
                                <h3 style="color: #fff;">Tipo de préstamo<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                <h4>
                                    <input class="input__convert input__convert_prestamo input__convert_formulario" type="text" name="tipo_pres_id" id="tipo_pres_id" value='<?php echo $_SESSION['prest'] ?>' style="width: 242px;" placeholder="" autocomplete="off" readonly />
                                </h4>
                            </div>
                        </div>

                        <div style="margin-top: 15px;">

                            <label style="color: #fff">
                                <input type="checkbox" id="terminos" name="terminos" value="" data-required="1" style="margin: 5px;">
                                Aceptar los <a style="color: hsl(197, 100%, 35%); cursor: pointer;" onclick="document.getElementById('id01').style.display='block'">Términos y Condiciones</a>.
                            </label>
                        </div>
                        <br><br>

                        <div class="specialty__category_formulario_2">

                            <div class="">
                                <div class="g-recaptcha" data-sitekey="6LfsJ_YeAAAAAKoJi_ayso6wUv4_ziuqtE7V9Ien"></div>
                            </div>

                            <div class="">
                                <div style="text-align: right; margin-top: -5px; margin-top: 11px;">
                                    <button type="submit" class="button specialty__button pulse" style="margin-right: 15px;"><span>ENVIAR SOLICITUD</span></button>
                                </div>
                            </div>

                        </div>

                    </form>

                </div>

            </div>

            </div>
            </div>

            </div>
        </section>

        <div id="id01" class="modal">

            <div class="modal-content animate">
                <div class="imgcontainer_formulario">
                    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                    <img src="../assets/img/terminos.png" alt="Avatar" class="avatar_formulario">
                </div>

                <div class="modal_container_formulario">
                    <h3><b>Información Legal</b></h3></br>
                    <label>El grupo financiero BAJA le informa que, al aceptar los términos y condiciones en esta solicitud, autorizo y doy consentimiento a los funcionarios a realizar consultas en bases de datos con el fin de evaluarme como posible cliente de operaciones de crédito. La información aquí brindada se tratará de forma confidencial.</label>
                    </br></br>                    
                    <label>La autorización incluye la creación de un usuario y contraseña para poder acceder a la sucursal electrónica en la que podrá visualizar el estado de la operación solicitada. Dicho usuario y contraseña le serán enviados al correo electrónico registrado en el formulario.</label>
                    </br></br>                    
                    <label>La aceptación de los términos y condiciones aquí descritos no garantizan la aprobación del crédito solicitado. La solicitud y el monto quedan sujetos a la aprobación por parte de los funcionarios del banco.</label>

                    <button onclick="document.getElementById('id01').style.display='none'" class="modal_btn button button_formulario pulse">Aceptar</button>
                </div>
                <div class="modal_container" style="background-color:#f1f1f1">
                </div>
            </div>
        </div>

        <script>
            // Get the modal
            var modal = document.getElementById('id01');

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>


        <script>
            function validar() {

                <?php
                if ($_SESSION['moneda_final'] == 'COLONES') {
                ?>
                    var x = document.p.monto_solicita_col.value;
                    if (x == "") {
                        alert("Debe ingresar un monto para realizar la solicitud.");
                        return false;
                    }

                    if (x >= <?php echo $min_col ?> && x <= <?php echo $max_col ?>) {

                    } else {
                        alert("Ingrese un monto entre <?php echo 'CRC ' . number_format($min_col, 2) . " y " . 'CRC ' . number_format($max_col, 2) ?>.");
                        return false;
                    }

                <?php
                } else if ($_SESSION['moneda_final'] != 'COLONES') {
                ?>
                    var x = document.q.monto_solicita_dol.value;
                    if (x == "") {
                        alert("Debe ingresar un monto para realizar la solicitud.");
                        return false;
                    }

                    if (x >= <?php echo $min_dol ?> && x <= <?php echo $max_dol ?>) {

                    } else {
                        alert("Ingrese un monto entre <?php echo '$ ' . number_format($min_dol, 2) . " y " . '$ ' . number_format($max_dol, 2) ?>.");
                        return false;
                    }
                <?php
                }
                ?>

                var ced = document.datos0.cedula.value;
                var nam = document.datos1.nombre.value;
                var ap1 = document.datos1.ape1.value;
                var ap2 = document.datos1.ape2.value;
                var em = document.datos2.email.value;

                if ((ced == "") || (nam == "") || (ap1 == "") || (ap2 == "") || (em == "")) {
                    alert("Debe buscar su información e ingresar su correo electrónico.");
                    return false;
                }

                var response = grecaptcha.getResponse();

                if (document.getElementById('terminos').checked) {

                    if (response.length == 0) {
                        alert("Captcha no verificado");
                        return false;
                    } else {
                        return true;
                    }

                } else {
                    alert("Debe aceptar los Terminos y Codiciones para poder enviar la solicitud.");
                    return false;
                }
            }
        </script>

        <script>
            var slider_col = document.getElementById("range_col");
            var output_col = document.getElementById("demo_col");
            output_col.innerHTML = slider_col.value;

            // Update the current slider value (each time you drag the slider handle)
            slider_col.oninput = function() {
                output_col.innerHTML = this.value;
            }
        </script>

        <script>
            var slider_dol = document.getElementById("range_dol");
            var output_dol = document.getElementById("demo_dol");
            output_dol.innerHTML = slider_dol.value;

            // Update the current slider value (each time you drag the slider handle)
            slider_dol.oninput = function() {
                output_dol.innerHTML = this.value;
            }
        </script>

        <script>
            function cuota_col() {
                try {

                    var a = parseFloat(document.p.monto_solicita_col.value),
                        b = parseFloat(document.p.range_col.value),
                        c = parseFloat(document.p.tasa_col.value),
                        s = 'CRC ';

                    if (a >= <?php echo $min_col ?> && a <= <?php echo $max_col ?>) {

                        a_final = (-a);
                        b_final = (b * 12);
                        c_final = (c / 1200);
                        b_c_final = Math.pow(1 + c_final, b_final);
                        d = -c_final * a_final * (b_c_final) / (b_c_final - 1);

                        var d_final = parseFloat(d).toFixed(2);
                        var d__final = parseFloat(d_final).toLocaleString('en');
                        s_d_final = s + d__final;

                        document.p.cuota_mensual_col.value = s_d_final;
                        document.p.cuota_mensual_natural_col.value = d_final;

                    } else {
                        document.p.cuota_mensual_col.value = "";
                        document.p.cuota_mensual_natural_col.value = "";
                    }


                } catch (e) {}
            }

            function cuota_dol() {
                try {

                    var a = parseFloat(document.q.monto_solicita_dol.value),
                        b = parseFloat(document.q.range_dol.value),
                        c = parseFloat(document.q.tasa_dol.value),
                        s = '$ ';

                    if (a >= <?php echo $min_dol ?> && a <= <?php echo $max_dol ?>) {

                        a_final = (-a);
                        b_final = (b * 12);
                        c_final = (c / 1200);
                        b_c_final = Math.pow(1 + c_final, b_final);
                        d = -c_final * a_final * (b_c_final) / (b_c_final - 1);

                        var d_final = parseFloat(d).toFixed(2);
                        var d__final = parseFloat(d_final).toLocaleString('en');
                        s_d_final = s + d__final;
                        document.q.cuota_mensual_dol.value = s_d_final;
                        document.q.cuota_mensual_natural_dol.value = d_final;

                    } else {
                        document.q.cuota_mensual_dol.value = "";
                        document.q.cuota_mensual_natural_dol.value = "";
                    }

                } catch (e) {}
            }

            function myFunction_col(id, id2) {

                document.getElementById(id).style.backgroundColor = "#009ad6";
                document.getElementById(id2).style.backgroundColor = "#004480";

                document.getElementById("monto_solicita_col").value = "<?php if ($_SESSION['moneda_final'] == 'COLONES') {
                                                                            echo $_SESSION['monto_solicita_final'];
                                                                        } else {
                                                                        } ?>";
                document.getElementById("monto_solicita_dol").value = "<?php if ($_SESSION['moneda_final'] != 'COLONES') {
                                                                            echo $_SESSION['monto_solicita_final'];
                                                                        } else {
                                                                        } ?>";

                document.getElementById("range_col").value = "<?php if ($_SESSION['moneda_final'] == 'COLONES') {
                                                                    echo $_SESSION['range_final'];
                                                                } else {
                                                                    echo $plazoMax_col;
                                                                } ?>";
                document.getElementById("range_dol").value = "<?php if ($_SESSION['moneda_final'] != 'COLONES') {
                                                                    echo $_SESSION['range_final'];
                                                                } else {
                                                                    echo $plazoMax_dol;
                                                                } ?>";

                document.getElementById("tasa_col").value = "<?php if ($_SESSION['moneda_final'] == 'COLONES') {
                                                                    echo $_SESSION['tasa_final'];
                                                                } else {
                                                                    echo $tasaInteres_col;
                                                                } ?>";
                document.getElementById("tasa_dol").value = "<?php if ($_SESSION['moneda_final'] != 'COLONES') {
                                                                    echo $_SESSION['tasa_final'];
                                                                } else {
                                                                    echo $tasaInteres_dol;
                                                                } ?>";

                document.getElementById("cuota_mensual_col").value = "<?php if ($_SESSION['moneda_final'] == 'COLONES') {
                                                                            echo $_SESSION['cuota_mensual_final'];
                                                                        } else {
                                                                        } ?>";
                document.getElementById("cuota_mensual_dol").value = "<?php if ($_SESSION['moneda_final'] != 'COLONES') {
                                                                            echo $_SESSION['cuota_mensual_final'];
                                                                        } else {
                                                                        } ?>";


                var x = document.getElementById("DIV_col");
                var y = document.getElementById("DIV_dol");
                if (x.style.display === "none") {
                    y.style.display = "none";
                    x.style.display = "block";
                } else {}
            }

            function myFunction_dol(id, id2) {

                document.getElementById(id).style.backgroundColor = "#009ad6";
                document.getElementById(id2).style.backgroundColor = "#004480";

                document.getElementById("monto_solicita_col").value = "<?php if ($_SESSION['moneda_final'] == 'COLONES') {
                                                                            echo $_SESSION['monto_solicita_final'];
                                                                        } else {
                                                                        } ?>";
                document.getElementById("monto_solicita_dol").value = "<?php if ($_SESSION['moneda_final'] != 'COLONES') {
                                                                            echo $_SESSION['monto_solicita_final'];
                                                                        } else {
                                                                        } ?>";

                document.getElementById("range_col").value = "<?php if ($_SESSION['moneda_final'] == 'COLONES') {
                                                                    echo $_SESSION['range_final'];
                                                                } else {
                                                                    echo $plazoMax_col;
                                                                } ?>";
                document.getElementById("range_dol").value = "<?php if ($_SESSION['moneda_final'] != 'COLONES') {
                                                                    echo $_SESSION['range_final'];
                                                                } else {
                                                                    echo $plazoMax_dol;
                                                                } ?>";

                document.getElementById("tasa_col").value = "<?php if ($_SESSION['moneda_final'] == 'COLONES') {
                                                                    echo $_SESSION['tasa_final'];
                                                                } else {
                                                                    echo $tasaInteres_col;
                                                                } ?>";
                document.getElementById("tasa_dol").value = "<?php if ($_SESSION['moneda_final'] != 'COLONES') {
                                                                    echo $_SESSION['tasa_final'];
                                                                } else {
                                                                    echo $tasaInteres_dol;
                                                                } ?>";

                document.getElementById("cuota_mensual_col").value = "<?php if ($_SESSION['moneda_final'] == 'COLONES') {
                                                                            echo $_SESSION['cuota_mensual_final'];
                                                                        } else {
                                                                        } ?>";
                document.getElementById("cuota_mensual_dol").value = "<?php if ($_SESSION['moneda_final'] != 'COLONES') {
                                                                            echo $_SESSION['cuota_mensual_final'];
                                                                        } else {
                                                                        } ?>";

                var x = document.getElementById("DIV_col");
                var y = document.getElementById("DIV_dol");
                if (y.style.display === "none") {
                    x.style.display = "none";
                    y.style.display = "block";
                } else {}
            }
        </script>

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
                            <h2 class="products__price">Rápiditos</h2>
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
            <div class="blog__container container">
                <h2 class="section__title">
                    ¡Nuestros Prestamos Más Solicitados!
                </h2>

                <div class="blog__content grid">

                    <?php
                    $queryMax = "SELECT * FROM aalvarado.MAS_SOLICITADOS";
                    $result = sqlsrv_query($con, $queryMax);
                    $i = 1;
                    while ($row = sqlsrv_fetch_array($result)) {

                        $Categoria = $row['Categoria'];
                        $Prestamo = $row['Prestamo'];
                        $Solicitudes = $row['Solicitudes'];

                        if ($i == 1) {
                    ?>

                            <article class="blog__card zoom">

                                <?php
                                if (substr($Prestamo, 0, -8) == "Gastos Personales") {
                                ?>
                                    <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Personal/gastos_personales.php#calculador" class="">
                                    <?php
                                } else if (substr($Prestamo, 0, -8) == "Rapidos") {
                                    ?>
                                        <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Personal/rapidos.php#calculador" class="">
                                        <?php
                                    } else if (substr($Prestamo, 0, -8) == "Construccion Vivienda") {
                                        ?>
                                            <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Vivienda/construccion_vivienda.php#calculador" class="">
                                            <?php
                                        } else if (substr($Prestamo, 0, -8) == "Interes Social") {
                                            ?>
                                                <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Vivienda/vivienda_interes_social.php#calculador" class="">
                                                <?php
                                            } else if (substr($Prestamo, 0, -8) == "Vehiculo Nuevo") {
                                                ?>
                                                    <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Vehiculo/vehiculo_nuevo.php#calculador" class="">
                                                    <?php
                                                } else if (substr($Prestamo, 0, -8) == "Vehiculo Usado") {
                                                    ?>
                                                        <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Vehiculo/vehiculo_usado.php#calculador" class="">
                                                        <?php
                                                    } else if (substr($Prestamo, 0, -8) == "Viajes Internacionales") {
                                                        ?>
                                                            <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Viajes/viajes_internacionales.php#calculador" class="">
                                                            <?php
                                                        } else if (substr($Prestamo, 0, -8) == "Viajes Nacionales") {
                                                            ?>
                                                                <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Viajes/viajes_nacionales.php#calculador" class="">
                                                                <?php
                                                            } else if (substr($Prestamo, 0, -8) == "Pago Tarjetas de Credito") {
                                                                ?>
                                                                    <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Unificacion/pagos_tarjeta_credito.php#calculador" class="">
                                                                    <?php
                                                                } else if (substr($Prestamo, 0, -8) == "Prestamos otras instituciones") {
                                                                    ?>
                                                                        <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Unificacion/prestamos_de_otras_instituciones.php#calculador" class="">
                                                                        <?php
                                                                    }
                                                                        ?>

                                                                        <div class="blog__image">
                                                                            <img src="<?php echo "../assets/img/" . substr($Prestamo, 0, -8) . ".png" ?>" alt="" class="blog__img">

                                                                        </div>
                                                                        <div class="blog__data">
                                                                            <h2 class="blog__title">
                                                                                <?php echo $Prestamo ?>
                                                                            </h2>

                                                                            <?php
                                                                            if ($Categoria == "Personales") {
                                                                            ?>
                                                                                <p class="blog__description">
                                                                                    Solicitá tu préstamo personal y hacé realidad todos los planes que has estado posponiendo.
                                                                                </p>
                                                                            <?php
                                                                            } else if ($Categoria == "Vivienda") {
                                                                            ?>
                                                                                <p class="blog__description">
                                                                                    Te ofrecemos una solución ágil de financiamiento para que estrenés en menor tiempo tu nuevo hogar.
                                                                                </p>
                                                                            <?php
                                                                            } else if ($Categoria == "Vehiculos") {
                                                                            ?>
                                                                                <p class="blog__description">
                                                                                    Te ofrecemos tasas competitivas y rápidos tiempos de respuesta para comprar tu carro nuevo o usado.
                                                                                </p>
                                                                            <?php
                                                                            } else if ($Categoria == "Viajes") {
                                                                            ?>
                                                                                <p class="blog__description">
                                                                                    Nosotros le ayudamos a cumplir sus sueños de viajar y disfrutar.
                                                                                </p>
                                                                            <?php
                                                                            } else if ($Categoria == "Unificacion de deudas") {
                                                                            ?>
                                                                                <p class="blog__description">
                                                                                    Este financiamiento le permite ganar paz mientras unifica todas sus deudas.
                                                                                </p>
                                                                            <?php
                                                                            }
                                                                            ?>

                                                                            <?php
                                                                            $queryNum = "SELECT COUNT(*) AS NUM FROM aalvarado.visitas WHERE pagina = '" . substr($Prestamo, 0, -8) . "'";
                                                                            $resultNum = sqlsrv_query($con, $queryNum);
                                                                            while ($rowNum = sqlsrv_fetch_array($resultNum)) {

                                                                                $NUM = $rowNum['NUM'];
                                                                            }

                                                                            ?>

                                                                            <div class="blog__footer">
                                                                                <div class="blog__reaction">
                                                                                    <i class='bx bxs-edit'></i>
                                                                                    <span><?php echo $Solicitudes ?></span>
                                                                                </div>
                                                                                <div class="blog__reaction">
                                                                                    <i class='bx bx-show'></i>
                                                                                    <span><?php echo $NUM ?></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        </a>
                            </article>

                        <?php
                        } else if ($i == 2) {
                        ?>

                            <article class="blog__card zoom">

                                <?php
                                if (substr($Prestamo, 0, -8) == "Gastos Personales") {
                                ?>
                                    <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Personal/gastos_personales.php#calculador" class="">
                                    <?php
                                } else if (substr($Prestamo, 0, -8) == "Rapidos") {
                                    ?>
                                        <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Personal/rapidos.php#calculador" class="">
                                        <?php
                                    } else if (substr($Prestamo, 0, -8) == "Construccion Vivienda") {
                                        ?>
                                            <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Vivienda/construccion_vivienda.php#calculador" class="">
                                            <?php
                                        } else if (substr($Prestamo, 0, -8) == "Interes Social") {
                                            ?>
                                                <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Vivienda/vivienda_interes_social.php#calculador" class="">
                                                <?php
                                            } else if (substr($Prestamo, 0, -8) == "Vehiculo Nuevo") {
                                                ?>
                                                    <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Vehiculo/vehiculo_nuevo.php#calculador" class="">
                                                    <?php
                                                } else if (substr($Prestamo, 0, -8) == "Vehiculo Usado") {
                                                    ?>
                                                        <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Vehiculo/vehiculo_usado.php#calculador" class="">
                                                        <?php
                                                    } else if (substr($Prestamo, 0, -8) == "Viajes Internacionales") {
                                                        ?>
                                                            <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Viajes/viajes_internacionales.php#calculador" class="">
                                                            <?php
                                                        } else if (substr($Prestamo, 0, -8) == "Viajes Nacionales") {
                                                            ?>
                                                                <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Viajes/viajes_nacionales.php#calculador" class="">
                                                                <?php
                                                            } else if (substr($Prestamo, 0, -8) == "Pago Tarjetas de Credito") {
                                                                ?>
                                                                    <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Unificacion/pagos_tarjeta_credito.php#calculador" class="">
                                                                    <?php
                                                                } else if (substr($Prestamo, 0, -8) == "Prestamos otras instituciones") {
                                                                    ?>
                                                                        <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Unificacion/prestamos_de_otras_instituciones.php#calculador" class="">
                                                                        <?php
                                                                    }
                                                                        ?>

                                                                        <div class="blog__image">
                                                                            <img src="<?php echo "../assets/img/" . substr($Prestamo, 0, -8) . ".png" ?>" alt="" class="blog__img">

                                                                        </div>
                                                                        <div class="blog__data">
                                                                            <h2 class="blog__title">
                                                                                <?php echo $Prestamo ?>
                                                                            </h2>

                                                                            <?php
                                                                            if ($Categoria == "Personales") {
                                                                            ?>
                                                                                <p class="blog__description">
                                                                                    Solicitá tu préstamo personal y hacé realidad todos los planes que has estado posponiendo.
                                                                                </p>
                                                                            <?php
                                                                            } else if ($Categoria == "Vivienda") {
                                                                            ?>
                                                                                <p class="blog__description">
                                                                                    Te ofrecemos una solución ágil de financiamiento para que estrenés en menor tiempo tu nuevo hogar.
                                                                                </p>
                                                                            <?php
                                                                            } else if ($Categoria == "Vehiculos") {
                                                                            ?>
                                                                                <p class="blog__description">
                                                                                    Te ofrecemos tasas competitivas y rápidos tiempos de respuesta para comprar tu carro nuevo o usado.
                                                                                </p>
                                                                            <?php
                                                                            } else if ($Categoria == "Viajes") {
                                                                            ?>
                                                                                <p class="blog__description">
                                                                                    Nosotros le ayudamos a cumplir sus sueños de viajar y disfrutar.
                                                                                </p>
                                                                            <?php
                                                                            } else if ($Categoria == "Unificacion de deudas") {
                                                                            ?>
                                                                                <p class="blog__description">
                                                                                    Este financiamiento le permite ganar paz mientras unifica todas sus deudas.
                                                                                </p>
                                                                            <?php
                                                                            }
                                                                            ?>

                                                                            <?php
                                                                            $queryNum = "SELECT COUNT(*) AS NUM FROM aalvarado.visitas WHERE pagina = '" . substr($Prestamo, 0, -8) . "'";
                                                                            $resultNum = sqlsrv_query($con, $queryNum);
                                                                            while ($rowNum = sqlsrv_fetch_array($resultNum)) {

                                                                                $NUM = $rowNum['NUM'];
                                                                            }

                                                                            ?>

                                                                            <div class="blog__footer">
                                                                                <div class="blog__reaction">
                                                                                    <i class='bx bxs-edit'></i>
                                                                                    <span><?php echo $Solicitudes ?></span>
                                                                                </div>
                                                                                <div class="blog__reaction">
                                                                                    <i class='bx bx-show'></i>
                                                                                    <span><?php echo $NUM ?></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        </a>
                            </article>

                        <?php
                        } else if ($i == 3) {
                        ?>

                            <article class="blog__card zoom">

                                <?php
                                if (substr($Prestamo, 0, -8) == "Gastos Personales") {
                                ?>
                                    <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Personal/gastos_personales.php#calculador" class="">
                                    <?php
                                } else if (substr($Prestamo, 0, -8) == "Rapidos") {
                                    ?>
                                        <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Personal/rapidos.php#calculador" class="">
                                        <?php
                                    } else if (substr($Prestamo, 0, -8) == "Construccion Vivienda") {
                                        ?>
                                            <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Vivienda/construccion_vivienda.php#calculador" class="">
                                            <?php
                                        } else if (substr($Prestamo, 0, -8) == "Interes Social") {
                                            ?>
                                                <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Vivienda/vivienda_interes_social.php#calculador" class="">
                                                <?php
                                            } else if (substr($Prestamo, 0, -8) == "Vehiculo Nuevo") {
                                                ?>
                                                    <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Vehiculo/vehiculo_nuevo.php#calculador" class="">
                                                    <?php
                                                } else if (substr($Prestamo, 0, -8) == "Vehiculo Usado") {
                                                    ?>
                                                        <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Vehiculo/vehiculo_usado.php#calculador" class="">
                                                        <?php
                                                    } else if (substr($Prestamo, 0, -8) == "Viajes Internacionales") {
                                                        ?>
                                                            <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Viajes/viajes_internacionales.php#calculador" class="">
                                                            <?php
                                                        } else if (substr($Prestamo, 0, -8) == "Viajes Nacionales") {
                                                            ?>
                                                                <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Viajes/viajes_nacionales.php#calculador" class="">
                                                                <?php
                                                            } else if (substr($Prestamo, 0, -8) == "Pago Tarjetas de Credito") {
                                                                ?>
                                                                    <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Unificacion/pagos_tarjeta_credito.php#calculador" class="">
                                                                    <?php
                                                                } else if (substr($Prestamo, 0, -8) == "Prestamos otras instituciones") {
                                                                    ?>
                                                                        <a href="https://intelligent-hellman.138-59-135-33.plesk.page/Prestamos/Unificacion/prestamos_de_otras_instituciones.php#calculador" class="">
                                                                        <?php
                                                                    }
                                                                        ?>

                                                                        <div class="blog__image">
                                                                            <img src="<?php echo "../assets/img/" . substr($Prestamo, 0, -8) . ".png" ?>" alt="" class="blog__img">

                                                                        </div>
                                                                        <div class="blog__data">
                                                                            <h2 class="blog__title">
                                                                                <?php echo $Prestamo ?>
                                                                            </h2>

                                                                            <?php
                                                                            if ($Categoria == "Personales") {
                                                                            ?>
                                                                                <p class="blog__description">
                                                                                    Solicitá tu préstamo personal y hacé realidad todos los planes que has estado posponiendo.
                                                                                </p>
                                                                            <?php
                                                                            } else if ($Categoria == "Vivienda") {
                                                                            ?>
                                                                                <p class="blog__description">
                                                                                    Te ofrecemos una solución ágil de financiamiento para que estrenés en menor tiempo tu nuevo hogar.
                                                                                </p>
                                                                            <?php
                                                                            } else if ($Categoria == "Vehiculos") {
                                                                            ?>
                                                                                <p class="blog__description">
                                                                                    Te ofrecemos tasas competitivas y rápidos tiempos de respuesta para comprar tu carro nuevo o usado.
                                                                                </p>
                                                                            <?php
                                                                            } else if ($Categoria == "Viajes") {
                                                                            ?>
                                                                                <p class="blog__description">
                                                                                    Nosotros le ayudamos a cumplir sus sueños de viajar y disfrutar.
                                                                                </p>
                                                                            <?php
                                                                            } else if ($Categoria == "Unificacion de deudas") {
                                                                            ?>
                                                                                <p class="blog__description">
                                                                                    Este financiamiento le permite ganar paz mientras unifica todas sus deudas.
                                                                                </p>
                                                                            <?php
                                                                            }
                                                                            ?>

                                                                            <?php
                                                                            $queryNum = "SELECT COUNT(*) AS NUM FROM aalvarado.visitas WHERE pagina = '" . substr($Prestamo, 0, -8) . "'";
                                                                            $resultNum = sqlsrv_query($con, $queryNum);
                                                                            while ($rowNum = sqlsrv_fetch_array($resultNum)) {

                                                                                $NUM = $rowNum['NUM'];
                                                                            }

                                                                            ?>

                                                                            <div class="blog__footer">
                                                                                <div class="blog__reaction">
                                                                                    <i class='bx bxs-edit'></i>
                                                                                    <span><?php echo $Solicitudes ?></span>
                                                                                </div>
                                                                                <div class="blog__reaction">
                                                                                    <i class='bx bx-show'></i>
                                                                                    <span><?php echo $NUM ?></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        </a>
                            </article>

                    <?php
                        }

                        $i++;
                    }

                    ?>

                </div>

            </div>
        </section>
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