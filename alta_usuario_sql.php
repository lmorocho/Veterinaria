   <?php 
        //Conexion
        include('inc/conexion.PHP');
        
        //Levanto los valores del POST
        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];
        $rol = $_POST['rol'];

        //Verificamos si el usuario existe
        $consulta1 = "select count(distinct usuario) as nuevo from usuario where usuario = '$usuario'";

        $resultado1 = mysqli_query($conexion,$consulta1);

        while($a = mysqli_fetch_assoc($resultado1)){
            $existe = $a['nuevo'];
        }

        //Estructura de decision
        if($existe==1){
            //Modificamos el mensaje y redirigimos el formulario.
            header("Location:alta_usuario.php?mensaje=uno");
        }else{
            // El usuario no existe, lo damos de alta
            $alta = "insert into usuario values('$usuario','$clave','$rol')";
            $resultado_alta = mysqli_query($conexion,$alta);
            header("localhost.bdd.php");
        }
    ?>
</head>
    <body class ="container">

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
