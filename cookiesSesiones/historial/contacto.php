<?php
session_start();

$pagina_actual = 'Contacto';

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
    <title>Contacto</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<header>
    <h1>Mi Sitio Web</h1>
    <nav>
        <a href="inicio.php">Inicio</a>
        <a href="noticias.php">Noticias</a>
        <a href="contacto.php" class="active">Contacto</a>
        <a href="historial.php">Historial</a>
    </nav>
</header>

<div class="page-body">
    <main class="main-col">
        <h2>Contacto</h2>
        <p>Puedes escribirnos usando el formulario de abajo. Te responderemos lo antes posible.</p>

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" placeholder="Tu nombre">
        </div>
        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" placeholder="tu@correo.com">
        </div>
        <div class="form-group">
            <label for="mensaje">Mensaje</label>
            <textarea id="mensaje" name="mensaje" placeholder="Escribe tu mensaje aquí..."></textarea>
        </div>
        <button class="btn btn-primary">Enviar</button>
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
