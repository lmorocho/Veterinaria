<?php
//admin_registro.php
require("inc/auth_admin.php");
require("conexion.php");
require("inc/menu_admin.php");

$usuario = $_SESSION['usuario']['Nombre_Usuario'] ?? 'Administrador';

// Consulta de roles para el select excepto para el rol de Proveedor (ID_Rol = 4)
$roles_result = $conexion->query("SELECT ID_Rol, Nombre_Rol FROM Rol_Usuario where ID_Rol != 4");
$roles = $roles_result->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/custom.css" rel="stylesheet">
  <style>
    body {
      background-image: url('img/paws_background.png');
      background-repeat: repeat;
      background-attachment: fixed;
    }
    body::before {
      content: "";
      position: fixed;
      top: 0; left: 0;
      width: 100vw; height: 100vh;
      background: rgba(255,255,255,0.5);
      pointer-events: none;
      z-index: -1;
    }
  </style>
</head>
<body>
  <?php menu_admin(); ?>
  <div class="alert alert-warning text-center fst-italic" role="alert">
  <h4>Registro y Alta de Usuarios</h4>
  
  </div>
  <div class="container mt-4">
    <h2 class="text mb-4">Datos del Usuario</h2>

     <!-- Mostrar modal error -->
    <?php if (isset($_SESSION['modal_error'])): ?>
    <div class="modal fade show" id="modalError" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" style="display:block; background: rgba(0,0,0,0.5);">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-warning text-white">
            <h5 class="modal-title fs-5">Registro de guardado con Error</h5>
          </div>
          <div class="modal-body">
            <?= htmlspecialchars($_SESSION['modal_error']); unset($_SESSION['modal_error']); ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="window.location='admin_registro.php';">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <!-- Mostrar modal de registro guardado -->
    <?php if (isset($_SESSION['modal_exito'])): ?>
    <div class="modal fade show" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display:block; background: rgba(0,0,0,0.5);">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-dark text-white">
            <h5 class="modal-title fs-5" id="staticBackdropLabel">Registro exitoso</h5>
          </div>
          <div class="modal-body">
            <?= htmlspecialchars($_SESSION['modal_exito']); unset($_SESSION['modal_exito']); ?>
          </div>
          <div class="modal-footer">
            <a href="admin_dashboard.php" class="btn btn-secondary">Cancelar</a>
            <a href="admin_registro.php" class="btn btn-primary">Registrar otro</a>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <form action="admin_guardar_registro.php" method="post" class="row g-3 needs-validation" novalidate>
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control only-letters" required minlength="2" maxlength="50" 
              pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{2,50}$" title="Sólo letras y espacios (2 a 50 caracteres)">
            <div class="invalid-feedback">Debe ingresar un nombre válido (sólo letras y espacios, 2–50).</div>
          </div>
          <div class="mb-3">
            <label>Apellido</label>
            <!--<input type="text" name="apellido" class="form-control" required>-->
            <input type="text" id="apellido" name="apellido" class="form-control only-letters" required minlength="2" maxlength="50"
               pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{2,50}$" title="Sólo letras y espacios (2 a 50 caracteres)">
              <div class="invalid-feedback">Debe ingresar un apellido válido (sólo letras y espacios, 2–50).</div>
          </div>
          <div class="mb-3">
            <label>DNI</label>
            <!--<input type="text" name="dni" class="form-control" required>-->
            <input type="text" id="dni" name="dni" class="form-control" required inputmode="numeric" minlength="7" maxlength="10"
               pattern="^\d{7,10}$" title="Ingrese sólo números (7 a 10 dígitos)">
              <div class="invalid-feedback">Ingrese un DNI válido (7 a 10 dígitos).</div>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <!--<input type="email" name="email" class="form-control" required>-->
            <input type="email" id="email" name="email" class="form-control email-field" required maxlength="100"
               inputmode="email" autocomplete="email"
               pattern="^[^ @]+@[^ @]+[.][^ @]{2,}$" title="Ingresa un email válido (ej: usuario@dominio.com)">
            <div class="invalid-feedback">Debe ingresar un email válido.</div>
          </div>
          <div class="mb-3">
            <label>Teléfono</label>
            <!--<input type="text" name="telefono" class="form-control" required>-->
            <input type="text" id="telefono" name="telefono" class="form-control only-phone" inputmode="tel" minlength="10" maxlength="14"
               pattern="^\+?\d{10,14}$" title="Formato: opcional + y 10 a 14 dígitos">
               <div class="invalid-feedback">Ingrese un Telefono válido (10 a 14 dígitos).</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label>Dirección</label>
            <!--<input type="text" name="direccion" class="form-control" required>-->
            <input type="text" id="direccion" name="direccion" class="form-control" minlength="4" maxlength="100">
          </div>
          <div class="mb-3">
            <label>Fecha de Nacimiento</label>
            <!--<input type="date" name="fecha_nacimiento" class="form-control" required>-->
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" required max="<?= $maxDate ?>"
               title="Debe tener al menos 10 años">
            <div class="invalid-feedback">Debe ingresar una fecha válida (al menos 10 años).</div>
          </div>
          <div class="mb-3">
            <label>Nombre de Usuario</label>
            <!--<input type="text" name="usuario" class="form-control" required>-->
            <input type="text" id="usuario" name="usuario" class="form-control" required minlength="4" maxlength="20"
               pattern="^[A-Za-z0-9._-]{4,20}$" title="4-20 caracteres: letras, números, punto, guion y guion bajo">
            <div class="invalid-feedback">Usuario inválido (4-20: letras, números, ., _ o -).</div>
          </div>
          <div class="mb-3">
            <label>Contraseña</label>
            <!--<input type="password" name="password" class="form-control" required>-->
            <input type="password" id="password" name="password" class="form-control" required minlength="8"
               pattern="^(?=.*[A-Za-z])(?=.*\d).{8,}$" title="Mínimo 8 caracteres, al menos 1 letra y 1 número">
            <div class="invalid-feedback">Mínimo 8, con al menos 1 letra y 1 número.</div>
          </div>
          <div class="mb-3">
            <label>Tipo de Rol</label>
            <select name="id_rol" class="form-select" required>
              <option value="" selected disabled>Seleccione un rol</option>
              <?php foreach ($roles as $rol): ?>
              <option value="<?= $rol['ID_Rol'] ?>"><?= htmlspecialchars($rol['Nombre_Rol']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-primary">Guardar Usuario</button>
        <a href="admin_dashboard.php" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>

  </div>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script>
    //Validación de los textbox con un js//
    (function() {
    'use strict';
    // Bootstrap validation
      const forms = document.querySelectorAll('.needs-validation');
      Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });

      // Teclas de navegación permitidas
      const navKeys = ['Backspace','Delete','ArrowLeft','ArrowRight','ArrowUp','ArrowDown','Tab','Home','End','Enter'];

      // Bloquear números en campos sólo letras (keydown y sanitizar en input/paste)
      document.querySelectorAll('.only-letters').forEach(input => {
        input.setAttribute('inputmode', 'text');
        input.addEventListener('keydown', e => {
          if (navKeys.includes(e.key) || e.ctrlKey || e.metaKey || e.altKey) return;
          if (/^[0-9]$/.test(e.key)) e.preventDefault();
        });
        input.addEventListener('input', e => {
          e.target.value = e.target.value.replace(/[0-9]/g, '');
        });
        input.addEventListener('paste', e => {
          e.preventDefault();
          const text = (e.clipboardData || window.clipboardData).getData('text');
          const clean = text.replace(/[0-9]/g, '');
          const start = e.target.selectionStart;
          const end = e.target.selectionEnd;
          const val = e.target.value;
          e.target.value = val.slice(0, start) + clean + val.slice(end);
          const pos = start + clean.length;
          e.target.setSelectionRange(pos, pos);
        });
      });

      // Aceptar sólo números en DNI (keydown / input / paste)
      const dniInput = document.getElementById('dni');
      if (dniInput) {
        dniInput.setAttribute('inputmode', 'numeric');
        const max = parseInt(dniInput.getAttribute('maxlength') || '0', 10);

        dniInput.addEventListener('keydown', e => {
          if (navKeys.includes(e.key) || e.ctrlKey || e.metaKey || e.altKey) return;
          if (!/^[0-9]$/.test(e.key)) { e.preventDefault(); return; }
          if (max && dniInput.value.length >= max && dniInput.selectionStart === dniInput.selectionEnd) {
            e.preventDefault();
          }
        });

        dniInput.addEventListener('input', e => {
          let v = e.target.value.replace(/[^0-9]/g, '');
          if (max) v = v.slice(0, max);
          e.target.value = v;
        });

        dniInput.addEventListener('paste', e => {
          e.preventDefault();
          const text = (e.clipboardData || window.clipboardData).getData('text') || '';
          let clean = text.replace(/[^0-9]/g, '');
          const start = dniInput.selectionStart;
          const end = dniInput.selectionEnd;
          const val = dniInput.value;
          let next = val.slice(0, start) + clean + val.slice(end);
          if (max) next = next.slice(0, max);
          dniInput.value = next;
          const pos = Math.min(start + clean.length, next.length);
          dniInput.setSelectionRange(pos, pos);
        });
      }

      // Aceptar sólo números en telefono (keydown / input / paste)
      const phoneInput = document.getElementById('telefono');
      if (phoneInput) {
        phoneInput.setAttribute('inputmode', 'numeric');
        const max = parseInt(phoneInput.getAttribute('maxlength') || '0', 10);

        phoneInput.addEventListener('keydown', e => {
          if (navKeys.includes(e.key) || e.ctrlKey || e.metaKey || e.altKey) return;
          if (!/^[0-9]$/.test(e.key)) { e.preventDefault(); return; }
          if (max && phoneInput.value.length >= max && phoneInput.selectionStart === phoneInput.selectionEnd) {
            e.preventDefault();
          }
        });

        phoneInput.addEventListener('input', e => {
          let v = e.target.value.replace(/[^0-9]/g, '');
          if (max) v = v.slice(0, max);
          e.target.value = v;
        });

        phoneInput.addEventListener('paste', e => {
          e.preventDefault();
          const text = (e.clipboardData || window.clipboardData).getData('text') || '';
          let clean = text.replace(/[^0-9]/g, '');
          const start = phoneInput.selectionStart;
          const end = phoneInput.selectionEnd;
          const val = dniIphoneInputnput.value;
          let next = val.slice(0, start) + clean + val.slice(end);
          if (max) next = next.slice(0, max);
          phoneInput.value = next;
          const pos = Math.min(start + clean.length, next.length);
          phoneInput.setSelectionRange(pos, pos);
        });
      }

      // Validación en vivo de email (sin espacios, debe contener '@' y un punto después)
      const emailInput = document.getElementById('email');
      if (emailInput) {
        emailInput.setAttribute('inputmode','email');
        // Bloquear espacios
        emailInput.addEventListener('keydown', e => { if (e.key === ' ') e.preventDefault(); });
        emailInput.addEventListener('input', e => {
          // Quitar espacios
          if (typeof e.target.value.replaceAll === 'function') {
            e.target.value = e.target.value.replaceAll(' ', '');
          } else {
            e.target.value = e.target.value.split(' ').join('');
          }
          const val = e.target.value;
          const at  = val.indexOf('@');
          const dot = at >= 0 ? val.indexOf('.', at + 2) : -1; // punto después de al menos 1 char tras '@'
          const valid = at > 0 && dot > at + 1 && dot < val.length - 1;
          e.target.setCustomValidity(valid ? '' : 'Formato de email inválido (ej: usuario@dominio.com)');
        });
        emailInput.addEventListener('paste', () => { setTimeout(() => emailInput.dispatchEvent(new Event('input')), 0); });
      }
    })();
  </script>
</body>
</html>