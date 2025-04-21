<?php
    //Declaramos la función
    function calendarioturno(){   
?>

    <script>
    // Ejemplo simple de interactividad para mostrar mensaje en calendario
    document.getElementById('fecha-turno').addEventListener('change', function () {
        const calendario = document.getElementById('calendario-turnos');
        calendario.innerHTML = `Turnos para el ${this.value}:<br>- 10:00 - Firulais<br>- 12:30 - Luna`;
    });
    </script>
    <p></p>
<?php
    }
?>