/*=============== LOADER ===============*/
onload = () => {
    const load = document.getElementById('load')

    setTimeout(() => {
        load.style.display = 'none'
    }, 4500)
}

/*=============== SHOW MENU ===============*/
const headerToggle = document.getElementById('header-toggle'), 
        main = document.getElementById('main'), 
        navClose = document.getElementById('nav-close')

/*=============== MENU SHOW ===============*/
/* Validate if constant exists */
if (headerToggle) {
    headerToggle.addEventListener('click', () => {
        main.classList.add('show-menu')
    })
}

/*=============== MENU HIDDEN ===============*/
/* Validate if constant exist */
if (navClose) {
    navClose.addEventListener('click', () => {
        main.classList.remove('show-menu')
    })
}

/*=============== REMOVE MENU MOBILE ===============*/
const navLink = document.querySelectorAll('.nav__link')

function linkAction(){
    const main = document.getElementById('main')
    main.classList.remove('show-menu')
}
navLink.forEach(n => n.addEventListener('click', linkAction))

/*=============== CHANGE BACKGROUND HEADER ===============*/
function scrollHeader(){
    const header = document.getElementById('header')
    // When the scroll is greater than 50 viewport height, add the scroll-header class to the header tag
    if(this.scrollY >= 50) header.classList.add('scroll-header'); else header.classList.remove('scroll-header')
}
window.addEventListener('scroll', scrollHeader)

/*=============== MIXITUP FILTER PRODUCTS ===============*/
let mixerProducts = mixitup('.products__content', {
    selectors: {
        target: '.products__card'
    },
    animation: {
        duration: 300
    }
});

/* Default filter products */
mixerProducts.filter('.Personal')

/* Link active products */
const linkProducts = document.querySelectorAll('.products__item')

function activeProducts(){
    linkProducts.forEach(l=> l.classList.remove('active-product'))
    this.classList.add('active-product')
}

linkProducts.forEach(l=> l.addEventListener('click', activeProducts))

/*=============== SHOW SCROLL UP ===============*/
function scrollUp(){
    const scrollUp = document.getElementById('scroll-up');
    // When the scroll is higher than 350 viewport height, add the show-scroll class to the a tag with the scroll-top class
    if(this.scrollY >= 350) scrollUp.classList.add('show-scroll'); else scrollUp.classList.remove('show-scroll')
}
window.addEventListener('scroll', scrollUp)

/*=============== SCROLL SECTIONS ACTIVE LINK ===============*/
const sections = document.querySelectorAll('section[id]')

function scrollActive(){
    const scrollY = window.pageYOffset

    sections.forEach(current =>{
        const sectionHeight = current.offsetHeight,
              sectionTop = current.offsetTop - 58,
              sectionId = current.getAttribute('id')

        if(scrollY > sectionTop && scrollY <= sectionTop + sectionHeight){
            document.querySelector('.nav__menu a[href*=' + sectionId + ']').classList.add('active-link')
        }else{
            document.querySelector('.nav__menu a[href*=' + sectionId + ']').classList.remove('active-link')
        }
    })
}
window.addEventListener('scroll', scrollActive)




