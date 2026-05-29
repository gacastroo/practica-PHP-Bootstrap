// ─────────────────────────────────────────────────────
// BLOQUE 1: Referencias a los elementos del DOM
// ─────────────────────────────────────────────────────

const form = document.getElementById('form-calcu');
const boton = document.getElementById('boton-calcu');

const zonaResult = document.getElementById('zona-resultado');
const zonaError = document.getElementById('zona-error');

const elOperacion = document.getElementById('operacion');
const elResultado = document.getElementById('resultado');
const elError = document.getElementById('mensaje-error');


// ─────────────────────────────────────────────────────
// BLOQUE 2: Funciones auxiliares
// ─────────────────────────────────────────────────────

function mostrarResultado(operacion, resultado) {

  zonaError.classList.add('oculto');

  elOperacion.textContent = operacion;
  elResultado.textContent = '= ' + resultado;

  zonaResult.classList.remove('oculto');
  zonaResult.classList.remove('error');
  zonaResult.classList.add('ok');
}

function mostrarError(mensaje) {

  zonaResult.classList.add('oculto');

  elError.textContent = mensaje;

  zonaError.classList.remove('oculto');
}


// ─────────────────────────────────────────────────────
// BLOQUE 3: Función principal
// ─────────────────────────────────────────────────────

async function calcular(evento) {

  // Evitar recarga del formulario
  evento.preventDefault();

  // Leer datos
  const num1 = document.getElementById('num1').value;
  const num2 = document.getElementById('num2').value;
  const op = document.getElementById('op').value;

  // Validación simple
  if (num1 === '' || num2 === '') {

    mostrarError('Debes introducir los dos números.');
    return;
  }

  // Estado de carga
  boton.disabled = true;
  boton.textContent = 'Calculando...';

  try {

    // Preparar datos POST
    const datos = new FormData();

    datos.append('num1', num1);
    datos.append('num2', num2);
    datos.append('op', op);

    // Enviar petición
    const respuesta = await fetch('calcular.php', {
      method: 'POST',
      body: datos
    });

    // Convertir respuesta a JSON
    const json = await respuesta.json();

    // Gestionar respuesta
    if (json.ok) {

      mostrarResultado(json.operacion, json.resultado);

    } else {

      mostrarError(json.mensaje);
    }

  } catch (error) {

    mostrarError('Error de conexión. Comprueba que XAMPP está activo.');

    console.error(error);

  } finally {

    // Restaurar botón
    boton.disabled = false;
    boton.textContent = 'Calcular';
  }
}


// ─────────────────────────────────────────────────────
// BLOQUE 4: Evento submit
// ─────────────────────────────────────────────────────

form.addEventListener('submit', calcular);