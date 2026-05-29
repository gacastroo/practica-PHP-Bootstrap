<?php
session_start();

$usuarios = [
    [
        'usuario' => 'admin',
        'clave' => 'admin123',
        'nombre' => 'Ana García',
        'rol' => 'admin'
    ],
    [
        'usuario' => 'editor',
        'clave' => 'editor123',
        'nombre' => 'Pedro López',
        'rol' => 'editor'
    ],
    [
        'usuario' => 'lector',
        'clave' => 'lector123',
        'nombre' => 'María Ruiz',
        'rol' => 'lector'
    ],
];

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario = $_POST['usuario'] ?? '';
    $clave = $_POST['clave'] ?? '';

    foreach ($usuarios as $u) {

        if (
            $usuario === $u['usuario'] &&
            $clave === $u['clave']
        ) {

            $_SESSION['login'] = true;
            $_SESSION['usuario'] = $u['usuario'];
            $_SESSION['nombre'] = $u['nombre'];
            $_SESSION['rol'] = $u['rol'];

            header('Location: panel.php');
            exit;
        }
    }

    $error = 'Usuario o contraseña incorrectos.';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="login-box">

    <h1>Acceso al Panel</h1>

    <?php if ($error): ?>
        <div class="error">
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <label>Usuario</label>
        <input type="text" name="usuario" required>

        <label>Contraseña</label>
        <input type="password" name="clave" required>

        <button type="submit">Entrar</button>

    </form>

    <div class="usuarios-demo">
        <h3>Usuarios de prueba</h3>

        <p>admin / admin123</p>
        <p>editor / editor123</p>
        <p>lector / lector123</p>
    </div>

</div>

</body>
</html>