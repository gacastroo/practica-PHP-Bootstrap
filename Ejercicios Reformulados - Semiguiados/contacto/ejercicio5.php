<?php
$errores = [];

$nombre = "";
$email = "";
$telefono = "";
$asunto = "";
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recoger y sanear datos
    $nombre = htmlspecialchars(trim($_POST["nombre"] ?? ""));
    
    $email = filter_var(
        trim($_POST["email"] ?? ""),
        FILTER_SANITIZE_EMAIL
    );

    $telefono = trim($_POST["telefono"] ?? "");

    $asunto = htmlspecialchars(trim($_POST["asunto"] ?? ""));

    $mensaje = htmlspecialchars(trim($_POST["mensaje"] ?? ""));

    // Validación nombre
    if (empty($nombre) || strlen($nombre) < 3) {
        $errores["nombre"] = "El nombre debe tener al menos 3 caracteres.";
    }

    // Validación email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores["email"] = "El email no tiene un formato válido.";
    }

    // Validación teléfono (opcional)
    if (!empty($telefono) && !preg_match('/^[0-9]{9}$/', $telefono)) {
        $errores["telefono"] = "El teléfono debe tener exactamente 9 dígitos.";
    }

    // Validación asunto
    $asuntosValidos = ["Consulta", "Presupuesto", "Soporte", "Otro"];

    if (!in_array($asunto, $asuntosValidos)) {
        $errores["asunto"] = "Selecciona un asunto válido.";
    }

    // Validación mensaje
    if (empty($mensaje) || strlen($mensaje) < 20) {
        $errores["mensaje"] = "El mensaje debe tener al menos 20 caracteres.";
    }

    // Si no hay errores → mostrar confirmación
    if (empty($errores)) {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Confirmación</title>
            <link rel="stylesheet" href="estilos.css">
        </head>
        <body>

        <div class="contenedor">
            <div class="ok">
                <h2>Mensaje enviado correctamente</h2>

                <p><strong>Nombre:</strong> <?= $nombre ?></p>
                <p><strong>Email:</strong> <?= $email ?></p>

                <?php if (!empty($telefono)): ?>
                    <p><strong>Teléfono:</strong> <?= $telefono ?></p>
                <?php endif; ?>

                <p><strong>Asunto:</strong> <?= $asunto ?></p>
                <p><strong>Mensaje:</strong></p>
                <p><?= nl2br($mensaje) ?></p>
            </div>
            <a href="ejercicio5.php">
                <button>Volver</button>
            </a>        
        </div>

        </body>
        </html>
        <?php
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de contacto</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="contenedor">

    <h1>Formulario de Contacto</h1>

    <form action="" method="POST">

        <!-- Nombre -->
        <label for="nombre">Nombre completo</label>
        <input 
            type="text" 
            id="nombre" 
            name="nombre"
            value="<?= htmlspecialchars($nombre) ?>"
        >

        <?php if (isset($errores["nombre"])): ?>
            <span class="error"><?= $errores["nombre"] ?></span>
        <?php endif; ?>


        <!-- Email -->
        <label for="email">Email</label>
        <input 
            type="email" 
            id="email" 
            name="email"
            value="<?= htmlspecialchars($email) ?>"
        >

        <?php if (isset($errores["email"])): ?>
            <span class="error"><?= $errores["email"] ?></span>
        <?php endif; ?>


        <!-- Teléfono -->
        <label for="telefono">Teléfono</label>
        <input 
            type="tel" 
            id="telefono" 
            name="telefono"
            value="<?= htmlspecialchars($telefono) ?>"
        >

        <?php if (isset($errores["telefono"])): ?>
            <span class="error"><?= $errores["telefono"] ?></span>
        <?php endif; ?>


        <!-- Asunto -->
        <label for="asunto">Asunto</label>
        <select id="asunto" name="asunto">

            <option value="">-- Selecciona --</option>

            <option value="Consulta" <?= ($asunto === "Consulta") ? "selected" : "" ?>>
                Consulta
            </option>

            <option value="Presupuesto" <?= ($asunto === "Presupuesto") ? "selected" : "" ?>>
                Presupuesto
            </option>

            <option value="Soporte" <?= ($asunto === "Soporte") ? "selected" : "" ?>>
                Soporte
            </option>

            <option value="Otro" <?= ($asunto === "Otro") ? "selected" : "" ?>>
                Otro
            </option>

        </select>

        <?php if (isset($errores["asunto"])): ?>
            <span class="error"><?= $errores["asunto"] ?></span>
        <?php endif; ?>


        <!-- Mensaje -->
        <label for="mensaje">Mensaje</label>

        <textarea 
            id="mensaje" 
            name="mensaje" 
            rows="6"
        ><?= htmlspecialchars($mensaje) ?></textarea>

        <?php if (isset($errores["mensaje"])): ?>
            <span class="error"><?= $errores["mensaje"] ?></span>
        <?php endif; ?>


        <button type="submit">Enviar</button>

    </form>

</div>

</body>
</html>