<?php
    //Declaramos la función
    function carrusels(){   
?>

    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="img/italian.jpg" class="img-fluid" alt="...">
            <!--<img src="img/dog.png" class="img-fluid" alt="...">-->
            <!--<img src="img/russian.jpg" class="img-fluid" alt="...">-->
        </div>
        <div class="carousel-item">
            <!--<img src="img/russian.jpg" class="d-block w-50" alt="...">-->
            <img src="img/russian.jpg" class="img-fluid" alt="...">
        </div>
        <div class="carousel-item">
            <img src="img/siberian.jpg" class="img-fluid" alt="...">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
    </div>
    <p></p>


<?php
    }
?>