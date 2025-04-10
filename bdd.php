<?php
  session_start();
  //verificar si esta creada una vez que está logeado
  if(!isset($_SESSION['autorizado'])){
    //Con isset para verifcar al cominezo del documento, sino existe la creamos
    $_SESSION['autorizado']='no';
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> ABM</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <?php
        // Archivos a incluir
        require("inc/menu.php");
        include('inc/conexion.PHP');


        // PASO 1) Datos de conexón 
        $usuario = 'root';
        $clave = '';
        $servidor = 'localhost';
        $basededatos = 'tp1';

        // PASO 2) Creamos la conexión
        $conexion = mysqli_connect($servidor,$usuario,$clave);

        // PASO 3) Me conecto a las base de datos
        $db = mysqli_select_db($conexion,$basededatos);

        // PASO 4) Consultas a SQL de un valor
        // $consulta = "select * from usuario";
        $consulta1 = "select count(distinct usuario) as usuarios from usuario";

        // PASO 5) Obtnemos y guardamos el resultado
        // $resultado = mysqli_query($conexion,$consulta);
        $resultado1 = mysqli_query($conexion,$consulta1);
        
 
        // Obtenemos el valor
        while ($fila = mysqli_fetch_assoc($resultado1)){
            $cantidad_usarios = $fila['usuarios'];
        }
        // echo "Usuarios desde la BDD: ".$cantidad_usario;

            // Consultamos un solo valor
        $consulta1 = "select count(distinct usuario) as usuarios from usuario";
        $resultado1 = mysqli_query($conexion,$consulta1);
        while ($fila = mysqli_fetch_assoc($resultado1)){
            $cantidad_usarios = $fila['usuarios'];
        }
        // Consultamos un solo valor
        $consulta1 = "select count(distinct usuario) as usuarios from usuario";
        $resultado1 = mysqli_query($conexion,$consulta1);
        while ($fila = mysqli_fetch_assoc($resultado1)){
            $cantidad_usarios = $fila['usuarios'];
        }
        // Consulta con variable (ADMINISTRADOR)
        $rol = 'administrador';
        $consulta2 = "select count(distinct usuario) as usuarios from usuario where rol = '$rol'";
        $resultado2 = mysqli_query($conexion,$consulta2);
        while ($fila = mysqli_fetch_assoc($resultado2)){
            $cantidad_administrador = $fila['usuarios'];
        }
        
        // Consulta con variable (ANALISTA)
        $rol = 'analista';
        $consulta3 = "select count(distinct usuario) as usuarios from usuario where rol = '$rol'";
        $resultado3 = mysqli_query($conexion,$consulta3);
        while ($fila = mysqli_fetch_assoc($resultado3)){
            $cantidad_analista = $fila['usuarios'];
        }
        // Consulta la tabla completa
        $consulta4 = "select distinct * from usuario";
        $resultado4 = mysqli_query( $conexion, $consulta4 ) or die ('No se ha podido ejecutar la consulta 4.')



    ?>
</head>
<body class ="Container">
    <!-- Barra de navegación -->  
    <div class="container">
    <?php menu(); ?>
        <!-- Título de la página -->
    <div class="alert alert-primary text-center fst-italic" role="alert">
        <h4>Práctica de ABM.</h4>
    </div>

    <!-- Fila 1 -->
    <div class="row">
        <div class="col-3">
            <button type="button" class="btn btn-primary container-fluid">
                <?php echo 'Cantidad de usuarios: '.$cantidad_usarios; ?>
            </button>
        </div>
        <div class="col-3">
        <button type="button" class="btn btn-success container-fluid">
                <?php echo 'Cantidad de administradores: '.$cantidad_administrador; ?>
            </button>
        </div>
        <div class="col-3">
        <button type="button" class="btn btn-warning container-fluid">
                <?php echo 'Cantidad de analistas: '.$cantidad_analista; ?>
            </button>
        </div>

        <div class="col-3">
    <button type="button" class="btn btn-danger container-fluid">
            <a href="alta_usuario.php"  style="color:white;text-decoration:none">Nuevo Usuario</a>

        </button>
    </div>
</div>
<br>
<br>
<div class="table-responsive">
        <table class="table table-bordered table-sm table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <td>Usuario</td>
                    <td>Clave</td>
                    <td>Rol</td>
                    <td>Acciones</td>
                </tr>
            </thead>
            <tbody class="table-success">
            <?php
                      while($fila=mysqli_fetch_array($resultado4)){
                        echo "<tr>";
                            echo "<td>".$fila['usuario']."</td>";
                            echo "<td>".$fila['clave']."</td>";
                            echo "<td>".$fila['rol']."</td>";
                            echo "<td>
                                    <a href='modifica_usuario.php?usuario=".$fila['usuario']."&clave=".$fila['clave']."&rol=".$fila['rol']."' 
                                        style='text-decoration:none'>
                                       <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
                                            <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z'/>
                                        </svg>
                                    </a>
                                    <a href='baja_usuario.php?usuario=".$fila['usuario']."
                                        &clave=".$fila['clave']."
                                        &rol=".$fila['rol']."' 
                                        style='text-decoration:none'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash3-fill' viewBox='0 0 16 16'>
                                            <path d='M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5'/>
                                        </svg>
                                    </a>
                                </td>";
                        echo "</tr>";
                    }
                ?>

            </table>
        </div>
    </div>
    

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

