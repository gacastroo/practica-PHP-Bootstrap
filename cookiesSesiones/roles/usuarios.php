<?php
require_once 'funciones.php';

requireRol(['admin']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de usuarios</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="pagina">

    <h1>Gestión de usuarios</h1>

    <p>
        Solo el administrador puede gestionar usuarios.
    </p>

    <ul>
        <li>Ana García — Administrador</li>
        <li>Pedro López — Editor</li>
        <li>María Ruiz — Lector</li>
    </ul>

    <a href="panel.php">Volver al panel</a>

</div>

</body>
</html>