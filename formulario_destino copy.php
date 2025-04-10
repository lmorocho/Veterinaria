<?php
    // Acceder a los datos.
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $clave = $_POST["clave"];

    // Recupero el checkboc
    if(isset($_POST["materia1"])){
        $materia1 = $_POST["materia1"];
    } else $materia1 = "";

    if(isset($_POST["materia2"])){
        $materia2 = $_POST["materia2"];
    } else $materia2 = "";

    if(isset($_POST["materia3"])){
        $materia3 = $_POST["materia3"];
    } else $materia3 = "";

    if(isset($_POST['nivel'])){
        $nivel = $_POST['nivel'];
    }else $nivel = 'El nivel de ingles no fue enviado';

    $selector1 = $_POST['selector1'];

    // Muestro los datos
    echo 'Nombre recibido: '.$nombre.'<br>';
    echo 'Apellido recibido: '.$apellido.'<br>';
    echo "Clave recibida: ".$clave."<br>";
    echo "Materias preferidas: ".$materia1.' '.$materia2.' '.$materia3."<br>";
    echo 'Nivel de Inglés: '.$nivel."<br>";
    echo 'Motivo de consulta: '.$selector1."<br>";

?>