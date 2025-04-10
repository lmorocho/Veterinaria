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
    <title>Formulario</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <?php
      require("inc/menu.php")
    ?>
    </head>
    <body class ="container">

   
<!-- Barra de navegación -->  
<?php menu(); ?>

<!-- Título de la página -->
  <div class="alert alert-primary text-center fst-italic" role="alert">
    <h4>Título de la página.</h4>
  </div>

  <!-- Barra de navegación -->  
<div class="row">
      <div class="col-4"></div>
      <div class="col-4">

    <!-- Relleno de text box -->
      <form action="formulario_destino.php" method="POST">
        <div class="mb-3">
           <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre">
        </div>
        <div class="mb-3">
            <label for="apellido">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingrese su apellido">
        </div>
        <div class="mb-3">
            <label for="clave">Clave</label>
            <input type="password" class="form-control" id="clave" name="clave" placeholder="Ingrese su clave">
         </div>

            <!-- Línea -->
          <hr size="2px" color="black">

              <!-- Checkbox -->
            <h6 class="fst-italic">Seleccione sus materias favoritas.</h6>
            <div class="form-group">
                <input type="checkbox" id="materia1" name="materia1" value="PHP">
                <label for="materia1">Páginas Web</label>
            </div>
            <div class="form-group">
                <input type="checkbox" id="materia2" name="materia2" value="JAVA">
                <label for="materia2">Programación Java</label>
            </div>
            <div class="form-group">
                <input type="checkbox" id="materia3" name="materia3" value="BASE DE DATOS">
                <label for="materia3">Base de Datos</label>
            </div> 

              <!-- Línea -->
            <hr size="3px" color="black">
            <fieldset>
                <legend>Seleccione su nivel de inglés</legend>
              <div class="form-group">
                 <label>
                    <input type="radio" name="nivel" value="Alto">Alto
                </label>
              </div>
             <div class="form-group">
                <label>
                    <input type="radio" name="nivel" value="Medio">Medio
                </label>
              </div>
              <div class="form-group">
                <label>
                    <input type="radio" name="nivel" value="Bajo">Bajo
                </label>
              </div>
              </fieldset>
  
              <!-- Línea -->
            <hr size="3px" color="black">
  
            <!-- Select -->
      <div class="form-group">
        <label for="selector1">Seleccione el motivo de su contacto.</label>
        <select name="selector1" id="selector1">
            <option value="Consulta">Consulta</option>
            <option value="Sugerencia">Sugerencia</option>
            <option value="Queja">Queja</option>
        </select>
      </div>

  <!-- Línea -->
  <hr size="3px" color="black">

  <!-- Botón Enviar -->
  <button type="submit" class="btn btn-primary container-fluid">Enviar</button> 
    
  <!-- Línea -->
  <hr size="3px" color="black">
  
  <!-- Fin   -->
  </form>
  </div>
  <div class="col-4"></div>
</div>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

