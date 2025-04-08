<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plantilla Base - 20240923</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <?php
        // Archivos a incluir
        require("inc/menu.php");

        // Paso 1: Datos de la conexion
        $usuario = 'root';
        $clave = '';
        $servidor = 'localhost';
        $basededatos = 'tp1';

        // Paso 2: Creamos la conexion
        $conexion = mysqli_connect($servidor,$usuario,$clave);

        // Paso 3: Me conecto a la Base de datos
        $db = mysqli_select_db($conexion,$basededatos);

        // Paso 4: Consultas a SQL
        //$consulta = "select * from usuario";
        $consulta1 = "select count(distinct usuario) as usuarios from usuario";

        // Paso 5: Guardamos el resultado de la query
        //$resultado = mysqli_query($conexion,$consulta);
        $resultado1 = mysqli_query($conexion,$consulta1);

        // Obtener el valor
        while ($fila = mysqli_fetch_assoc($resultado1)){
            $cantidad_usuarios = $fila['usuarios'];
        };

        //echo "Usuarios desde la BDD: ".$cantidad_usuarios;

        // Consulta con variable
        $rol = 'administrador';
        $consulta2 = "select count(distinct usuario) as usuarios from usuario where rol = '$rol'";

        $resultado2 = mysqli_query($conexion,$consulta2);

        while ($fila = mysqli_fetch_assoc($resultado2)){
            $cantidad_administrador = $fila['usuarios'];
        };

        $rol1 = 'analista';
        $consulta3 = "select count(distinct usuario) as usuarios from usuario where rol = '$rol1'";

        $resultado3 = mysqli_query($conexion,$consulta3);

        while ($fila = mysqli_fetch_assoc($resultado3)){
            $cantidad_analista = $fila['usuarios'];
        };

    ?>
</head>
<body class="container">
    <!--Barra de navegación-->
    <?php menu(); ?>
    <!--Título de la página-->
    <div class="alert alert-primary text-center fst-italic" role="alert">
        <h4>Práctica de ABM.</h4>
    </div>

    <!-- Fila 1-->
     <div class="row">
            <div class="col-3">
                <button type="button" class="btn btn-primary container-fluid">
                    <?php echo 'Cantidad de Usuarios: '.$cantidad_usuarios;?>
                </button>
                <!--<button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-content="Bottom popover">
                
                </button>-->
            </div>
            <div class="col-3">
                <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-content="<?php echo 'Administradores'.$cantidad_administrador;?>">
                <?php echo 'Cantidad de Administradores: '.$cantidad_administrador;?>
                </button>
            </div>
            <div class="col-3">
            <button type="button" class="btn btn-primary container-fluid">
                    <?php echo 'Cantidad de Analistas: '.$cantidad_analista;?>
            </button>

            </div>
            <div class="col-3"></div>
     </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>