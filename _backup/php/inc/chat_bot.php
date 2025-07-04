<?php
function chatbot() {
?>
  <style>
    /* Estilos del chat */
    #chatbox {
      position: fixed;
      bottom: 70px;
      right: 20px;
      width: 320px;
      max-height: 500px;
      background: white;
      border: 1px solid #ccc;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
      overflow: hidden;
      z-index: 1000;
      font-size: 14px;
      display: none;
      flex-direction: column;
    }
    #chat-header {
      background: rgb(10, 10, 10);
      color: white;
      padding: 10px;
      text-align: center;
      font-weight: bold;
      cursor: move;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    #chat-body {
      padding: 10px;
      flex: 1;
      overflow-y: auto;
    }
    .chat-button {
      display: block;
      margin: 5px 0;
      padding: 8px;
      background: #f0f0f0;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      text-align: left;
    }
    #chat-footer {
      padding: 10px;
      border-top: 1px solid #ccc;
      display: flex;
      gap: 8px;
      align-items: center;
    }
    #numero-input {
      flex: 1;
      padding: 6px 8px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    #enviar-btn {
      padding: 6px 12px;
      background: rgb(241, 140, 6);
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
    }
    #chat-toggle-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: rgb(135, 65, 25);
      color: white;
      border: none;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      cursor: pointer;
      box-shadow: 0 4px 8px rgba(0,0,0,0.3);
      z-index: 1100;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 24px;
    }
    /* Estilos formulario "Olvidé contraseña" */
    #forgot-password-form {
      margin-top: 10px;
      display: none;
      flex-direction: column;
      gap: 6px;
    }
    #forgot-password-form input[type="email"] {
      padding: 6px 8px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    #forgot-password-form button {
      padding: 6px 12px;
      background: rgb(212, 209, 17);
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
    }
    #forgot-message {
      margin-top: 8px;
      color: green;
      font-weight: bold;
    }
    #forgot-password-link {
      display: inline-block;
      margin-top: 10px;
      color: rgb(6, 49, 240);
      cursor: pointer;
      text-decoration: underline;
      font-size: 13px;
    }
  </style>

  <!-- Botón flotante con ícono de Bootstrap Icons -->
  <button id="chat-toggle-btn" aria-label="Abrir chat">
    <i class="bi bi-chat-dots-fill"></i>
  </button>

  <div id="chatbox" role="region" aria-live="polite" aria-label="Asistente veterinaria">
    <div id="chat-header">
      <!-- Ícono de asistente con Font Awesome -->
      <i class="fa fa-heartbeat"></i>
      <span>Asistente Veterinaria</span>
    </div>
    <div id="chat-body">
      <p>Hola 👋 ¿En qué podemos ayudarte?</p>
      <p>Elegí una opción:</p>
      <button class="chat-button" onclick="responder('1')">
        <i class="bi bi-clock me-2"></i>1. ¿Cuáles son los horarios de atención?
      </button>
      <button class="chat-button" onclick="responder('2')">
        <i class="fa fa-syringe me-2"></i>2. ¿Qué vacunas debo dar a mi mascota?
      </button>
      <button class="chat-button" onclick="responder('3')">
        <i class="bi bi-geo-alt-fill me-2"></i>3. ¿Dónde están ubicados?
      </button>
      <button class="chat-button" onclick="responder('4')">
        <i class="fa fa-phone me-2"></i>4. ¿Cuál es el número de contacto?
      </button>
      <button class="chat-button" onclick="responder('5')">
        <i class="bi bi-emoji-sunglasses me-2"></i>5. ¿Atienden urgencias?
      </button>

      <span id="forgot-password-link" onclick="mostrarFormulario()">
        <i class="bi bi-key me-1"></i>Olvidé mi contraseña?
      </span>

      <form id="forgot-password-form" onsubmit="enviarOlvideContrasena(event)">
        <input type="email" id="email-forgot" placeholder="Ingresá tu email" required />
        <button type="submit">Enviar</button>
        <div id="forgot-message"></div>
      </form>
    </div>
    <div id="chat-footer">
      <input type="text" id="numero-input" placeholder="Escribí el número aquí..." maxlength="1" />
      <button id="enviar-btn" onclick="enviarNumero()">
        <i class="bi bi-send-fill"></i>
      </button>
    </div>
  </div>

  <script>
    
    const chatbox = document.getElementById('chatbox');
    const toggleBtn = document.getElementById('chat-toggle-btn');
    const forgotLink = document.getElementById('forgot-password-link');
    const forgotForm = document.getElementById('forgot-password-form');
    const forgotMessage = document.getElementById('forgot-message');

    toggleBtn.addEventListener('click', () => {
      if (chatbox.style.display === 'none' || chatbox.style.display === '') {
        chatbox.style.display = 'flex';
        toggleBtn.querySelector('i').className = 'bi bi-x-lg';
      } else {
        chatbox.style.display = 'none';
        toggleBtn.querySelector('i').className = 'bi bi-chat-dots-fill';
        ocultarFormulario();
      }
    });

    function responder(tipo) {
      const chat = document.getElementById('chat-body');
      let respuesta = '';
      switch(tipo) {
        case '1': respuesta = '⏰ Atendemos de lunes a viernes de 9 a 18 hs y sábados de 9 a 13 hs.'; break;
        case '2': respuesta = '💉 Las vacunas esenciales incluyen antirrábica, séxtuple y triple felina.'; break;
        case '3': respuesta = '📍 Estamos en Av. Boedo 1870, CABA.'; break;
        case '4': respuesta = '☎️ Nuestro número es (011) 1234-5678.'; break;
        case '5': respuesta = '🚨 Sí, atendemos urgencias. Llamanos al (011) 1234-5678.'; break;
        default: respuesta = '❓ Por favor ingresa un número del 1 al 5.';
      }
      chat.innerHTML += `<div class='mt-2'><strong>🤖:</strong> ${respuesta}</div>`;
      chat.scrollTop = chat.scrollHeight;
    }

    function enviarNumero() {
      const input = document.getElementById('numero-input');
      const valor = input.value.trim();
      if (valor) { responder(valor); input.value = ''; input.focus(); }
    }

    document.getElementById('numero-input').addEventListener('keypress', function(e) {
      if(e.key === 'Enter') enviarNumero();
    });

    function mostrarFormulario() {
      forgotForm.style.display = 'flex';
      forgotMessage.textContent = '';
      forgotLink.style.display = 'none';
    }

    function ocultarFormulario() {
      forgotForm.style.display = 'none';
      forgotMessage.textContent = '';
      forgotLink.style.display = 'inline-block';
    }

    function enviarOlvideContrasena(event) {
      event.preventDefault();
      const emailInput = document.getElementById('email-forgot');
      const email = emailInput.value.trim();
      if(email) { forgotMessage.textContent = '✔️ Email enviado a ' + email; emailInput.value = ''; }
    }
  </script>
<?php
}
?>
