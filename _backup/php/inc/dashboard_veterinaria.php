<?php
    //Declaramos la función
    function dashboard(){   
?>

    <!--<div class="container">-->
        <!--<h2>Dashboard</h2>-->
        <div class="numbers">
            <div class="text-bg-secondary p-3">
                <br>
                <!-- Titulo centrado de la seccion-->
                <div class="row text-center">
                    <div class="col-3">
                        <div class="d-flex justify-content-center">
                        <!--<h2>Dashboard</h2>-->
                        <!--<div class="card text-bg-secondary mb-3" style="max-width: 18rem;">-->
                            <div class="card text-bg-warning mb-3" style="width: 22rem;">
                            <!--<div background-color: #ff6445 img src="img/paws.png">-->
                                <div class="card-header"><h6>Total Clientes</h6></div>
                                <div class="card-body">
                                    <p class="card-text"><h2>120</h2></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="d-flex justify-content-center">
                        <!--<div>Total Mascotas: <span id="total-mascotas">250</span></div>-->
                            <div class="card text-bg-warning mb-3" style="width: 22rem;">
                                <div class="card-header"><h6>Total Mascotas</h6></div>
                                <div class="card-body">
                                    <p class="card-text"><h2>250</h2></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="d-flex justify-content-center">
                            <!--<div>Ventas del Mes: <span id="ventas-mes">$35,000</span></div>-->
                            <div class="card text-bg-warning mb-3" style="width: 22rem;">
                                <div class="card-header"><h6>Ventas del Mes</h6></div>
                                <div class="card-body">
                                    <p class="card-text"><h2>$35.000 ARS</h2></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="d-flex justify-content-center">
                            <!--<div>Turnos Hoy: <span id="turnos-hoy">8</span></div>-->
                            <div class="card text-bg-warning mb-3" style="width: 22rem;">
                                <div class="card-header"><h6>Total de Turnos Hoy</h6></div>
                                <div class="card-body">
                                    <p class="card-text"><h2>8</h2></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        
        <!--Resumenes-->
        <div class="resumenes">
            <div class="text-bg-secondary p-3">
                <br>
                <!-- Titulo centrado de la seccion-->
                <div class="row text-center">
                    <div class="col-4">
                        <div class="d-flex justify-content-center">
                            <!--<div class="card text-bg-secondary mb-3" style="width: 28rem;">
                                <div class="card-header text-center"><h6>Últimas Citas Médicas</h6></div>
                                <div class="card-body">
                                    <p class="card-text"><h4>
                                        <ul id="ultimas-citas">
                                            <li>Firulais - Consulta general</li>
                                            <li>Pelusa - Vacunación</li>
                                        </ul>
                                    </h4></p>
                                </div>
                            </div>-->
                            <div class="card text-bg-dark mb-3" style="width: 28rem;">
                                <div class="card-header">Últimas Citas Médicas</div>
                                <ul class="list-group list-group-flush" id="ultimas-citas">
                                    
                                    <li class="list-group-item">Firulais - Consulta general</li>
                                    <li class="list-group-item">Pelusa - Vacunación</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-4">
                        <div class="d-flex justify-content-center">
                            <!--<div class="card text-bg-secondary mb-3" style="width: 28rem;">
                                <div class="card-header"><h6>Productos con Menor Stock</h6></div>
                                <div class="card-body">
                                    <p class="card-text"><h4>
                                        <ul id="stock-bajo">
                                            <li>Alimento X - 2 unidades</li>
                                            <li>Vacuna Y - 1 unidad</li>
                                        </ul>
                                    </h4></p>
                                </div>
                            </div>-->
                            <div class="card text-bg-dark mb-3" style="width: 28rem;">
                                <div class="card-header">Productos con Menor Stock</div>
                                <ul class="list-group list-group-flush" id="menor-stock">
                                    <li class="list-group-item">Alimento X - 2 unidades</li>
                                    <li class="list-group-item">Vacuna Y - 1 unidad</li>
                                </ul>
                            </div>
                        </div>  
                    </div>

                    <div class="col-4">
                        <div class="d-flex justify-content-center">
                            <!--<div class="card text-bg-secondary mb-3" style="width: 28rem;">
                                <div class="card-header"><h6>Próximos Cumpleaños de Mascotas</h6></div>
                                <div class="card-body">
                                    <p class="card-text"><h4>
                                        <ul id="cumple-mascotas">
                                            <li>Luna - 22 Abril</li>
                                            <li>Roco - 25 Abril</li>
                                        </ul>
                                    </h4></p>
                                </div>
                            </div>-->
                            <div class="card text-bg-dark mb-3" style="width: 28rem;">
                                <div class="card-header">Próximos Cumpleaños de Mascotas</div>
                                <ul class="list-group list-group-flush" id="cumple-mascotas">
                                    <li class="list-group-item">Luna - 28 Abril</li>
                                    <li class="list-group-item">Roco - 05 Mayo</li>
                                </ul>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
        <br><br>       
    <!--</div>-->

<?php
    }
?>