
<?php include('conexion.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Menú Principal - Grupo 2 - Sistema Veterinaria - Instituto Rosello</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- Font Awesome Free -->
  <link   rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!--<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">-->
  <link href="css/custom.css" rel="stylesheet">
  <?php
    require("inc/menu.php");
    require("inc/carrusel.php");
    require("inc/acerca_left.php");
    require("inc/acerca_top.php");
    require("inc/acerca_right.php");
    require("inc/chat_bot.php");
    require("inc/banner1.php");
    require("inc/dashboard_veterinaria.php");
  ?>
  <style>
    .mapa-veterinaria iframe {
      border-radius: 0 0.5rem 0.5rem 0;
      width: 100%;
      height: 380px;
    }
    .imagen-veterinaria img {
      border-radius: 0.5rem 0 0 0.5rem;
      object-fit: cover;
      width: 100%;
      height: 380px;
    }
  </style>
</head>
<body>
    <?php menu(); ?>
    <!--Título de la página-->
    <div class="alert alert-warning text-center fst-italic" role="alert">
        <h4>Bienvenido al Sistema de Veterinaria</h4>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <!--<form action="login_cliente.php" method="post">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>-->
    </div>

    <!--Banner Landing-->
    <div class="text-center">
        <!--Slides automaticos-->
        <?php carrusels(); ?>

        <div class="alert alert-secondary" role="alert">
            <!--<h5>Nosotros cuidamos tus mascotas!</h5>-->
            <div class="row">
                <div class="col-4 flexbox">
                <!--<button class="btn btn-link" type="button">Link1</button>-->
                    <!--Barra lateral izquierda navegación-->
                    <?php acercaderight(); ?>
                </div>
                <div class="col-4 flexbox">
                    <!--<button class="btn btn-link" type="button">Link2</button>-->
                    <?php acercadetop(); ?>
                </div>
                <div class="col-4 flexbox">
                    <!--Barra lateral izquierda navegación-->
                    <?php acercadeleft(); ?>
                </div>
                <div class="col-4 flexbox">
                    <!--<button class="btn btn-link" type="button">Chat Veterinaria</button>-->
                    <?php chatbot(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Banner1 Veterinaria -->
    <?php bannerpet1(); ?>

    <!-- Dashboard Veterinaria con estadística de los clientes y mascotas -->
    <?php dashboard(); ?>
    <br><br>

    <!-- Información de la veterinaria -->
    <div class="alert alert-secondary" role="alert">
        <h4>Tu veterinaria de confianza</h4>
        <p>En Veterinaria Entre Ríos, cuidamos de tus mascotas como si fueran nuestras. Ofrecemos servicios de salud, estética y bienestar para que tu compañero peludo esté siempre feliz y saludable.</p>
        <p>Contamos con un equipo de profesionales apasionados por los animales, listos para brindarte la mejor atención y asesoramiento. ¡Tu mascota merece lo mejor!</p>
        <p>Visítanos en nuestra sucursal en Entre Ríos 1234, CABA, o contáctanos al (011) 1234-5678. Estamos aquí para ayudarte a cuidar de tu mejor amigo.</p>
    </div>

    <!-- Imagen y mapa Google Maps -->
    <div class="container my-5">
      <div class="row justify-content-center align-items-center g-4 px-3">
        <div class="col-md-5 imagen-veterinaria d-flex justify-content-center">
          <img src="img/Veterinaria_entre_rios-caba_boedov2.jpg" alt="Veterinaria" class="img-fluid">
        </div>
        <div class="col-md-7 mapa-veterinaria">
          <div class="card h-100">
            <div class="card-header bg-dark text-white">
              <h5 class="mb-0">Ubicación de la Veterinaria Entre Ríos</h5>
            </div>
            <div class="card-body p-0">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3282.7509800257853!2d-58.415991600000005!3d-34.6357327!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bccb0795debfff%3A0x7f73ebf67d8b962b!2sVETERINARIA%20ENTRE%20RIOS!5e0!3m2!1ses-419!2sar!4v1748284823792!5m2!1ses-419!2sar"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
              </iframe>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
