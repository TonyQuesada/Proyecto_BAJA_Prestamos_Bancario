<?php
include '../../conection.php';
session_start();
// if(isset($_SESSION['u_ID']))
// {
//     header('Location: administrador.php');
// }

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
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--=============== FAVICON ===============-->
    <link rel="shortcut icon" href="../../assets/img/favicon.png" type="image/x-icon">

    <!--=============== BOXICONS ===============-->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../../assets/css/styles.css">

    <title>BAJA - Banco Angular Jerárquico Asociado</title>
</head>

<body>
    <!--==================== LOADER ====================-->
    <!-- <div class="load" id="load">
        <img src="../../assets/img/load.gif" alt="" class="load__gif">
        <h1 class="load_h1">
            <span style="color: hsl(197, 100%, 42%);">B</span>anco
            <span style="color: hsl(197, 100%, 42%);">A</span>ngular
            <span style="color: hsl(197, 100%, 42%);">J</span>erárquico
            <span style="color: hsl(197, 100%, 42%);">A</span>sociado
        </h1>
    </div> -->

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
                        <img src="../../assets/img/unknown.png" alt="" class="nav__img">
                    </div>

                    <h2 style="color: hsl(197, 100%, 65%);">BANCA <br> EN LÍNEA</h2>
                </div>

                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="../../Prestamos/login.php" class="nav__link">
                            <i class='bx bx-user'></i> Iniciar Sesión
                        </a>
                    </li>
                <?php
            } else if ($sesionRol == 3 || $sesionRol == 2 || $sesionRol == 1) {
                ?>
                    <div class="nav__data">
                        <div class="nav__mask">
                            <img src="../../assets/img/userAdmin.png" alt="" class="nav__img">
                        </div>

                        <span class="nav__greeting">Bienvenid@</span>
                        <h1 class="nav__name"><?php echo $_SESSION['u_Nombre_Usuario'] ?></h1>
                    </div>

                    <!-- PHP -->
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="../../Prestamos/cliente_perfil.php" class="nav__link">
                                <i class='bx bx-user'></i> Perfil
                            </a>
                        </li>
                    <?php
                } else if ($sesionRol == 4) {
                    ?>
                        <div class="nav__data">
                            <div class="nav__mask">
                                <img src="../../assets/img/userMale.png" alt="" class="nav__img">
                            </div>

                            <span class="nav__greeting">Bienvenid@</span>
                            <h1 class="nav__name"><?php echo $_SESSION['u_Nombre_Usuario'] ?></h1>
                        </div>

                        <ul class="nav__list">
                            <li class="nav__item">
                                <a href="../../Prestamos/cliente_perfil.php" class="nav__link">
                                    <i class='bx bx-user'></i> Perfil
                                </a>
                            </li>
                        <?php
                    }
                        ?>
                        <li class="nav__item">
                            <a href="#home" class="nav__link active-link">
                                <i class='bx bx-home'></i> Inicio
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="#calculador" class="nav__link">
                                <i class='bx bxs-calculator'></i> Calculadora
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="#products" class="nav__link">
                                <i class='bx bx-money'></i> Préstamos
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="#footer" class="nav__link">
                                <i class='bx bx-message-square-detail'></i> Contacto
                            </a>
                        </li>

                        <?php
                        if ($sesionRol != NULL) {
                        ?>
                            <li class="nav__item">
                                <a href="../../PHP/logout.php" class="nav__link">
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

                <a href="../../index.php" class="nav__log" style="margin-bottom: 40px; margin-left: -17px;">
                    <img src="../../assets/img/logo.png" alt="" class="nav__logo-img" style="position: fixed;">

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
                        CONVERTIMOS SUS SUEÑOS EN REALIDAD<span>.</span>
                    </h1>
                    <p class="home__description">
                        Crédito aprobado en menos de 3 horas. Plazos de hasta 60 meses. <span style="color: hsla(197, 100%, 42%, 0.8);">Fácil y rápido.</span>
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
                            <a onclick="myFunction()" class="button_convertir pulse"><span>Compra</span></a>
                            <a onclick="myFunction2()" class="button_convertir pulse"><span>Venta</span></a>
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

                    <a href="#calculador">
                        <img src="../../assets/img/scroll.png" alt="" class="home__scroll">
                    </a>
                </div>
            </div>

            <!-- <img src="../../assets/img/home.gif" alt="" class="home__img"> -->
            <video src="../../assets/video/Personal1.mp4" class="home__video" type="video/mp4" autoPlay loop muted playsInline></video>

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

            function myFunction() {

                document.getElementById("num1_1").value = "";
                document.getElementById("sum_1").value = "";

                var x = document.getElementById("myDIV");
                var y = document.getElementById("myDIV2");
                if (x.style.display === "none") {
                    y.style.display = "none";
                    x.style.display = "block";
                } else {}
            }

            function myFunction2() {

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

        <!-- <style type="text/css">
            /* Styles needed by SpreadsheetConverter */
            *.ee100 {
                color: windowtext;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: bottom
            }

            *.ee103 {
                color: #969696;
                font-family: Arial, sans-serif;
                font-size: 12.00pt;
                font-style: normal;
                font-weight: 700;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: middle
            }

            *.ee109 {
                color: windowtext;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: top
            }

            *.ee112 {
                background: #FAE1DE;
                border-left: 0.50pt solid windowtext;
                border-top: 0.50pt solid windowtext;
                color: windowtext;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: bottom
            }

            *.ee114 {
                background: #FAE1DE;
                border-top: 0.50pt solid windowtext;
                color: windowtext;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: bottom
            }

            *.ee115 {
                background: #FAE1DE;
                border-right: 0.50pt solid windowtext;
                border-top: 0.50pt solid windowtext;
                color: windowtext;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: bottom
            }

            *.ee116 {
                background: white;
                color: windowtext;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: top
            }

            *.ee118 {
                background: #FAE1DE;
                border-left: 0.50pt solid windowtext;
                color: windowtext;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: bottom
            }

            *.ee119 {
                background: #FAE1DE;
                color: windowtext;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: bottom
            }

            *.ee120 {
                color: windowtext;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                padding-left: 0px;
                padding-right: 1px;
                padding-top: 0px;
                text-align: right;
                vertical-align: bottom
            }

            *.ee122 {
                color: windowtext;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                text-align: right;
                vertical-align: bottom
            }

            *.ee123 {
                background: #FAE1DE;
                border-right: 0.50pt solid windowtext;
                color: windowtext;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: bottom
            }

            *.ee124 {
                background: #FAE1DE;
                color: #FAE1DE;
                font-family: Arial, sans-serif;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                padding-left: 0px;
                padding-right: 1px;
                padding-top: 0px;
                text-align: left;
                vertical-align: bottom
            }

            *.ee126 {
                background: #FAE1DE;
                color: #FAE1DE;
                font-family: Arial, sans-serif;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                text-align: left;
                vertical-align: bottom
            }

            *.ee127 {
                background: #FAE1DE;
                color: #FAE1DE;
                font-family: Arial, sans-serif;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: bottom
            }

            *.ee128 {
                color: windowtext;
                font-family: Arial, sans-serif;
                font-size: 8.00pt;
                font-style: normal;
                font-weight: 400;
                padding-left: 0px;
                padding-right: 1px;
                padding-top: 0px;
                text-align: right;
                vertical-align: bottom
            }

            *.ee130 {
                color: windowtext;
                font-family: Arial, sans-serif;
                font-size: 8.00pt;
                font-style: normal;
                font-weight: 400;
                text-align: right;
                vertical-align: bottom
            }

            *.ee131 {
                background: white;
                color: windowtext;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: bottom
            }

            *.ee133 {
                background: white;
                color: windowtext;
                font-family: Arial, sans-serif;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 700;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: bottom
            }

            *.ee136 {
                background: #FAE1DE;
                color: #FAE1DE;
                font-family: Arial, sans-serif;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 700;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: bottom
            }

            *.ee137 {
                background: #FAE1DE;
                color: #FAE1DE;
                font-family: Arial, sans-serif;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 700;
                text-align: left;
                vertical-align: bottom
            }

            *.ee138 {
                background: #FAE1DE;
                color: #FAE1DE;
                font-family: Arial, sans-serif;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 700;
                padding-left: 0px;
                padding-right: 1px;
                padding-top: 0px;
                text-align: left;
                vertical-align: bottom
            }

            *.ee139 {
                background: #F3F3F3;
                border-left: 0.50pt solid windowtext;
                border-top: 0.50pt solid windowtext;
                color: windowtext;
                font-family: Arial, sans-serif;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 700;
                text-align: left;
                vertical-align: bottom;
                padding-top: 8px;
                padding-left: 8px;
                padding-right: 8px;
                padding-bottom: 8px;
            }

            *.ee140 {
                background: #F3F3F3;
                color: windowtext;
                font-family: Arial, sans-serif;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 700;
                text-align: left;
                vertical-align: bottom;
            }

            *.ee141 {
                background: #F3F3F3;
                border-right: 0.50pt solid windowtext;
                border-top: 0.50pt solid windowtext;
                color: windowtext;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                text-align: right;
                vertical-align: bottom;
                padding-top: 8px;
                padding-left: 8px;
                padding-right: 8px;
                padding-bottom: 8px;
            }

            *.ee142 {
                background: #F3F3F3;
                color: windowtext;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                text-align: right;
                vertical-align: bottom
            }

            *.ee143 {
                background: #F3F3F3;
                border-left: 0.50pt solid windowtext;
                color: windowtext;
                font-family: Arial, sans-serif;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 700;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: bottom;
                padding-left: 8px;
                padding-right: 8px;
            }

            *.ee144 {
                background: #F3F3F3;
                border-right: 0.50pt solid windowtext;
                color: windowtext;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                text-align: right;
                vertical-align: bottom;
                padding-left: 8px;
                padding-right: 8px;
            }

            *.ee145 {
                background: #F3F3F3;
                border-bottom: 0.50pt solid windowtext;
                border-left: 0.50pt solid windowtext;
                color: windowtext;
                font-family: Arial, sans-serif;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 700;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: bottom;
                padding-top: 8px;
                padding-left: 8px;
                padding-right: 8px;
                padding-bottom: 8px;
            }

            *.ee146 {
                background: #F3F3F3;
                border-bottom: 0.50pt solid windowtext;
                border-right: 0.50pt solid windowtext;
                color: windowtext;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                text-align: right;
                vertical-align: bottom;
                padding-top: 8px;
                padding-left: 8px;
                padding-right: 8px;
                padding-bottom: 8px;
            }

            *.ee147 {
                background: #F3F3F3;
                color: windowtext;
                font-family: Arial, sans-serif;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 700;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: bottom
            }

            *.ee148 {
                background: #FAE1DE;
                border-bottom: 0.50pt solid windowtext;
                border-left: 0.50pt solid windowtext;
                color: windowtext;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: bottom
            }

            *.ee149 {
                background: #FAE1DE;
                border-bottom: 0.50pt solid windowtext;
                color: windowtext;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: bottom
            }

            *.ee150 {
                background: #FAE1DE;
                border-bottom: 0.50pt solid windowtext;
                border-right: 0.50pt solid windowtext;
                color: windowtext;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: bottom
            }

            *.ee151 {
                color: blue;
                font-family: Arial;
                font-size: 10.00pt;
                font-style: normal;
                font-weight: 400;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: bottom
            }

            *.ee153 {
                color: windowtext;
                font-family: Arial, sans-serif;
                font-size: 8.00pt;
                font-style: normal;
                font-weight: 700;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                text-align: left;
                vertical-align: bottom
            }

            textarea {
                overflow: auto;
            }
        </style>
        <style type="text/css" media="screen">
            .eetabs {
                display: block;
            }
        </style>
        <style type="text/css" media="print">
            .eetabs {
                display: none;
            }
        </style>
        <script language="javascript">
            var co = new Object;

            function recalc_onclick(ctl) {
                if (true) {


                    co.p3D6 = eeparseFloatTh(document.formc.p3D6.value);
                    co.p3D7 = eeparsePercentV(document.formc.p3D7.value);
                    co.p3D8 = eeparseFloat(document.formc.p3D8.value);
                    co.p3D9 = document.formc.p3D9[document.formc.p3D9.selectedIndex].value;
                    calc(co);
                    document.formc.p3E7.value = eeisnumber(co.p3E7) ? eedisplayPercentND(co.p3E7, 2) : co.p3E7;
                    document.formc.p3E9.value = eeisnumber(co.p3E9) ? eedisplayFloat(co.p3E9) : co.p3E9;
                    document.formc.p3D11.value = co.p3D11;
                    document.formc.p3C12.value = co.p3C12;
                    document.formc.p3D12.value = eedatefmt(fmtdate7, co.p3D12);
                    document.formc.p3D13.value = eedatefmt(fmtdate7, co.p3D13);
                    document.formc.p3D14.value = eedatefmt(fmtdate7, co.p3D14);
                };
            };


            var eeisus = 0;
            var eetrue = "VERDADERO";
            var eefalse = "FALSO";
            var eedec = ",";
            var eeth = ".";
            var eedecreg = new RegExp(",", "g");
            var eethreg = new RegExp("[.]", "g");
            var fmtdaynamesshort = new Array("dom", "lun", "mar", "mié", "jue", "vie", "sáb");
            var fmtdaynameslong = new Array("domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado");
            var fmtmonthnamesshort = new Array("ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic");
            var fmtmonthnameslong = new Array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
            var fmtstrings = new Array(",", " ", " ");
            var fmtdate5 = new Array(25, 2, 33, 34);
            var fmtdate6 = new Array(25, 2, 33, 34);
            var fmtdate7 = new Array(25, 2, 33, 34);

            var col10xB29H29 = new Array(7);
            for (var jj = 0; jj < 7; jj++) {
                col10xB29H29[jj] = ""
            };
            var col10xB30H30 = new Array(7);
            for (var jj = 0; jj < 7; jj++) {
                col10xB30H30[jj] = 0
            };
            var col10xB41H41 = new Array(7);
            for (var jj = 0; jj < 7; jj++) {
                col10xB41H41[jj] = ""
            };
            var col10xB42H42 = new Array(7);
            for (var jj = 0; jj < 7; jj++) {
                col10xB42H42[jj] = 0
            };

            function calc(data) {
                var c3D6 = data.p3D6;
                var c3D7 = data.p3D7;
                var c3D8 = data.p3D8;
                var c3D9 = data.p3D9;
                var c3E7 = (((str_eq((c3D9), ("mensuales"))) ? (((v2n(c3D7)) / (12))) : (((str_eq((c3D9), ("trimestrales"))) ? (((v2n(c3D7)) / (4))) : (((str_eq((c3D9), ("semestrales"))) ? (((v2n(c3D7)) / (2))) : (((str_eq((c3D9), ("anuales"))) ? (((c3D7 == "") ? 0 : c3D7)) : ("")))))))));
                var c3E9 = (((str_eq((c3D9), ("mensuales"))) ? (12) : (((str_eq((c3D9), ("trimestrales"))) ? (4) : (((str_eq((c3D9), ("semestrales"))) ? (2) : (((str_eq((c3D9), ("anuales"))) ? (1) : ("")))))))));
                var c3D11 = (((str_eq((c3D9), ("mensuales"))) ? ("mensual") : (((str_eq((c3D9), ("trimestrales"))) ? ("trimestral") : (((str_eq((c3D9), ("semestrales"))) ? ("semestral") : (((str_eq((c3D9), ("anuales"))) ? ("anual") : ("")))))))));
                var c3D12 = (((pmt((((v2n(c3D7)) / (v2n(c3E9)))), (((c3D8) * (v2n(c3E9)))), (c3D6), (0), (0))) * (-1)));
                var c3D13 = (((((c3D12) * (v2n(c3E9)))) * (c3D8)));
                var c3D14 = (((c3D13) - (c3D6)));
                var c3C12 = (("Pago") + (" ") + (c3D11));
                data.p3E7 = c3E7;
                data.p3E9 = c3E9;
                data.p3D11 = c3D11;
                data.p3C12 = c3C12;
                data.p3D12 = c3D12;
                data.p3D13 = c3D13;
                data.p3D14 = c3D14;
            };

            function str_eq(x, y) {
                return (x.toLowerCase() == y.toLowerCase())
            };

            function myIsNaN(x) {
                return (isNaN(x) || (typeof x == 'number' && !isFinite(x)));
            };

            function mod(n, d) {
                return n - d * Math.floor(n / d);
            };

            function round(n, nd) {
                if (isFinite(n) && isFinite(nd)) {
                    var sign_n = (n < 0) ? -1 : 1;
                    var abs_n = Math.abs(n);
                    var factor = Math.pow(10, nd);
                    return sign_n * Math.round(abs_n * factor) / factor;
                } else {
                    return NaN;
                }
            };

            function s2n(str) {
                str = String(str).replace(eedecreg, ".");
                return parseFloat(str);
            }

            function b2s(b) {
                return b ? eetrue : eefalse;
            };

            function v2n(v) {
                switch (typeof v) {
                    case "number":
                        return v;
                    case "string":
                        return s2n(v);
                    case "boolean":
                        return v ? 1 : 0;
                    case "object":
                        if (v.constructor == Number) {
                            return v;
                        };
                        if (v.constructor == String) {
                            return s2n(v);
                        };
                        if (v.constructor == Boolean) {
                            return v ? 1 : 0;
                        };
                        return Number.NaN;
                    default:
                        return Number.NaN;
                }
            };

            function eeparseFloat(str) {
                str = String(str).replace(eedecreg, ".");
                var res = parseFloat(str);
                if (isNaN(res)) {
                    return 0;
                } else {
                    return res;
                }
            };

            function eedisplayFloat(x) {
                if (myIsNaN(x)) {
                    return Number.NaN;
                } else {
                    return String(x).replace(/\./g, eedec);
                }
            };

            function eedisplayScientific(x, nd) {
                if (myIsNaN(x)) {
                    return Number.NaN;
                } else {
                    var str = String(x.toExponential(nd));
                    return str.replace(/\./g, eedec);
                }
            };

            function eedisplayFloatND(x, nd) {
                if (myIsNaN(x)) {
                    return Number.NaN;
                } else {
                    var res = round(x, nd);
                    if (nd > 0) {
                        var str = String(res);
                        if (str.indexOf('e') != -1) return str;
                        if (str.indexOf('E') != -1) return str;
                        var parts = str.split('.');
                        if (parts.length < 2) {
                            var decimals = ('00000000000000').substring(0, nd);
                            return (parts[0]).toString() + eedec + decimals;
                        } else {
                            var decimals = ((parts[1]).toString() + '00000000000000').substring(0, nd);
                            return (parts[0]).toString() + eedec + decimals;
                        }
                    } else {
                        return res;
                    }
                }
            };

            function eedisplayPercent(x) {
                if (myIsNaN(x)) {
                    return Number.NaN;
                } else {
                    var tmp = (x * 100).toString() + '%';
                    return tmp.replace(/\./g, eedec);
                }
            };

            function eedisplayPercentND(x, nd) {
                if (myIsNaN(x)) {
                    return Number.NaN;
                } else {
                    return eedisplayFloatND(x * 100, nd) + '%';
                }
            }

            function eeparseFloatTh(str) {
                str = String(str).replace(eethreg, "");
                str = String(str).replace(eedecreg, ".");
                var res = parseFloat(str);
                if (isNaN(res)) {
                    return 0;
                } else {
                    return res;
                }
            };

            function eedisplayFloatNDTh(x, nd) {
                if (myIsNaN(x)) {
                    return Number.NaN;
                } else {
                    var res = round(x, nd);
                    if (nd > 0) {
                        var str = String(res);
                        if (str.indexOf('e') != -1) return str;
                        if (str.indexOf('E') != -1) return str;
                        var parts = str.split('.');
                        var res2 = eeinsertThousand(parts[0].toString());
                        if (parts.length < 2) {
                            var decimals = ('00000000000000').substring(0, nd);
                            return (res2 + eedec + decimals);
                        } else {
                            var decimals = ((parts[1]).toString() + '00000000000000').substring(0, nd);
                            return (res2 + eedec + decimals);
                        }
                    } else {
                        return (eeinsertThousand(res.toString()));
                    }
                }
            };

            function eedisplayPercentNDTh(x, nd) {
                if (myIsNaN(x)) {
                    return Number.NaN;
                } else {
                    return eedisplayFloatNDTh(x * 100, nd) + '%';
                }
            }
            var eeparseFloatVreg = new RegExp("^ *-?[0-9.]+ *$");

            function eeparseFloatV(str) {
                if (str == "") return str;
                str = String(str).replace(eedecreg, ".");
                if (!eeparseFloatVreg.test(str)) {
                    return str;
                };
                var res = parseFloat(str);
                if (isNaN(res)) {
                    return str;
                } else {
                    return res;
                }
            };
            var eeparsePercentVreg = new RegExp("^ *-?[0-9.]+$");

            function eeparsePercentV(str) {
                if (str == "") return str;
                var parts = String(str).split('%');
                var tmp = String(parts[0]).replace(eedecreg, ".");
                if (!eeparsePercentVreg.test(tmp)) {
                    return str;
                };
                var res = parseFloat(tmp) / 100;
                if (isNaN(res)) {
                    return str;
                } else {
                    return res;
                }
            };

            function eedisplayPercentNDV(x, nd) {
                if (x == "") return x;
                if (isFinite(x)) {
                    return eedisplayPercentND(x, nd)
                } else {
                    return x
                }
            }

            function eeinsertThousand(whole) {
                if (whole == "" || whole.indexOf("e") >= 0) {
                    return whole;
                } else {
                    var minus_sign = "";
                    if (whole.charAt(0) == "-") {
                        minus_sign = "-";
                        whole = whole.substring(1);
                    };
                    var res = "";
                    var str_length = whole.length - 1;
                    for (var ii = 0; ii <= str_length; ii++) {
                        if (ii > 0 && ii % 3 == 0) {
                            res = eeth + res;
                        };
                        res = whole.charAt(str_length - ii) + res;
                    };
                    return minus_sign + res;
                }
            };

            function eedatefmt(fmt, x) {
                if (!isFinite(x)) return Number.NaN;
                var tmp = 0;
                var res = "";
                var len = fmt.length;
                for (var ii = 0; ii < len; ii++) {
                    if (fmt[ii] > 31) {
                        res += fmtstrings[fmt[ii] - 32];
                    } else {
                        switch (fmt[ii]) {
                            case 2:
                                res += eemonth(x);
                                break;
                            case 3:
                                tmp = eemonth(x);
                                if (tmp < 10) {
                                    res += "0";
                                };
                                res += tmp;
                                break;
                            case 4:
                                res += fmtmonthnamesshort[eemonth(x) - 1];
                                break;
                            case 5:
                                res += fmtmonthnameslong[eemonth(x) - 1];
                                break;
                            case 6:
                                res += eeday(x);
                                break;
                            case 7:
                                tmp = eeday(x);
                                if (tmp < 10) {
                                    res += "0";
                                };
                                res += tmp;
                                break;
                            case 8:
                                res += fmtdaynamesshort[weekday(x, 1) - 1];
                                break;
                            case 9:
                                res += fmtdaynameslong[weekday(x, 1) - 1];
                                break;
                            case 10:
                                tmp = year(x) % 100;
                                if (tmp < 10) {
                                    res += "0";
                                };
                                res += tmp;
                                break;
                            case 11:
                                res += year(x);
                                break;
                            case 12:
                                res += hour(x);
                                break;
                            case 13:
                                tmp = hour(x);
                                if (tmp < 10) {
                                    res += "0";
                                };
                                res += tmp;
                                break;
                            case 14:
                                tmp = hour(x) % 12;
                                if (tmp == 0) {
                                    res += "12";
                                } else {
                                    res += tmp % 12;
                                };
                                break;
                            case 15:
                                tmp = hour(x) % 12;
                                if (tmp == 0) {
                                    res += "12";
                                } else {
                                    if (tmp < 10) {
                                        res += "0";
                                    };
                                    res += tmp;
                                };
                                break;
                            case 16:
                                res += minute(x);
                                break;
                            case 17:
                                tmp = minute(x);
                                if (tmp < 10) {
                                    res += "0";
                                };
                                res += tmp;
                                break;
                            case 18:
                                res += second(x);
                                break;
                            case 19:
                                tmp = second(x);
                                if (tmp < 10) {
                                    res += "0";
                                };
                                res += tmp;
                                break;
                            case 21:
                            case 22:
                                if (hour(x) < 12) {
                                    res += "AM";
                                } else {
                                    res += "PM";
                                };
                                break;
                            case 23:
                                res += eedisplayFloat(x);
                                break;
                            case 24:
                                tmp = fmt[++ii];
                                res += eedisplayFloatND(x, tmp);
                                break;
                            case 25:
                                tmp = fmt[++ii];
                                res += eedisplayFloatNDTh(x, tmp);
                                break;
                            case 26:
                                res += eedisplayPercent(x);
                                break;
                            case 27:
                                tmp = fmt[++ii];
                                res += eedisplayPercentND(x, tmp);
                                break;
                            case 28:
                                tmp = fmt[++ii];
                                res += eedisplayPercentNDTh(x, tmp);
                                break;
                            case 29:
                                tmp = fmt[++ii];
                                res += eedisplayScientific(x, tmp);
                                break;
                        };
                    };
                };
                return res;
            };

            function eeisnumber(v) {
                if (isNaN(v) || v == Number.NEGATIVE_INFINITY || v == Number.POSITIVE_INFINITY) {
                    return false;
                } else {
                    switch (typeof v) {
                        case "number":
                            return true;
                        case "object":
                            return v.constructor == Number;
                        default:
                            return false;
                    }
                }
            };

            function leap_gregorian(year) {
                return ((year % 4) == 0) && (!(((year % 100) == 0) && ((year % 400) != 0)));
            }
            var GREGORIAN_EPOCH = 1721425;

            function gregorian_to_jd(year, month, day) {
                return (GREGORIAN_EPOCH - 0) + (365 * (year - 1)) + Math.floor((year - 1) / 4) + (-Math.floor((year - 1) / 100)) + Math.floor((year - 1) / 400) + Math.floor((((367 * month) - 362) / 12) + ((month <= 2) ? 0 : (leap_gregorian(year) ? -1 : -2)) + day);
            }

            function jd_to_gregorian(jd) {
                var wjd, depoch, quadricent, dqc, cent, dcent, quad, dquad, yindex, year, yearday, leapadj;
                wjd = Math.floor(jd);
                depoch = wjd - GREGORIAN_EPOCH - 1;
                quadricent = Math.floor(depoch / 146097);
                dqc = mod(depoch, 146097);
                cent = Math.floor(dqc / 36524);
                dcent = mod(dqc, 36524);
                quad = Math.floor(dcent / 1461);
                dquad = mod(dcent, 1461);
                yindex = Math.floor(dquad / 365);
                year = (quadricent * 400) + (cent * 100) + (quad * 4) + yindex;
                if (!((cent == 4) || (yindex == 4))) {
                    year++;
                }
                yearday = wjd - gregorian_to_jd(year, 1, 1);
                leapadj = ((wjd < gregorian_to_jd(year, 3, 1)) ? 0 : (leap_gregorian(year) ? 1 : 2));
                var month = Math.floor((((yearday + leapadj) * 12) + 373) / 367);
                var day = (wjd - gregorian_to_jd(year, month, 1)) + 1;
                return new Array(year, month, day);
            }

            function eeday(serial_number) {
                if (!isFinite(serial_number)) return Number.NaN;
                if (serial_number < 1) {
                    return 0;
                }
                if (serial_number > 60) serial_number--;
                var res = jd_to_gregorian(serial_number + 2415020);
                return res[2];
            };

            function hour(serial_number) {
                if (!isFinite(serial_number)) return Number.NaN;
                var res = Math.floor((serial_number - Math.floor(serial_number)) * 86400 + 0.5);
                return Math.floor(res / 3600);
            }

            function minute(serial_number) {
                if (!isFinite(serial_number)) return Number.NaN;
                var res = Math.floor((serial_number - Math.floor(serial_number)) * 86400 + 0.5);
                return Math.floor(res / 60) % 60;
            };

            function eemonth(serial_number) {
                if (!isFinite(serial_number)) return Number.NaN;
                if (serial_number < 1) {
                    return 1;
                }
                if (serial_number > 60) serial_number--;
                var res = jd_to_gregorian(serial_number + 2415020);
                return res[1];
            };

            function second(serial_number) {
                if (!isFinite(serial_number)) return Number.NaN;
                var res = Math.floor((serial_number - Math.floor(serial_number)) * 86400 + 0.5);
                return res % 60;
            };

            function weekday(serial_number, return_type) {
                if (!isFinite(return_type) || !isFinite(serial_number)) return Number.NaN;
                if (return_type < 1 || return_type > 3) return Number.NaN;
                var res = Math.floor(serial_number + 6) % 7;
                switch (Math.floor(return_type)) {
                    case 1:
                        return res + 1;
                    case 2:
                        return (res + 6) % 7 + 1;
                    case 3:
                        return (res + 6) % 7;
                };
                return "hej";
            };

            function year(serial_number) {
                if (!isFinite(serial_number)) return Number.NaN;
                if (serial_number < 1) {
                    return 1900;
                }
                if (serial_number > 60) serial_number--;
                var res = jd_to_gregorian(serial_number + 2415020);
                return res[0];
            };

            function pmt(rate, nper, pv, fv, type) {
                if (rate == 0) {
                    return -pv / nper;
                } else {
                    var pvif = Math.pow(1 + rate, nper);
                    var fvifa = (Math.pow(1 + rate, nper) - 1) / rate;
                    var type1 = (type != 0) ? 1 : 0;
                    return ((-pv * pvif - fv) / ((1 + rate * type1) * fvifa));
                }
            };

            function goto() {
                self.location.href = "definiciones_rentas.htm";
            }

            function formReset() {
                //las dos primeras sentencias hacen lo mismo, limpian solo los resultados
                //document.getElementById("formc").reset();
                document.formc.reset();
                document.formc.p3D6.value = "0,00";
                document.formc.p3D7.value = "0,00";
                document.formc.p3D8.value = "0";
                //document.formc.p3D9.value="0";
            }

            function NumberFormat(num, numDec, decSep, thousandSep) {
                var arg;
                var Dec;
                num = num.toString().replace('.', '');
                Dec = Math.pow(10, numDec);
                if (typeof(num) == 'undefined') return;
                if (typeof(decSep) == 'undefined') decSep = '.';
                if (typeof(thousandSep) == 'undefined') thousandSep = ',';
                if (thousandSep == ',')
                    arg = /./g;
                else
                if (thousandSep == ',') arg = /,/g;
                if (typeof(arg) != 'undefined') num = num.toString().replace(arg, '');
                num = num.toString().replace(/,/g, '.');
                if (isNaN(num)) num = "0";
                sign = (num == (num = Math.abs(num)));
                num = Math.floor(num * Dec + 0.50000000001);
                cents = num % Dec;
                num = Math.floor(num / Dec).toString();
                if (cents < (Dec / 10)) cents = "0" + cents;
                for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
                    num = num.substring(0, num.length - (4 * i + 3)) + thousandSep + num.substring(num.length - (4 * i + 3));
                if (Dec == 1)
                    return (((sign) ? '' : '-') + num);
                else
                    return (((sign) ? '' : '-') + num + decSep + cents);
            }

            function EvaluateText(cadena, obj) {
                opc = false;
                if (cadena == "%d")
                    if (event.keyCode > 47 && event.keyCode < 58)
                        opc = true;
                if (cadena == "%f") {
                    if (event.keyCode > 47 && event.keyCode < 58)
                        opc = true;
                    if (obj.value.search("[.*]") == -1 && obj.value.length != 0)
                        if (event.keyCode == 46)
                            opc = true;
                }
                if (opc == false)
                    event.returnValue = false;
            }
        </script>

        <div id="contenidotexto">

            <form id="formc" name="formc" method="post" action="">

                Capital prestado (Vo)
                <input value="" name="p3D6" id="p3D6" type="text" onblur="this.value=NumberFormat(this.value, '2', ',', '.');recalc_onclick('p3D6')" tabindex="1" style=' width:100% ' class='ee122' onKeyDown="if (event.keyCode==13) event.keyCode=9;" onKeyPress="if (event.keyCode==46) {event.keyCode=44;};" onKeyUp="EvaluateText('%f', this);">

                Tipo de interés
                <input value="6,40%" name="p3D7" id="p3D7" type="text" onblur="this.value=eedisplayPercentNDV(eeparsePercentV(this.value),2);recalc_onclick('p3D7')" tabindex="2" style=' width:100% ' class='ee122' onKeyDown="if (event.keyCode==13) event.keyCode=9;">


                Nº años
                <input value="5" name="p3D8" id="p3D8" type="text" onblur="this.value=eedisplayFloat(eeparseFloat(this.value));recalc_onclick('p3D8')" tabindex="3" style=' width:100% ' class='ee122' onKeyDown="if (event.keyCode==13) event.keyCode=9;">

                Elegir pagos
                <select name="p3D9" id="p3D9" size="1" onChange="recalc_onclick('p3D9')" tabindex="4" class='ee130' style=' width:100% '>
                    <option value="MENSUALES" selected>MENSUALES</option>
                    <option value="TRIMESTRALES">TRIMESTRALES</option>
                    <option value="SEMESTRALES">SEMESTRALES</option>
                    <option value="ANUALES">ANUALES</option>
                </select>

                <span class="ee124">
                    <input name="p3E7" type="text" class='ee126' id="p3E7" style='overflow:hidden; border:0px solid #000000;' tabindex="-1" value="" size="2" maxlength="2" readonly>
                </span>
                <span class="ee124">
                    <input name="p3E9" type="text" class='ee126' id="p3E9" style='overflow:hidden; border:0px solid #000000;' tabindex="-1" value="" size="2" maxlength="2" readonly>
                </span>


                Pago
                <input name="p3D11" type="text" class='ee137' id="p3D11" style='overflow:hidden; border:0px solid #000000;' tabindex="-1" value="" size="8" maxlength="8" readonly>


                <input value="" name="p3C12" id="p3C12" type="text" tabindex="-1" readonly style='overflow:hidden; border:0px solid #000000; width:100% ' class='ee140'>
                <input value="-" name="p3D12" id="p3D12" type="text" tabindex="-1" readonly style='overflow:hidden; border:0px solid #000000; width:100% ' class='ee142'>

                Pagado en total
                <input value="-" name="p3D13" id="p3D13" type="text" tabindex="-1" readonly style='overflow:hidden; border:0px solid #000000; width:100% ' class='ee142'>


                Intereses
                <input value="-" name="p3D14" id="p3D14" type="text" tabindex="-1" readonly style='overflow:hidden; border:0px solid #000000; width:100% ' class='ee142'>


                <script language="javascript">
                    function postcode() {};

                    function eequerystring() {
                        var querystring = document.location.search;
                        if (querystring.length > 0) {
                            variables = (querystring.substring(1)).split("&");
                            var variable;
                            var key;
                            var value;
                            for (var ii = 0; ii < variables.length; ii++) {
                                variable = variables[ii].split("=");
                                key = unescape(variable[0]);
                                value = unescape(variable[1]);
                                if (document.formc[key] != null) {
                                    document.formc[key].value = value;
                                }
                            }
                        }
                    }

                    function initial_update() {
                        postcode('');
                        eequerystring();
                        recalc_onclick('');
                    }
                </script>
            </form>

        </div> -->


        <section class="section container specialty" id="calculador">
            <div class="specialty__container">
                <div class="specialty__box">
                    <h2 class="section__title">
                        ¡Hágalo sus sueños realidad!
                    </h2>

                    <!-- <div>
                        <a href="../index.php#products" class="button specialty__button pulse"><span>Ver Préstamos</span></a>
                    </div> -->

                </div>

                <div class="specialty__category_prestamos">

                    <div class="">
                        <!-- <div class="specialty__group_prestamos specialty__line"> -->
                        <!-- <img src="../assets/img/BAJA_online.png" alt="" class="specialty__img"> -->

                        <div class="home__data_prestamos">
                            <div class="home__data-group">
                                <h3 class="home__data-title" style="color: hsl(208, 100%, 25%); font-size: var(--h1-font-size);">Compra USD</h3>
                                <h2 class="home__data-number" style="font-size: var(--h1-font-size);"><?php echo $compra ?></h2>
                                <p class="home__data-description">
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="specialty__group_prestamos">

                        <form class="l_prestamos" name="l_prestamos">
                            <h3 class="" style="color: #fff;">Tipo de Monedas<span style="color: hsl(197, 100%, 42%);">:</span>
                                <a onclick="myFunction_col()" class="button_convertir pulse" id="col" style="margin-left: 0.3rem;"><span>Colones</span></a>
                                <a onclick="myFunction_dol()" class="button_convertir pulse" id="dol"><span>Dólares</span></a>
                            </h3>
                            <br>

                            <div id="DIV_col">
                                <h3 style="color: #fff;">Monto a solicitar<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                <h4>
                                    <input class="input__convert input__convert_prestamo" type="number" name="monto_col" id="monto_col" value="" placeholder="0" />
                                    <h5 style="color: hsl(197, 100%, 35%);">Monto Maximo: 100,000,000.0 | Monto Minimo: 300,000.0</h5>
                                </h4>
                                <br><br>

                                <h3 style="color: #fff;">Plazo estimado (Años)<span style="color: hsl(197, 100%, 42%);">:</span><span class="value_slider" id="demo_col"></span></h3>
                                <div class="slidecontainer">
                                    <input type="range" min="0" max="12" value="12" class="slider" id="range_col">
                                </div>
                                <br><br>

                                <h3 style="color: #fff;">Tasa (%)<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                <h4>
                                    <input class="input__convert input__convert_prestamo" type="number" name="monto_col" id="monto_col" value="18.0" placeholder="0" readonly="readonly" />
                                </h4>
                                <br><br>

                                <h3 style="color: #fff;">Cuota mensual<span style="color: hsl(197, 100%, 42%);">:</span></h3>
                                <h4>
                                    <input class="input__convert input__convert_prestamo" type="number" name="monto_col" id="monto_col" value="" placeholder="0" />
                                </h4>
                                <br><br>




                                <!-- <h4><input class="input__convert" type="number" name="num1_1" id="num1_1" value="" onchange="cal_1()" onkeyup="cal_1()" autocomplete="off" style="margin-left: -2px;" placeholder="0" />
                                    <- Dólar</h4>
                                        <p hidden>Número 2: <input type="number" name="num2_1" value="<?php echo $compra ?>" onchange="cal_1()" onkeyup="cal_1()" /></p>
                                        <h4><input class="input__convert" type="number" name="sum_1" id="sum_1" value="" readonly="readonly" placeholder="0" />
                                            <- Cólon</h4> -->
                            </div>
                            <div id="myDIV2" style="display:none">
                                <h4><input class="input__convert" type="number" name="num1_2" id="num1_2" value="" onchange="cal_2()" onkeyup="cal_2()" autocomplete="off" placeholder="0" />
                                    <- Cólon</h4>
                                        <p hidden>Número 2: <input type="number" name="num2_2" value="<?php echo $venta ?>" onchange="cal_2()" onkeyup="cal_2()" /></p>
                                        <h4><input class="input__convert" type="number" name="sum_2" id="sum_2" value="" readonly="readonly" style="margin-left: -2px;" placeholder="0" />
                                            <- Dólar</h4>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </section>
        <br><br>

        <script>
            var slider = document.getElementById("range_col");
            var output = document.getElementById("demo_col");
            output.innerHTML = slider.value;

            // Update the current slider value (each time you drag the slider handle)
            slider.oninput = function() {
                output.innerHTML = this.value;
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
                        <img src="../../assets/img/BAJA_online.png" alt="" class="specialty__img">

                        <h3 class="specialty__title">BAJA Online</h3>
                        <p class="specialty__description">
                            Administrá tus préstamo por medio de la sucursal BAJA Online.
                        </p>
                    </div>
                    <div class="specialty__group specialty__line">
                        <img src="../../assets/img/Tramites_Rapidos.png" alt="" class="specialty__img">

                        <h3 class="specialty__title">Trámites rápidos</h3>
                        <p class="specialty__description">
                            Lográ la aprobación de tu préstamo de forma rápida y sencilla.
                        </p>
                    </div>
                    <div class="specialty__group">
                        <img src="../../assets/img/Pago.png" alt="" class="specialty__img">

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
                    <article class="products__card Personal" onclick="window.location.href='../../Prestamos/Personal/gastos_personales.php'">
                        <div class="products__shape">
                            <img src="../../assets/img/personal1.png" alt="" class="products__img">
                        </div>

                        <div class="products__data">
                            <h2 class="products__price">Gastos Personales</h2>
                            <h3 class="products__name">Solicitá tu préstamo personal y hacé realidad todos tus planes.</h3>

                            <button class="button products__button">
                                <i class='bx bxs-calculator'></i>
                            </button>
                        </div>
                    </article>

                    <article class="products__card Personal" onclick="window.location.href='../../Prestamos/Personal/rapidos.php'">
                        <div class="products__shape">
                            <img src="../../assets/img/personal2.png" alt="" class="products__img">
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
                    <article class="products__card Vivienda" onclick="window.location.href='../../Prestamos/Vivienda/construccion_vivienda.php'">
                        <div class="products__shape">
                            <img src="../../assets/img/house1.png" alt="" class="products__img">
                        </div>

                        <div class="products__data">
                            <h2 class="products__price">Construcción Vivienda</h2>
                            <h3 class="products__name">Te ofrecemos un crédito hecho a tu medida para la construcción de tu casa.</h3>

                            <button class="button products__button">
                                <i class='bx bxs-calculator'></i>
                            </button>
                        </div>
                    </article>

                    <article class="products__card Vivienda" onclick="window.location.href='../../Prestamos/Vivienda/vivienda_interes_social.php'">
                        <div class="products__shape">
                            <img src="../../assets/img/house2.png" alt="" class="products__img">
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
                    <article class="products__card Vehiculos" onclick="window.location.href='../../Prestamos/Vehiculo/vehiculo_nuevo.php'">
                        <div class="products__shape">
                            <img src="../../assets/img/car1.png" alt="" class="products__img">
                        </div>

                        <div class="products__data">
                            <h2 class="products__price">Vehículo Nuevo</h2>
                            <h3 class="products__name">Te ofrecemos tasas competitivas y rápidos tiempos de respuesta para comprar tu carro nuevo.</h3>

                            <button class="button products__button">
                                <i class='bx bxs-calculator'></i>
                            </button>
                        </div>
                    </article>

                    <article class="products__card Vehiculos" onclick="window.location.href='../../Prestamos/Vehiculo/vehiculo_usado.php'">
                        <div class="products__shape">
                            <img src="../../assets/img/car2.png" alt="" class="products__img">
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
                    <article class="products__card Viajes" onclick="window.location.href='../../Prestamos/Viajes/viajes_internacionales.php'">
                        <div class="products__shape">
                            <img src="../../assets/img/travel3.png" alt="" class="products__img">
                        </div>

                        <div class="products__data">
                            <h2 class="products__price">Viajes Internacionales</h2>
                            <h3 class="products__name">Planifique el viaje, prepare las maletas con tranquilidad, nosotros le financiamos.</h3>

                            <button class="button products__button">
                                <i class='bx bxs-calculator'></i>
                            </button>
                        </div>
                    </article>

                    <article class="products__card Viajes" onclick="window.location.href='../../Prestamos/Viajes/viajes_nacionales.php'">
                        <div class="products__shape">
                            <img src="../../assets/img/travel2.png" alt="" class="products__img">
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
                    <article class="products__card UniDeudas" onclick="window.location.href='../../Prestamos/Unificacion/pagos_tarjeta_credito.php'">
                        <div class="products__shape">
                            <img src="../../assets/img/pay1.png" alt="" class="products__img">
                        </div>

                        <div class="products__data">
                            <h2 class="products__price">Pagos De Tarjetas De Crédito</h2>
                            <h3 class="products__name">Unifique sus pagos de tarjeta con una cuota única.</h3>

                            <button class="button products__button">
                                <i class='bx bxs-calculator'></i>
                            </button>
                        </div>
                    </article>

                    <article class="products__card UniDeudas" onclick="window.location.href='../../Prestamos/Unificacion/prestamos_de_otras_instituciones.php'">
                        <div class="products__shape">
                            <img src="../../assets/img/pay2.png" alt="" class="products__img">
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
                <h1 class="footer__title">BAJA</h1>

                <div class="footer__content grid">
                    <div class="footer__data">
                        <p class="footer__description">
                            Para nosotros será un placer poder atender sus consultas.
                        </p>

                        <div class="footer__newsletter">
                            <input type="email" placeholder="Ingrese su dirección de correo electrónico" class="footer__input">
                            <button class="footer__button">
                                <i class='bx bx-right-arrow-alt'></i>
                            </button>
                        </div>
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
    <script src="../../assets/js/mixitup.min.js"></script>

    <!--=============== MAIN JS ===============-->
    <script src="../../assets/js/main.js"></script>
</body>

</html>