<?php
// ── Leer y sanear ────────────────────────────────────────────
$nombre   = htmlspecialchars(trim($_POST['nombre']   ?? ''));
$cargo    = htmlspecialchars(trim($_POST['cargo']    ?? ''));
$empresa  = htmlspecialchars(trim($_POST['empresa']  ?? ''));
$email    = htmlspecialchars(trim($_POST['email']    ?? ''));
$telefono = htmlspecialchars(trim($_POST['telefono'] ?? ''));
$web      = htmlspecialchars(trim($_POST['web']      ?? ''));

// ── Validar obligatorios ─────────────────────────────────────
$errores = [];

if (empty($nombre)) {
    $errores[] = 'El nombre completo es obligatorio.';
}
if (empty($cargo)) {
    $errores[] = 'El cargo / puesto es obligatorio.';
}
if (empty($_POST['email'])) {
    $errores[] = 'El email es obligatorio.';
} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errores[] = 'El email no tiene un formato válido.';
}

// ── Validar color hexadecimal ────────────────────────────────
$color = $_POST['color'] ?? '#2E75B6';
if (!preg_match('/^#[0-9A-Fa-f]{6}$/', $color)) {
    $color = '#2E75B6';
}

// ── Estilo → variables CSS ───────────────────────────────────
$estilo = $_POST['estilo'] ?? 'minimalista';

switch ($estilo) {
    case 'moderno':
        $fuente         = "'Segoe UI', sans-serif";
        $bg_tarjeta     = $color;
        $color_texto    = '#ffffff';
        $borde_tarjeta  = 'none';
        $nombre_weight  = 'bold';
        $linea_display  = 'none';
        break;
    case 'clasico':
        $fuente         = 'Georgia, serif';
        $bg_tarjeta     = '#FFF9F0';
        $color_texto    = '#1A1A1A';
        $borde_tarjeta  = '1px solid #ccc';
        $nombre_weight  = 'normal';
        $linea_display  = 'block';
        break;
    default: // minimalista
        $fuente         = 'Arial, sans-serif';
        $bg_tarjeta     = '#ffffff';
        $color_texto    = '#1A1A1A';
        $borde_tarjeta  = '2px solid ' . $color;
        $nombre_weight  = 'normal';
        $linea_display  = 'none';
}

// ── Mostrar campos opcionales ────────────────────────────────
$mostrar_empresa  = !empty($empresa);
$mostrar_telefono = !empty($telefono);
$mostrar_web      = !empty($web);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tarjeta de visita</title>
  <style>
    body {
      font-family: <?= $fuente ?>;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      margin: 0;
      background: #f5f5f5;
    }

    .tarjeta {
      background: <?= $bg_tarjeta ?>;
      color: <?= $color_texto ?>;
      border: <?= $borde_tarjeta ?>;
      border-radius: 8px;
      padding: 2rem 2.5rem;
      width: 380px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }

    .nombre {
      font-size: 2rem;
      font-weight: <?= $nombre_weight ?>;
      margin: 0 0 0.3rem;
    }

    .linea {
      display: <?= $linea_display ?>;
      border: none;
      border-top: 3px solid <?= $color ?>;
      width: 60px;
      margin: 0.5rem 0 0.8rem;
    }

    .cargo {
      font-size: 0.95rem;
      margin: 0 0 0.2rem;
    }

    .empresa {
      font-size: 0.9rem;
      margin: 0 0 1rem;
    }

    .contacto p {
      font-size: 0.88rem;
      margin: 0.3rem 0;
    }

    .contacto a {
      color: <?= $color_texto ?>;
    }

    .acciones {
      margin-top: 2rem;
      display: flex;
      gap: 1rem;
    }

    .acciones button,
    .acciones a {
      padding: 0.5rem 1.2rem;
      font-size: 0.9rem;
      cursor: pointer;
      text-decoration: none;
    }

    @media print {
      .acciones { display: none; }
    }
  </style>
</head>
<body>

<?php if (!empty($errores)): ?>

  <h2>Errores en el formulario:</h2>
  <ul>
    <?php foreach ($errores as $err): ?>
      <li><?= $err ?></li>
    <?php endforeach; ?>
  </ul>
  <a href="formulario.html">← Volver al formulario</a>

<?php else: ?>

  <div class="tarjeta">

    <p class="nombre"><?= $nombre ?></p>
    <hr class="linea">
    <p class="cargo"><?= $cargo ?></p>

    <?php if ($mostrar_empresa): ?>
      <p class="empresa"><?= $empresa ?></p>
    <?php endif; ?>

    <div class="contacto">
      <p><?= $email ?></p>

      <?php if ($mostrar_telefono): ?>
        <p><?= $telefono ?></p>
      <?php endif; ?>

      <?php if ($mostrar_web): ?>
        <p><a href="<?= $web ?>"><?= $web ?></a></p>
      <?php endif; ?>
    </div>

  </div>

  <div class="acciones">
    <button onclick="window.print()">Imprimir tarjeta</button>
    <a href="formulario.html">← Generar otra tarjeta</a>
  </div>

<?php endif; ?>

</body>
</html>