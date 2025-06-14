<?php
    //Declaramos la función
    function acercadeleft(){   
?>

    <!--<button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">Enable body scrolling</button>-->
    <button class="btn btn-link" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">Acerca del Sistema</button>

    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Acerca del Sistema</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <h5>Grupo #2 - Instituto Rosello (2025)</h5>
            <br>
            <p><b>Desarrolladores:</b></p>
            <p>✔️ Luis Morocho</p>
            <p>✔️ Mariano País Garay</p>
            <p>✔️ Ariel Toneguzzi</p>
            <p>✔️ Agustí Arufe</p>
            <br>
            <p>Sistema de Veterinaria actualizada.</p>
            <p>Última version v3.0.1</p>
        </div>
    </div>

<?php
    }
?>