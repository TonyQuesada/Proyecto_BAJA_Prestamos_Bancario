<?php
include '../conection.php';
session_start();

if ($_SESSION['u_idRol'] != 1) {
    header('Location: ../index.php');
}

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


include_once "funciones.php";
$hoy = fechaHoy();
list($inicio, $fin) = fechaInicioYFinDeMes();
if (isset($_GET["inicio"])) {
    $inicio = $_GET["inicio"];
}
if (isset($_GET["fin"])) {
    $fin = $_GET["fin"];
}
if (isset($_GET["hoy"])) {
    $hoy = $_GET["hoy"];
}
$visitasYVisitantes = obtenerConteoVisitasYVisitantesEnRango($hoy, $hoy);
$paginas = obtenerPaginasVisitadasEnFecha($hoy);
$visitantes = obtenerVisitantesEnRango($inicio, $fin);
$visitas = obtenerVisitasEnRango($inicio, $fin);

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


    <link rel="stylesheet" href="../assets/css/contador.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />

    <title>Reporte de visitas - BAJA</title>
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

                    <!-- PHP -->
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
                                <a href="#dashboard" class="nav__link i__scroll">
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
                        REPORTE DE VISITAS<span>.</span>
                    </h1>
                    <p class="home__description">
                        <!-- Crédito aprobado en menos de 3 horas. Plazos de hasta 60 meses. <span style="color: hsla(197, 100%, 42%, 0.8);">Fácil y rápido.</span> -->
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
            <video src="../assets/video/Contador1.mp4" class="home__video" type="video/mp4" autoPlay loop muted playsInline></video>

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
        <section class="section container specialty" id="dashboard">
            <h2 class="section__title">
                ¡Reporte estadistico de las visitas!
            </h2>
        </section>

        <section class="section_dash">
            <div class="columns">

                <div class="column">
                    <div class="card_dash">
                        <header class="card_dash-header">
                            <p class="card_dash-header-title">
                                Estadísticas entre <?php echo $inicio ?> y <?php echo $fin ?>
                            </p>
                        </header>
                        <div class="card_dash-content">
                            <div class="content">
                                <form action="dashboard.php#dashboard">
                                    <input type="hidden" name="hoy" value="<?php echo $hoy ?>">
                                    <div class="field is-grouped">
                                        <p class="control is-expanded">
                                            <label>Desde: </label>
                                            <input class="input" type="date" name="inicio" value="<?php echo $inicio ?>">
                                        </p>
                                        <p class="control is-expanded">
                                            <label>Hasta: </label>
                                            <input class="input" type="date" name="fin" value="<?php echo $fin ?>">
                                        </p>
                                        <p class="control">
                                            <!--La etiqueta es invisible a propósito para que tome el espacio y alinee el botón-->
                                            <label style="color: white;">ª</label>
                                            <input type="submit" value="OK" class="button input pulse" style="color: #fff; background-color: hsl(208, 100%, 25%);">
                                        </p>
                                    </div>
                                </form>
                                <canvas id="grafica"></canvas>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="column is-one-third ">
                    <div class="card_dash">
                        <header class="card_dash-header">
                            <p class="card_dash-header-title">
                                Estadísticas de <?php echo $hoy ?>
                            </p>
                        </header>
                        <div class="card_dash-content">
                            <div class="content">
                                <form action="dashboard.php#dashboard" class="mb-2">
                                    <input type="hidden" name="inicio" value="<?php echo $inicio ?>">
                                    <input type="hidden" name="fin" value="<?php echo $fin ?>">
                                    <div class="field is-grouped">
                                        <p class="control is-expanded">
                                            <label>Fecha: </label>
                                            <input class="input" type="date" name="hoy" value="<?php echo $hoy ?>">
                                        </p>
                                        <p class="control">
                                            <!--La etiqueta es invisible a propósito para que tome el espacio y alinee el botón-->
                                            <label style="color: white;">ª</label>
                                            <input type="submit" value="OK" class="button input pulse" style="color: #fff; background-color: hsl(208, 100%, 25%);">
                                        </p>
                                    </div>
                                </form>
                                <div class="field is-grouped is-grouped-multiline">
                                    <div class="control">
                                        <div class="tags has-addons">
                                            <span class="tag is-large" style="background-color: hsl(210, 50%, 75%); color:hsl(206, 12%, 12%)">Visitas</span>
                                            <span class="tag is-info is-large"><?php echo $visitasYVisitantes->visitas ?></span>
                                        </div>
                                    </div>
                                    <div class="control">
                                        <div class="tags has-addons">
                                            <span class="tag is-large" style="background-color: hsl(210, 50%, 75%); color:hsl(206, 12%, 12%)">Visitantes</span>
                                            <span class="tag is-info is-large"><?php echo $visitasYVisitantes->visitantes ?></span>
                                        </div>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Página</th>
                                            <th>Visitas</th>
                                            <th>Visitantes</th>
                                            <th>Estadísticas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($paginas as $pagina) { ?>
                                            <tr>
                                                <td><a class="a" style="color: hsl(208, 100%, 35%);" target="_blank" href="<?php echo $pagina->url ?>"><?php echo $pagina->pagina ?></a></td>
                                                <td><?php echo $pagina->conteo_visitas ?></td>
                                                <td><?php echo $pagina->conteo_visitantes ?></td>
                                                <td>
                                                    <a class="button is-info pulse" href="visitas_url.php?url=<?php echo urlencode($pagina->url) ?>#dashboard">
                                                        <i class="fa fa-chart-area"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <br><br>

        <script type="text/javascript">
            // Pasar variable de PHP a JS
            const visitantes = <?php echo json_encode($visitantes) ?>;
            const visitas = <?php echo json_encode($visitas) ?>;
            // Obtener una referencia al elemento canvas del DOM
            const $grafica = document.querySelector("#grafica");
            // Las etiquetas son las que van en el eje X. 
            // Podemos mapear  visitas o visitantes, ya que solo necesitamos las fechas
            const etiquetas = visitas.map(visita => visita.fecha);
            // Podemos tener varios conjuntos de datos
            const datosVisitas = {
                label: "Visitas",
                data: visitas.map(visita => visita.conteo),
                backgroundColor: 'rgba(237,78,136, 0.2)', // Color de fondo
                borderColor: 'rgba(237,78,136, 1)', // Color del borde
                borderWidth: 1, // Ancho del borde
            };
            const datosVisitantes = {
                label: "Visitantes",
                data: visitantes.map(visitante => visitante.conteo),
                backgroundColor: 'rgba(93,82,247, 0.2)', // Color de fondo
                borderColor: 'rgba(93,82,247,1)', // Color del borde
                borderWidth: 1, // Ancho del borde
            };

            new Chart($grafica, {
                type: 'line', // Tipo de gráfica
                data: {
                    labels: etiquetas,
                    datasets: [
                        datosVisitas,
                        datosVisitantes,
                        // Aquí más datos...
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                    },
                }
            });
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
                            <img src="../../assets/img/footerflag.png" alt="" class="footer__flag">
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