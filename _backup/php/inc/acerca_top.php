<?php
    //Declaramos la función
    function acercadetop(){   
?>
    
    <!--<button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">Enable body scrolling</button>-->
    <!--<button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Acerca de la Veterinaria</button>-->
    <!--<button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">Toggle top offcanvas</button>-->
    <button class="btn btn-link" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">Acerca de los Turnos</button>

    <div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasTopLabel">Solicitud de Tipo de Turno</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p>- Registrese en el sistema, seleccione el tipo de turno, eliga la fecha y hora de la cita</p>
            <p>- Confirme la cita, reciba un recordatorio de la cita y asista con su mascota</p>
            <p><b>Recuerde que puede cancelar o modificar la cita en cualquier momento.</b></p>
        </div>
    </div>

<?php
    }
?>