<?php
session_start();

$pagina_actual = 'Inicio';

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
    <title>Inicio</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<header>
    <h1>Mi Sitio Web</h1>
    <nav>
        <a href="inicio.php" class="active">Inicio</a>
        <a href="noticias.php">Noticias</a>
        <a href="contacto.php">Contacto</a>
        <a href="historial.php">Historial</a>
    </nav>
</header>

<div class="page-body">
    <main class="main-col">
        <h2>Bienvenido</h2>
        <p>Esta es la página de inicio del sitio. Aquí encontrarás información general sobre nosotros y los contenidos que ofrecemos.</p>
        <p>Usa el menú de navegación para visitar las distintas secciones. En la barra lateral puedes ver las últimas páginas que has visitado en esta sesión.</p>
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
