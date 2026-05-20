<?php
session_start();

// Redirigir si ya inició sesión
if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
    header("Location: dashboard.php");
    exit;
}

// Usuarios
$usuarios = [
    [
        "usuario" => "admin",
        "clave"   => "1234",
        "nombre"  => "Guillermo",
        "email"   => "g@g",
        "rol"     => "admin"
    ],
    [
        "usuario" => "juan",
        "clave"   => "abcd",
        "nombre"  => "Juan Pérez",
        "email"   => "juan@mail.com",
        "rol"     => "editor"
    ]
];

// Leer cookie
$usuario_guardado = $_COOKIE["usuario"] ?? "";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $usuario = trim($_POST["usuario"] ?? "");
    $clave   = trim($_POST["clave"] ?? "");

    if (empty($usuario) || empty($clave)) {

        $error = "Todos los campos son obligatorios.";

    } else {

        foreach ($usuarios as $u) {

            if (
                $u["usuario"] === $usuario &&
                $u["clave"] === $clave
            ) {

                $_SESSION["login"]  = true;
                $_SESSION["nombre"] = $u["nombre"];
                $_SESSION["email"]  = $u["email"];
                $_SESSION["rol"]    = $u["rol"];

                // Cookie 7 días
                setcookie(
                    "usuario",
                    $usuario,
                    time() + (7 * 24 * 60 * 60)
                );

                header("Location: dashboard.php");
                exit;
            }
        }

        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="container">

    <h1>Iniciar sesión</h1>

    <?php if ($error): ?>
        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <label for="usuario">Usuario</label>

        <input
            type="text"
            name="usuario"
            id="usuario"
            value="<?= htmlspecialchars($usuario_guardado) ?>"
        >

        <label for="clave">Contraseña</label>

        <input
            type="password"
            name="clave"
            id="clave"
        >

        <button type="submit">
            Entrar
        </button>

    </form>

</div>

</body>
</html>