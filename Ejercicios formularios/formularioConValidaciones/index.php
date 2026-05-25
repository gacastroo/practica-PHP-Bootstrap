<?php

$errores = [];

$nombre = "";
$email = "";
$edad = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitizar datos
    $nombre = htmlspecialchars(trim($_POST["nombre"] ?? ""));
    $email = htmlspecialchars(trim($_POST["email"] ?? ""));
    $edad = trim($_POST["edad"] ?? "");

    $pass = $_POST["password"] ?? "";
    $pass2 = $_POST["password2"] ?? "";

    // VALIDAR NOMBRE
    if ($nombre === "") {
        $errores["nombre"] = "El nombre es obligatorio.";
    } elseif (strlen($nombre) < 3 || strlen($nombre) > 60) {
        $errores["nombre"] = "El nombre debe tener entre 3 y 60 caracteres.";
    }

    // VALIDAR EMAIL
    if ($email === "") {
        $errores["email"] = "El email es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores["email"] = "El email no tiene formato válido.";
    }

    // VALIDAR EDAD
    if ($edad === "") {
        $errores["edad"] = "La edad es obligatoria.";
    } elseif (!is_numeric($edad)) {
        $errores["edad"] = "La edad debe ser un número.";
    } else {

        $edadInt = (int)$edad;

        if ($edadInt < 16 || $edadInt > 99) {
            $errores["edad"] = "La edad debe estar entre 16 y 99 años.";
        }
    }

    // VALIDAR CONTRASEÑA
    if ($pass === "") {
        $errores["pass"] = "La contraseña es obligatoria.";
    } elseif (strlen($pass) < 8) {
        $errores["pass"] = "La contraseña debe tener al menos 8 caracteres.";
    } elseif (!preg_match('/[0-9]/', $pass)) {
        $errores["pass"] = "La contraseña debe contener al menos un número.";
    }

    // VALIDAR REPETIR CONTRASEÑA
    if ($pass2 === "") {
        $errores["pass2"] = "Debes repetir la contraseña.";
    } elseif ($pass !== $pass2) {
        $errores["pass2"] = "Las contraseñas no coinciden.";
    }

    // SI TODO ES CORRECTO
    if (empty($errores)) {

        echo "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <title>Inscripción completada</title>
            <link rel='stylesheet' href='estilos.css'>
        </head>
        <body>

            <div class='confirmacion'>
                <h1>Inscripción completada</h1>

                <p><strong>Nombre:</strong> $nombre</p>
                <p><strong>Email:</strong> $email</p>

                <p>Tu inscripción al curso se ha realizado correctamente.</p>
            </div>

        </body>
        </html>
        ";

        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de inscripción</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <div class="contenedor">

        <h1>Formulario de inscripción</h1>

        <form method="POST" action="">

            <!-- NOMBRE -->
            <label>Nombre completo:</label>

            <input
                type="text"
                name="nombre"
                value="<?= htmlspecialchars($nombre) ?>"
            >

            <?php if (isset($errores["nombre"])): ?>
                <span class="error">
                    <?= $errores["nombre"] ?>
                </span>
            <?php endif; ?>


            <!-- EMAIL -->
            <label>Email:</label>

            <input
                type="text"
                name="email"
                value="<?= htmlspecialchars($email) ?>"
            >

            <?php if (isset($errores["email"])): ?>
                <span class="error">
                    <?= $errores["email"] ?>
                </span>
            <?php endif; ?>


            <!-- EDAD -->
            <label>Edad:</label>

            <input
                type="text"
                name="edad"
                value="<?= htmlspecialchars($edad) ?>"
            >

            <?php if (isset($errores["edad"])): ?>
                <span class="error">
                    <?= $errores["edad"] ?>
                </span>
            <?php endif; ?>


            <!-- PASSWORD -->
            <label>Contraseña:</label>

            <input
                type="password"
                name="password"
            >

            <?php if (isset($errores["pass"])): ?>
                <span class="error">
                    <?= $errores["pass"] ?>
                </span>
            <?php endif; ?>


            <!-- PASSWORD 2 -->
            <label>Repetir contraseña:</label>

            <input
                type="password"
                name="password2"
            >

            <?php if (isset($errores["pass2"])): ?>
                <span class="error">
                    <?= $errores["pass2"] ?>
                </span>
            <?php endif; ?>


            <button type="submit">
                Inscribirse
            </button>

        </form>

    </div>

</body>
</html>