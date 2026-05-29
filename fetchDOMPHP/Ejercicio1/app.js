// ─────────────────────────────────────────────────────
// BLOQUE 1: Seleccionar los elementos del DOM
// Guardamos referencias a los elementos que vamos a usar.
// Si los seleccionamos aquí, no necesitamos buscarlos
// cada vez que el usuario pulsa el botón.
// ─────────────────────────────────────────────────────

const boton = document.getElementById('botonFrase');
const caja = document.getElementById('cajaFrase');

// ─────────────────────────────────────────────────────
// BLOQUE 2: La función que hace la petición
// async: necesario para poder usar await dentro.
// ─────────────────────────────────────────────────────

async function pedirFrase() {

  // ESTADO DE CARGA: el usuario espera
  boton.disabled = true;              // No puede pulsar dos veces
  boton.textContent = 'Cargando...';  // Feedback visual
  caja.textContent = '';              // Limpiar la caja anterior

  try {

    // PETICIÓN: fetch llama a frase.php
    // await pausa la función hasta tener respuesta
    // No se recarga la página. Todo ocurre en segundo plano.
    const respuesta = await fetch('frase.php');

    // LECTURA: convertir la respuesta a texto
    // .text() también es una promesa, necesita await
    const texto = await respuesta.text();

    // ACTUALIZAR EL DOM: mostrar la frase
    // textContent es seguro: no interpreta HTML
    caja.textContent = texto;

  } catch (error) {

    // Si la petición falla (sin red, PHP con error...)
    caja.textContent =
      'No se pudo cargar la frase. Inténtalo de nuevo.';

    console.error('Error de fetch:', error);

  } finally {

    // Este bloque se ejecuta siempre:
    // haya éxito o error.
    boton.disabled = false;
    boton.textContent = 'Nueva frase';

  }
}

// ─────────────────────────────────────────────────────
// BLOQUE 3: Escuchar el clic del botón
// Cuando el usuario haga clic,
// ejecutar pedirFrase()
// ─────────────────────────────────────────────────────

boton.addEventListener('click', pedirFrase);