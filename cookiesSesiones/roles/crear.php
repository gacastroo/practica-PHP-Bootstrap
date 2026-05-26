<?php
require_once 'funciones.php';

requireRol(['admin', 'editor']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear contenido</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="pagina">

    <h1>Crear contenido</h1>

    <p>
        Solo administradores y editores pueden acceder.
    </p>

    <a href="panel.php">Volver al panel</a>

</div>

</body>
</html>