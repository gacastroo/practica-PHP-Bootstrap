<?php
session_start();

// Proteger la página
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>

<h1>Panel privado</h1>

<p>
    <strong>Nombre:</strong>
    <?= htmlspecialchars($_SESSION["nombre"]) ?>
</p>

<p>
    <strong>Email:</strong>
    <?= htmlspecialchars($_SESSION["email"]) ?>
</p>

<p>
    <strong>Rol:</strong>
    <?= htmlspecialchars($_SESSION["rol"]) ?>
</p>

<a href="logout.php">Cerrar sesión</a>

</body>
</html>