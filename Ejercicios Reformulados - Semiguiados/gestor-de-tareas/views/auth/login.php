<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Gestor de tareas</title>
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body>

<div class="container">

    <h1>Iniciar sesión</h1>

    <?php if (!empty($error)): ?>
        <div class="error">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?pagina=auth&action=login">

        <label for="usuario">Usuario</label>
        <input
            type="text"
            name="usuario"
            id="usuario"
            value="<?= $usuarioPrevio ?>"
            autocomplete="username"
        >

        <label for="clave">Contraseña</label>
        <input
            type="password"
            name="clave"
            id="clave"
            autocomplete="current-password"
        >

        <button type="submit">Entrar</button>

    </form>

</div>

</body>
</html>
