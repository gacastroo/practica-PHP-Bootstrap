<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de tareas</title>
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body>

<header>
    <h1>Gestor de Tareas</h1>

    <?php if ($sesionActiva): ?>
        <p>Usuario: <?= $nombreUsuario ?></p>

        <nav>
            <a href="index.php?pagina=tareas&action=listar">Tareas</a>
            <a href="index.php?pagina=tareas&action=crear">Crear Tarea</a>
            <a href="index.php?pagina=auth&action=logout">Cerrar sesión</a>
        </nav>
    <?php endif; ?>
</header>

<hr>
