<div id="capital" class="modal">

    <div class="modal-content animate">
        <div class="imgcontainer_formulario">
            <span onclick="document.getElementById('capital').style.display='none'" class="close"
                title="Close Modal">&times;</span>
            <img src="assets/img/capital_con.png" alt="Avatar" class="avatar_formulario">
        </div>

        <div class="modal_container_formulario">
            <h3><b>Capital</b></h3></br>
            <label>Es el monto de dinero que presta la institución financiera.</label>
            </br></br>
            <label>Es la cantidad de dinero que se ha prestado y sobre la cual se pagará un interés en función de la duración del préstamo y riesgo del adquiriente del préstamo.</label>
            </br></br>

            <button onclick="document.getElementById('capital').style.display='none'"
                class="modal_btn button button_formulario pulse">Aceptar</button>
        </div>
        <div class="modal_container" style="background-color:#f1f1f1">
        </div>
    </div>
</div>

<div id="interes" class="modal">
    <div class="modal-content animate">
        <div class="imgcontainer_formulario">
            <span onclick="document.getElementById('interes').style.display='none'" class="close"
                title="Close Modal">&times;</span>
            <img src="assets/img/interes_con.png" alt="Avatar" class="avatar_formulario">
        </div>

        <div class="modal_container_formulario">
            <h3><b>Interés</b></h3></br>
            <label>Es el costo del uso del dinero entregado en préstamo, que se expresa como porcentaje.</label>
            </br></br>
            <label>Las sumas que el banco recibe por el dinero prestado (precio del dinero), siempre se establece en términos porcentual anual.</label>
            </br></br>

            <button onclick="document.getElementById('interes').style.display='none'"
                class="modal_btn button button_formulario pulse">Aceptar</button>
        </div>
        <div class="modal_container" style="background-color:#f1f1f1">
        </div>
    </div>
</div>

<div id="personal" class="modal">
    <div class="modal-content animate">
        <div class="imgcontainer_formulario">
            <span onclick="document.getElementById('personal').style.display='none'" class="close"
                title="Close Modal">&times;</span>
            <img src="assets/img/personal_con.png" alt="Avatar" class="avatar_formulario">
        </div>

        <div class="modal_container_formulario">
            <h3><b>Préstamo Personal</b></h3></br>
            <label>Es un crédito que el banco u otra entidad financiera otorga a personas naturales, que te permite obtener dinero en efectivo para satisfacer cualquier necesidad económica como pagar una deuda, financiar los estudios de tus hijos, realizar el pago de servicios, hacer un viaje en tus vacaciones y más.</label>
            </br></br>

            <button onclick="document.getElementById('personal').style.display='none'"
                class="modal_btn button button_formulario pulse">Aceptar</button>
        </div>
        <div class="modal_container" style="background-color:#f1f1f1">
        </div>
    </div>
</div>

<div id="mensualidad" class="modal">
    <div class="modal-content animate">
        <div class="imgcontainer_formulario">
            <span onclick="document.getElementById('mensualidad').style.display='none'" class="close"
                title="Close Modal">&times;</span>
            <img src="assets/img/mensualidad_con.png" alt="Avatar" class="avatar_formulario">
        </div>

        <div class="modal_container_formulario">
            <h3><b>Mensualidad</b></h3></br>
            <label>Cantidad de dinero que se abona mes a mes al credito o préstamo.</label>
            </br></br>
            <label>Es la cantidad económica que pagas cada mes por devolver el préstamo. Dentro de esta cantidad están los intereses y la amortización.</label>
            </br></br>

            <button onclick="document.getElementById('mensualidad').style.display='none'"
                class="modal_btn button button_formulario pulse">Aceptar</button>
        </div>
        <div class="modal_container" style="background-color:#f1f1f1">
        </div>
    </div>
</div>

<div id="plazo" class="modal">
    <div class="modal-content animate">
        <div class="imgcontainer_formulario">
            <span onclick="document.getElementById('plazo').style.display='none'" class="close"
                title="Close Modal">&times;</span>
            <img src="assets/img/plazo_con.png" alt="Avatar" class="avatar_formulario">
        </div>

        <div class="modal_container_formulario">
            <h3><b>Plazo</b></h3></br>
            <label>Es el tiempo establecido o acordado para que el deudor cancele el crédito otorgado al banco. El plazo se determina de acuerdo con el plan de inversión, la naturaleza de la garantía y la capacidad de pago del deudor.</label>
            </br></br>

            <button onclick="document.getElementById('plazo').style.display='none'"
                class="modal_btn button button_formulario pulse">Aceptar</button>
        </div>
        <div class="modal_container" style="background-color:#f1f1f1">
        </div>
    </div>
</div>

<div id="fecha" class="modal">
    <div class="modal-content animate">
        <div class="imgcontainer_formulario">
            <span onclick="document.getElementById('fecha').style.display='none'" class="close"
                title="Close Modal">&times;</span>
            <img src="assets/img/fecha_con.png" alt="Avatar" class="avatar_formulario">
        </div>

        <div class="modal_container_formulario">
            <h3><b>Fecha de Pago</b></h3></br>
            <label>Corresponde al día definido para que el deudor u obligado efectúe el pago del importe correspondiente según la frecuencia de pago de intereses o amortización.</label>
            </br></br>

            <button onclick="document.getElementById('fecha').style.display='none'"
                class="modal_btn button button_formulario pulse">Aceptar</button>
        </div>
        <div class="modal_container" style="background-color:#f1f1f1">
        </div>
    </div>
</div>


<script>

    // Get the modal
    var modal = document.getElementById('capital');
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Get the modal
    var modal = document.getElementById('interes');
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Get the modal
    var modal = document.getElementById('personal');
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Get the modal
    var modal = document.getElementById('mensualidad');
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Get the modal
    var modal = document.getElementById('plazo');
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Get the modal
    var modal = document.getElementById('fecha');
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

</script>