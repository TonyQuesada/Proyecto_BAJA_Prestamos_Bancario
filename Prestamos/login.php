<?php
include '../conection.php';
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
    header('Location: ../index.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--=============== FAVICON ===============-->
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">

    <!--=============== BOXICONS ===============-->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../assets/css/styles.css">

    <title>Login - BAJA</title>
</head>

<body>
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
                <a href="../index.php" class="header__toggle">
                    <i class='bx bx-arrow-back'></i>
                </a>
            </nav>
        </header>

        <!--==================== HOME ====================-->
        <section class="home grid" id="home">
            <div class="home__container">
                <div class="home__content container">
                    <br>
                    <form class="l" method="POST" action="../PHP/login.php">

                        <br>
                        <h1 class="home__title">
                            BANCA EN LÍNEA<span>.</span>
                        </h1>
                        <input type="text" size="50" name="usuario" placeholder="Usuario" autocomplete="off" style="width: 75%; height: 33px;"><br>
                        <br>
                        <input type="password" size="50" name="passwd" placeholder="Contraseña" autocomplete="off" style="width: 75%; height: 33px;"><br>
                        <br><br>
                        <input type="submit" value="Ingresar" class="button pulse" name="insert">
                        <br>
                        <br>
                        <a href="#" class="a a_login">¿Olvidó su contraseña?</a>
                        <br>
                        <br>
                        <br>
                    </form>
                    <br><br>
                </div>
            </div>

            <!-- <img src="../assets/img/home.gif" alt="" class="home__img"> -->
            <video src="../assets/video/login.mp4" class="home__video" type="video/mp4" autoPlay loop muted playsInline></video>

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

        <!--====================  ====================-->
        <div class="section container specialty" id="specialty">
            <div class="specialty__container">
                <div class="specialty__box">
                    <h2 class="section__title">
                        ¡Hágalo sus sueños realidad!
                    </h2>

                    <div>
                        <a href="../index.php#products" class="button specialty__button pulse"><span>Ver Préstamos</span></a>
                    </div>
                </div>

                <div class="specialty__category_login">

                    <div class="specialty__group_login specialty__line">
                        <!-- <img src="../assets/img/BAJA_online.png" alt="" class="specialty__img"> -->

                        <div class="home__data_login2">
                            <div class="home__data-group">
                                <h3 class="home__data-title" style="color: hsl(208, 100%, 25%); font-size: var(--h1-font-size);">Compra USD</h3>
                                <h2 class="home__data-number" style="font-size: var(--h1-font-size);"><?php echo $compra ?></h2>
                                <p class="home__data-description">
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="specialty__group_login specialty__line">

                        <form class="ll" name="f">
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

                    </div>

                    <div class="specialty__group_login">
                        <!-- <img src="../assets/img/Pago.png" alt="" class="specialty__img"> -->

                        <div class="home__data_login2">
                            <div class="home__data-group">
                                <h3 class="home__data-title" style="color: hsl(208, 100%, 25%); font-size: var(--h1-font-size);">Venta USD</h3>
                                <h2 class="home__data-number" style="font-size: var(--h1-font-size);"><?php echo $venta ?></h2>
                                <p class="home__data-description">
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="section container specialty" id="specialty"></div>

        <!--==================== FOOTER ====================-->
        <footer class="footer" id="footer">
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
        </footer>
    </main>

    <!--========== SCROLL UP ==========-->
    <a href="#" class="scrollup pulse" id="scroll-up">
        <i class='bx bx-up-arrow-alt'></i>
    </a>

    <!--=============== MIXITUP FILTER ===============-->
    <script src="../assets/js/mixitup.min.js"></script>

    <!--=============== MAIN JS ===============-->
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/contador.js"></script>
</body>

</html>