function includeHTML() {
    var z, i, elmnt, file, xhttp;
    /* Loop through a collection of all HTML elements: */
    z = document.getElementsByTagName("*");
    for (i = 0; i < z.length; i++) {
      elmnt = z[i];
      /*search for elements with a certain atrribute:*/
      file = elmnt.getAttribute("w3-include-html");
      if (file) {
        /* Make an HTTP request using the attribute value as the file name: */
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4) {
            if (this.status == 200) {elmnt.innerHTML = this.responseText;}
            if (this.status == 404) {elmnt.innerHTML = "Page not found.";}
            /* Remove the attribute, and call this function once more: */
            elmnt.removeAttribute("w3-include-html");
            includeHTML();
          }
        }
        xhttp.open("GET", file, true);
        xhttp.send();
        /* Exit the function: */
        return;
      }
    }
  
  setTimeout(function(){    
  $('.toggle').click(function(){
    $(this).toggleClass('active');
    $('.content__mobile').toggleClass('active');
  })
  
  
  $('#primerClick').click(function(){
    $('#abrirOne').show();
    $('#abrirTwo').hide();
    $('#abrirThird').hide();
  });
  
  $('#segundoClick').click(function(){
    $('#abrirOne').hide();
    $('#abrirTwo').show();
    $('#abrirThird').hide();
  });
  
  $('#tercerClick').click(function(){
    $('#abrirOne').hide();
    $('#abrirTwo').hide();
    $('#abrirThird').show();
  });
  
  }, 2000);
  
  
  setTimeout(function(){    
  /*var script_tres = document.createElement('script');
  script_tres.src = 'https://www.bncr.fi.cr/_themes/Banco-NacionalTheme/assets/js/webflow.js';
  script_tres.type = 'text/javascript';
  document.getElementsByTagName('head')[0].appendChild(script_tres);*/
  
  
  var google = document.createElement('script');
  google.src = 'https://cse.google.com/cse.js?cx=008777757745797742159:0zfzmxcumd8';
  google.type = 'text/javascript';
  document.getElementsByTagName('head')[0].appendChild(google);
  
  var script_dos = document.createElement('script');
  script_dos.src = 'https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.js';
  script_dos.type = 'text/javascript';
  document.getElementsByTagName('head')[0].appendChild(script_dos);
  }, 1500);
  
  
  
  
  
  setTimeout(function(){ 
  
  /** TIPO DE CAMBIO **/
  $('#monto').on("input", function() {
    isNumber($(this).val(), 'monto');
  })
  
  $('#moneda').on("input", function() {
    isNumber($('#monto').val(), 'monto');
  })
  
  let ventaEuro = 0.0;
  let ventaDolar = 0.0;
  /** CHANGE RATES REQUEST **/
  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: 'https://oic-idmgdptbgc3i-ia.integration.ocp.oraclecloud.com:443/ic/api/integration/v1/flows/rest/OBTENE_RESTJS_TO_SOAPXM_POST/1.0/SOA/TipoCambio',
    beforeSend: function (xhr) {
      xhr.setRequestHeader ("Authorization", "Basic " + btoa("enlaceoce" + ":" + "BncROCEOIC2020#PN"));
    },
    success: function(json){
      //var json = JSON.parse(jsondata);
      ventaDolar = parseFloat(json["TipoVentaDolares"]);
      ventaEuro = parseFloat(json["TipoVentaEuros"]);
      let compraEuro = parseFloat(json["TipoCompraEuros"]);
      let compraDolar = parseFloat(json["TipoCompraDolares"]);
      compraEuros = parseFloat(json["TipoCompraEuros"]);
      compraDolares = parseFloat(json["TipoCompraDolares"]);
  
      // Setting up values
      $('#us_compra').text(compraDolar.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
      $('#us_venta').text(ventaDolar.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
      $('#eur_compra').text(compraEuro.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
      $('#eur_venta').text(ventaEuro.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    }
  })
  
  function isNumber(numero, id) {
    if (!/^([0-9.])*$/.test(numero)) {
        alert("El valor " + numero + " no es un número");
        $('#' + id).val('');
        $('#total_cambio').val('₡ 0.00');
    } else {
      changeRate();
    }
  }
  
  
  var selectMoneda = $('#moneda').val();
  var selectCambio = $('#moneda_cambio').val();
  ///CAMBIO DE PRIMER SELECT
  $( "#moneda" ).change(function() {
  var selectMoneda = $(this).val();
  
  
  if (selectMoneda == 'CR') {
    $('#moneda_cambio').empty();
    $('<option value="USD">USD</option><option value="EUR">EUR</option>').appendTo('#moneda_cambio');
    changeRate();
  }
  
  
  if (selectMoneda == 'USD') {
    $('#moneda_cambio').empty();
    $('<option value="CR">CR</option>').appendTo('#moneda_cambio');
    changeRate();
  }
  
  if (selectMoneda == 'EUR') {
    $('#moneda_cambio').empty();
    $('<option value="CR">CR</option>').appendTo('#moneda_cambio');
    changeRate();
  }
  });
  
  
  ///VALIDACION CR
  if (selectMoneda == 'CR') {
    $('#moneda_cambio').empty();
    $('<option value="USD">USD</option><option value="EUR">EUR</option>').appendTo('#moneda_cambio');
  }
  
  
  
  ///CAMBIO DE SEGUNDO SELECT
  $( "#moneda_cambio" ).change(function() {
  if (selectMoneda == 'CR' && selectCambio == 'USD') {
      changeRate();
  }
  
  if (selectMoneda == 'CR' && selectCambio == 'EUR') {
      changeRate();
  }
  
  });
  
  
  
  
  function changeRate() {
  var monedaSelect = $('#moneda').val();
  var monedaSelect2 = $('#moneda_cambio').val();
  
  
  //VALIDACIONES
  if (monedaSelect == 'CR' && monedaSelect2 == 'USD') {
    console.log('esta en cr y usd');
    let moneda = $('#moneda').val();
    let monto = $('#monto').val();
    let total = 0;
    total = monto / ventaDolar;
    $('#total_cambio').val('$ ' + total.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  }
  
  if (monedaSelect == 'CR' && monedaSelect2 == 'EUR') {
    console.log('esta en cr y eur')
    console.log('esta en cr y usd');
    let moneda = $('#moneda').val();
    let monto = $('#monto').val();
    let total = 0;
    total = monto / ventaEuro;
    $('#total_cambio').val('€ ' + total.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  }
  
  if (monedaSelect == 'USD' && monedaSelect2 == 'CR') {
    console.log('esta en usd y cr')
    let moneda = $('#moneda').val();
    let monto = $('#monto').val();
    let total = 0;
    total = monto * compraDolares;
    $('#total_cambio').val('¢ ' + total.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  }
  
  if (monedaSelect == 'EUR' && monedaSelect2 == 'CR') {
    console.log('esta en eur y cr')
    console.log('esta en cr y eur')
    console.log('esta en cr y usd');
    let moneda = $('#moneda').val();
    let monto = $('#monto').val();
    let total = 0;
    total = monto * compraEuros;
    $('#total_cambio').val('¢ ' + total.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
  }
  }
  
  
  $('.fila_rotador').find('.content__rota').clone().appendTo('.fila_rotador');
  }, 3000);
  }
  
  
  