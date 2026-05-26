<?php
session_start();

$pagina_actual = 'Noticias';

if (!isset($_SESSION['historial'])) {
    $_SESSION['historial'] = [];
}

$_SESSION['historial'][] = [
    'pagina' => $pagina_actual,
    'hora'   => date('H:i:s'),
    'url'    => basename($_SERVER['PHP_SELF'])
];

if (count($_SESSION['historial']) > 20) {
    $_SESSION['historial'] = array_slice($_SESSION['historial'], -20);
}

$ultimas = array_reverse(array_slice($_SESSION['historial'], -5));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Noticias</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<header>
    <h1>Mi Sitio Web</h1>
    <nav>
        <a href="inicio.php">Inicio</a>
        <a href="noticias.php" class="active">Noticias</a>
        <a href="contacto.php">Contacto</a>
        <a href="historial.php">Historial</a>
    </nav>
</header>

<div class="page-body">
    <main class="main-col">
        <h2>Noticias</h2>
        <p><strong>15/05/2025 — Nueva versión de PHP disponible</strong><br>
        Se ha lanzado una nueva versión de PHP con mejoras de rendimiento y nuevas funciones para el manejo de arrays y sesiones.</p>
        <hr>
        <p><strong>10/05/2025 — Taller de desarrollo web</strong><br>
        El próximo mes se celebrará un taller gratuito sobre desarrollo web con PHP y MySQL. Las plazas son limitadas.</p>
        <hr>
        <p><strong>02/05/2025 — Actualización del sitio</strong><br>
        Hemos renovado el diseño de la web y añadido nuevas secciones. Esperamos que la nueva estructura sea más cómoda para navegar.</p>
    </main>

    <aside>
        <h3>Últimas visitas</h3>
        <?php if (empty($ultimas)): ?>
            <p class="empty-msg">Aún no has visitado ninguna página en esta sesión.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($ultimas as $entrada): ?>
                    <li><?= $entrada['hora'] ?> — <?= $entrada['pagina'] ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <a href="historial.php">Ver historial completo</a>
    </aside>
</div>

<footer>Ejercicio PHP — Historial de navegación con sesión</footer>

</body>
</html>
