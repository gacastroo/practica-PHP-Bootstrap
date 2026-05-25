<?php

$nombre = "";
$valoracion = "";
$aspectos = [];
$dificil = "";
$sugerencias = "";
$errores = [];

// Opciones válidas
$valoraciones_validas = ["Excelente", "Buena", "Regular", "Mala"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Leer y sanear datos
    $nombre = htmlspecialchars(trim($_POST["nombre"] ?? ""));
    $valoracion = $_POST["valoracion"] ?? "";
    $aspectos = $_POST["aspectos"] ?? [];
    $dificil = htmlspecialchars(trim($_POST["dificil"] ?? ""));
    $sugerencias = htmlspecialchars(trim($_POST["sugerencias"] ?? ""));

    // VALIDAR NOMBRE
    if ($nombre === "") {
        $errores["nombre"] = "El nombre es obligatorio.";
    }

    // VALIDAR VALORACION
    if (!in_array($valoracion, $valoraciones_validas)) {
        $errores["valoracion"] = "Debes seleccionar una valoración.";
    }

    // VALIDAR SUGERENCIAS
    if (strlen($sugerencias) > 300) {
        $errores["sugerencias"] = "Las sugerencias no pueden superar 300 caracteres.";
    }

    // SI TODO ES CORRECTO
    if (empty($errores)) {

        ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Encuesta enviada</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
</head>
<body>

<div class="confirmacion-container">

    <h1>
        Gracias por tu opinión,
        <span><?= $nombre ?></span>
    </h1>

    <div class="tarjeta">
        <h2>Valoración general</h2>
        <p><?= $valoracion ?></p>
    </div>

    <div class="tarjeta">
        <h2>Aspectos positivos</h2>

        <?php if (!empty($aspectos)): ?>

            <ul>
                <?php foreach ($aspectos as $aspecto): ?>
                    <li><?= htmlspecialchars($aspecto) ?></li>
                <?php endforeach; ?>
            </ul>

        <?php else: ?>

            <p>No se seleccionó ningún aspecto.</p>

        <?php endif; ?>
    </div>

    <div class="tarjeta">
        <h2>Lo más difícil hasta ahora</h2>
        <p><?= $dificil ?></p>
    </div>

    <div class="tarjeta">
        <h2>Sugerencias</h2>

        <?php if ($sugerencias !== ""): ?>
            <p><?= nl2br($sugerencias) ?></p>
        <?php else: ?>
            <p>No se escribieron sugerencias.</p>
        <?php endif; ?>
    </div>

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
    <title>Encuesta de satisfacción</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="contenedor">

    <h1><strong>Encuesta de satisfacción</strong></h1>

    <form method="POST" action="">

        <!-- NOMBRE -->
        <label>Nombre:</label>

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


        <!-- VALORACION -->
        <label>Valoración general del curso:</label>

        <div class="grupo-radio">

            <label>
                <input
                    type="radio"
                    name="valoracion"
                    value="Excelente"
                    <?= $valoracion === "Excelente" ? "checked" : "" ?>
                >
                Excelente
            </label>

            <label>
                <input
                    type="radio"
                    name="valoracion"
                    value="Buena"
                    <?= $valoracion === "Buena" ? "checked" : "" ?>
                >
                Buena
            </label>

            <label>
                <input
                    type="radio"
                    name="valoracion"
                    value="Regular"
                    <?= $valoracion === "Regular" ? "checked" : "" ?>
                >
                Regular
            </label>

            <label>
                <input
                    type="radio"
                    name="valoracion"
                    value="Mala"
                    <?= $valoracion === "Mala" ? "checked" : "" ?>
                >
                Mala
            </label>

        </div>

        <?php if (isset($errores["valoracion"])): ?>
            <span class="error">
                <?= $errores["valoracion"] ?>
            </span>
        <?php endif; ?>


        <!-- CHECKBOXES -->
        <label>Aspectos positivos:</label>

        <div class="grupo-checkbox">

            <label>
                <input
                    type="checkbox"
                    name="aspectos[]"
                    value="Contenido claro"
                    <?= in_array("Contenido claro", $aspectos) ? "checked" : "" ?>
                >
                Contenido claro
            </label>

            <label>
                <input
                    type="checkbox"
                    name="aspectos[]"
                    value="Buena metodología"
                    <?= in_array("Buena metodología", $aspectos) ? "checked" : "" ?>
                >
                Buena metodología
            </label>

            <label>
                <input
                    type="checkbox"
                    name="aspectos[]"
                    value="Ejemplos útiles"
                    <?= in_array("Ejemplos útiles", $aspectos) ? "checked" : "" ?>
                >
                Ejemplos útiles
            </label>

            <label>
                <input
                    type="checkbox"
                    name="aspectos[]"
                    value="Buen ritmo"
                    <?= in_array("Buen ritmo", $aspectos) ? "checked" : "" ?>
                >
                Buen ritmo
            </label>

            <label>
                <input
                    type="checkbox"
                    name="aspectos[]"
                    value="Material de apoyo"
                    <?= in_array("Material de apoyo", $aspectos) ? "checked" : "" ?>
                >
                Material de apoyo
            </label>

        </div>


        <!-- SELECT -->
        <label>Lo más difícil hasta ahora:</label>

        <select name="dificil">

            <option value="">-- Selecciona una opción --</option>

            <option
                value="Variables y tipos"
                <?= $dificil === "Variables y tipos" ? "selected" : "" ?>
            >
                Variables y tipos
            </option>

            <option
                value="Control de flujo"
                <?= $dificil === "Control de flujo" ? "selected" : "" ?>
            >
                Control de flujo
            </option>

            <option
                value="Funciones"
                <?= $dificil === "Funciones" ? "selected" : "" ?>
            >
                Funciones
            </option>

            <option
                value="Arrays"
                <?= $dificil === "Arrays" ? "selected" : "" ?>
            >
                Arrays
            </option>

            <option
                value="Formularios PHP"
                <?= $dificil === "Formularios PHP" ? "selected" : "" ?>
            >
                Formularios PHP
            </option>

        </select>


        <!-- TEXTAREA -->
        <label>Sugerencias:</label>

        <textarea
            name="sugerencias"
            maxlength="300"
        ><?= htmlspecialchars($sugerencias) ?></textarea>

        <?php if (isset($errores["sugerencias"])): ?>
            <span class="error">
                <?= $errores["sugerencias"] ?>
            </span>
        <?php endif; ?>


        <button type="submit">
            Enviar encuesta
        </button>

    </form>

</div>

</body>
</html>