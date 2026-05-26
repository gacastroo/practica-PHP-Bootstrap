<?php
require_once 'funciones.php';

requireRol(['admin', 'editor', 'lector']);

$rol = $_SESSION['rol'];
$nombre = $_SESSION['nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="layout">

    <aside class="sidebar">

        <h2>Panel CMS</h2>

        <p>
            <strong><?= $nombre; ?></strong>
        </p>

        <p>
            Rol: <strong><?= ucfirst($rol); ?></strong>
        </p>

        <hr>

        <ul>

            <li>
                <a href="panel.php">Ver contenidos</a>
            </li>

            <?php if ($rol === 'admin' || $rol === 'editor'): ?>

                <li>
                    <a href="crear.php">Crear contenido</a>
                </li>

                <li>
                    <a href="editar.php">Editar contenido</a>
                </li>

            <?php endif; ?>

            <?php if ($rol === 'admin'): ?>

                <li>
                    <a href="eliminar.php">Eliminar contenido</a>
                </li>

                <li>
                    <a href="usuarios.php">Gestionar usuarios</a>
                </li>

            <?php endif; ?>

            <li>
                <a href="logout.php">Cerrar sesión</a>
            </li>

        </ul>

    </aside>

    <main class="contenido">

        <h1>Bienvenido al panel</h1>

        <?php if (isset($_SESSION['error_acceso'])): ?>

            <div class="error">
                <?= $_SESSION['error_acceso']; ?>
            </div>

            <?php unset($_SESSION['error_acceso']); ?>

        <?php endif; ?>

        <?php if ($rol === 'admin'): ?>

            <div class="mensaje admin">
                Tienes acceso completo al sistema.
            </div>

        <?php elseif ($rol === 'editor'): ?>

            <div class="mensaje editor">
                Puedes crear y editar contenidos.
            </div>

        <?php else: ?>

            <div class="mensaje lector">
                Solo puedes visualizar contenidos.
            </div>

        <?php endif; ?>

    </main>

</div>

</body>
</html>