<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABM</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <?php  
    
        //PASO 1) datos de la conexión

        $usuario = 'root';
        $clave = '';
        $servidor = 'localhost';
        $basededatos = 'tp1';

        //PASO 2) crear la conexion

        $conexion = mysqli_connect($servidor,$usuario,$clave) or die ('No se pudo conectar con el Servidor');

        //PASO 3) conectar a BDD

        $db = mysqli_select_db($conexion,$basededatos) or die ('No se pudo conectar a la BDD');
  
    ?>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
