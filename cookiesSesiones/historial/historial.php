<?php
session_start();

$pagina_actual = 'Historial';

// Capturar si el historial estaba vacío ANTES de registrar esta visita
// (historial.php NO registra su propia visita)
$historial_previo_vacio = empty($_SESSION['historial']);

// NO se registra la visita a historial.php
if (!isset($_SESSION['historial'])) {
    $_SESSION['historial'] = [];
}

$historial = array_reverse($_SESSION['historial']);
$total     = count($historial);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial — Crónica Digital</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<header>
    <a class="logo" href="inicio.php">Crónica Digital</a>
    <nav>
        <a href="inicio.php">Inicio</a>
        <a href="noticias.php">Noticias</a>
        <a href="contacto.php">Contacto</a>
        <a href="historial.php" class="active">Historial</a>
    </nav>
</header>

<div class="hist-wrap">
    <h1>Historial de navegación</h1>
    <p class="subtitle">Registro de páginas visitadas durante esta sesión, ordenadas de más reciente a más antigua.</p>

    <?php if ($historial_previo_vacio || empty($historial)): ?>

        <p class="empty-msg">Aún no has visitado ninguna página en esta sesión.</p>

    <?php else: ?>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Página</th>
                    <th>Hora</th>
                    <th>Última visita</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historial as $i => $entrada): ?>
                    <tr>
                        <td><?= $total - $i ?></td>
                        <td><?= htmlspecialchars($entrada['pagina']) ?></td>
                        <td><?= htmlspecialchars($entrada['hora']) ?></td>
                        <td class="current-mark"><?= $i === 0 ? '✔' : '' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>

    <div class="hist-actions">
        <a class="btn btn-danger" href="limpiar.php">Borrar historial</a>
        <a class="sidebar-link" href="inicio.php">← Volver al inicio</a>
    </div>
</div>

<footer>© 2025 Crónica Digital — Todos los derechos reservados</footer>

</body>
</html>
