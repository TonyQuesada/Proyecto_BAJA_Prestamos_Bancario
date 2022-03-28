<?php
include '../conection.php';
session_start();

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

$num_soli = 0;
$fecha_soli = date_create("YYYY-MM-DD");
$num_id = 0;
$cat_pres = '';
$tip_pres = '';
$moneda = '';
$monto_sol = 0;
$tasa = 0;
$cuota = 0;
$plazo = 0;
$estado = '';

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

    <title>Asignación de solicitudes</title>
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
                                    <?php
                                    $queryNum = "SELECT COUNT(*) AS NUM FROM aalvarado.VER_SOLICITUDES_PENDIENTES";
                                    $resultNum = sqlsrv_query($con, $queryNum);
                                    while ($rowNum = sqlsrv_fetch_array($resultNum)) {
                                        $NUM = $rowNum['NUM'];
                                    }
                                    ?>

                                    <i class='bx bx-folder-open'></i> Asignar Préstamos <span <?php if ($NUM >= 1) { ?> class="numberCircle" <?php } else { ?> class="" <?php } ?>><?php if ($NUM >= 1) {
                                                                                                                                                                                        echo $NUM;
                                                                                                                                                                                    } else {
                                                                                                                                                                                        echo "";
                                                                                                                                                                                    } ?></span>
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
                        ASIGNACIÓN DE SOLICITUDES<span>.</span>
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
            <video src="../assets/video/TramitadorAsignar.mp4" class="home__video" type="video/mp4" autoPlay loop muted playsInline></video>

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
                    ¡Asignación de Solicitudes de Crédito! <span style="color: #009ad6; margin-left: 15px;"><?php if ($NUM >= 2) {
                                                                                                                echo "( " . $NUM . " - Pendientes )";
                                                                                                            } else if ($NUM = 1) {
                                                                                                                echo "( " . $NUM . " - Pendiente )";
                                                                                                            } else {
                                                                                                                echo "";
                                                                                                            } ?></span>
                </h2>

                <div class="specialty__category_tabla">

                    <div class="items">
                        <h3 type="text" style="color: #fff;">Buscar<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                        <input type="text" class="input__convert" style="width: 262px;" id="Buscar" placeholder="">
                        <br>
                        <br>
                    </div>

                    <form action="../PHP/asignar_solicitud.php" method="POST" name="input">

                        <table class="table" id="tableData" name="tableData">
                            <thead class="thead">
                                <tr>
                                    <th class="th" style="width: 20px;">#</th>
                                    <th class="th">Fecha solicitud</th>
                                    <th class="th">Identificación</th>
                                    <th class="th">Categoría</th>
                                    <th class="th">Tipo de préstamo</th>
                                    <th class="th">Moneda</th>
                                    <th class="th">Monto</th>
                                    <th class="th">Tasa</th>
                                    <th class="th">Cuota</th>
                                    <th class="th">Plazo</th>
                                    <th class="th">Estado</th>
                                    <th class="th">Asignación</th>
                                </tr>
                            </thead>

                            <tbody class="tbody">
                                <?php
                                $query = "SELECT * FROM aalvarado.VER_SOLICITUDES_PENDIENTES";
                                $ejecutar = sqlsrv_query($con, $query);

                                while ($fila = sqlsrv_fetch_array($ejecutar)) {
                                    $num_soli = $fila['NUMERO_SOLICITUD'];
                                    $fecha_soli = $fila['FECHA_DE_SOLICITUD'];
                                    $num_id = $fila['NUMERO_IDENTIFICACION'];
                                    $cat_pres = $fila['CATEGORÍA_PRESTAMO'];
                                    $tip_pres = $fila['TIPO_DE_PRESTAMO'];
                                    $moneda = $fila['MONEDA'];
                                    $monto_sol = $fila['MONTO_SOLICITADO'];
                                    $tasa = $fila['TASA_DE_INTERES'];
                                    $cuota = $fila['CUOTA_MENSUAL'];
                                    $plazo = $fila['PLAZO_EN_ANIOS'];
                                    $estado = $fila['ESTADO_ACTUAL'];

                                    echo
                                    '<tr>
                                        <th class="th">' . $num_soli . '</th>
                                        <td class="td">' . date_format($fecha_soli, "d-m-Y") . '</td>
                                        <td class="td">' . $num_id . '</td>
                                        <td class="td">' . $cat_pres . '</td>
                                        <td class="td">' . substr($tip_pres, 0, -8) . '</td>
                                        <td class="td">' . $moneda . '</td>';
                                            if ($moneda == "Colones") {
                                                echo '<td class="td">₡' . number_format($monto_sol, 2) . '</td>';
                                            } else if ($moneda == "Dolares") {
                                                echo '<td class="td">$' . number_format($monto_sol, 2) . '</td>';
                                            }
                                            echo
                                            '<td class="td">' . $tasa . ' %</td>';
                                            if ($moneda == "Colones") {
                                                echo '<td class="td">₡' . number_format($cuota, 2) . '</td>';
                                            } else if ($moneda == "Dolares") {
                                                echo '<td class="td">$' . number_format($cuota, 2) . '</td>';
                                            }
                                            if ($plazo > 1) {
                                                echo '<td class="td">' . $plazo . ' años</td>';
                                            } else if ($plazo <= 1) {
                                                echo '<td class="td">' . $plazo . ' año</td>';
                                            }
                                            echo
                                        '<td class="th">' . $estado . '</td>                
                                         <td class="td">
                                            <select id="analistas" name="analistas" style="text-align: center;" class="small">
                                                <option selected disabled hidden>SELECCIONE EL ANALISTA</option>';

                                                    $query2 = "SELECT * FROM VER_ANALISTAS WHERE CATEGORIA_PRESTAMOS = '$cat_pres' ";
                                                    $ejecutar2 = sqlsrv_query($con, $query2);
                                                    $nom_ana = '';
                                                    while ($fila2 = sqlsrv_fetch_array($ejecutar2)) {

                                                        $cantidad = "SELECT COUNT(*) AS NUME FROM VER_SOLICITUDES_ASIGNADAS WHERE ANALISTA = '" . $fila2['NOMBRE_ANALISTA'] . "' ";
                                                        $ejecutar3 = sqlsrv_query($con, $cantidad);
                                                        $cantSoli = 0;
                                                        while ($fila3 = sqlsrv_fetch_array($ejecutar3)) {
                                                            $cantSoli = $fila3['NUME'];
                                                        }
                                                echo
                                                '<option class="small" value="' . $fila2['ID_ANALISTA'] . '">' . $fila2['NOMBRE_ANALISTA'] . ' ( ' . $cantSoli . ' )</option>';
                                                // '<option value="' . $fila2['ID_ANALISTA'] . '">' . $fila2['CATEGORIA_PRESTAMOS'] . ' ( ' . $cantSoli . ' )</option>';
                                                     }

                                        echo
                                        '</select>
                                        <button type="submit" class="button_convertir pulse" style="background-color: #009ae0; border: 1px solid #000;" id="num_soli" name="num_soli" value="' . $num_soli . '">ASIGNAR</button></td>
                                    </tr>';
                                }
                                ?>
                            <tbody>

                        </table>

                    </form>


                </div>

            </div>

        </section>

        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../assets/js/paging.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {

                $("#Buscar").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#tableData tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });

                $('#tableData').paging({
                    limit: 5
                });

            });
        </script>

        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-36251023-1']);
            _gaq.push(['_setDomainName', 'jqueryscript.net']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();
        </script>

        <script>
            function onlyOne(checkbox) {
                var checkboxes = document.getElementsByName('num_soli')
                checkboxes.forEach((item) => {
                    if (item !== checkbox) item.checked = false
                })
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