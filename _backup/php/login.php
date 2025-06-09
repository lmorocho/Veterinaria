<div class="container mt-5">
  <h2 class="mb-4">Acceso al Sistema Veterinario</h2>
  <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <form action="login_cliente.php" method="post">
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Contraseña</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Ingresar</button>
  </form>
  <p class="mt-3">¿No tienes cuenta? <a href="cliente_mascota.php">Registrarse</a></p>
</div>