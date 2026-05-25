<?php

$correctas = [
    "p1" => "b",
    "p2" => "c",
    "p3" => "b",
    "p4" => "c",
    "p5" => "d",
    "p6" => "c"
];

$preguntas = [
    "p1" => "¿Qué símbolo se usa para declarar variables en PHP?",
    "p2" => "¿Qué operador se usa para concatenar strings en PHP?",
    "p3" => "¿Cuál es la diferencia entre == y ===?",
    "p4" => "¿Qué función cuenta los elementos de un array?",
    "p5" => "¿Qué superglobal recibe los datos de un formulario POST?",
    "p6" => "¿Qué hace htmlspecialchars()?"
];

$opciones = [
    "p1" => ["a"=>"#", "b"=>"$", "c"=>"@", "d"=>"&"],
    "p2" => ["a"=>"+", "b"=>"&", "c"=>".", "d"=>","],
    "p3" => [
        "a"=>"No hay diferencia",
        "b"=>"=== compara valor y tipo",
        "c"=>"== es más rápido",
        "d"=>"=== solo funciona con números"
    ],
    "p4" => ["a"=>"length()", "b"=>"size()", "c"=>"count()", "d"=>"total()"],
    "p5" => ["a"=>"\$_GET", "b"=>"\$_REQUEST", "c"=>"\$_FORM", "d"=>"\$_POST"],
    "p6" => [
        "a"=>"Convierte HTML a texto",
        "b"=>"Elimina el HTML",
        "c"=>"Convierte caracteres especiales a entidades HTML",
        "d"=>"Valida el HTML"
    ]
];

/* =========================
   RECOGER RESPUESTAS
========================= */

$respuestas = [];
$errores = [];

foreach ($correctas as $p => $_) {
    $respuestas[$p] = $_POST[$p] ?? "";

    if ($respuestas[$p] === "") {
        $errores[] = $p;
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Corrección del test</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="contenedor">

<?php if (!empty($errores)): ?>

    <div class="error">
        <h2>Error</h2>
        <p>Debes responder todas las preguntas antes de corregir el test.</p>
        <a href="test.html">Volver al test</a>
    </div>

<?php else: ?>

    <?php
    $aciertos = 0;
    $total = count($correctas);

    foreach ($correctas as $preg => $correcta):

        $usuario = $respuestas[$preg];

        $es_correcta = ($usuario === $correcta);

        if ($es_correcta) {
            $aciertos++;
        }

        $texto_usuario = $opciones[$preg][$usuario] ?? "Sin respuesta";
        $texto_correcta = $opciones[$preg][$correcta] ?? "";

        $clase = $es_correcta ? "correcto" : "incorrecto";
    ?>

        <div class="<?= $clase ?>">

            <h3><?= $preguntas[$preg] ?></h3>

            <p><strong>Tu respuesta:</strong>
                <?= htmlspecialchars($texto_usuario) ?>
            </p>

            <?php if ($es_correcta): ?>
                <p>✔ Correcto</p>
            <?php else: ?>
                <p>✘ Incorrecto</p>
                <p><strong>Respuesta correcta:</strong>
                    <?= htmlspecialchars($texto_correcta) ?>
                </p>
            <?php endif; ?>

        </div>

    <?php endforeach; ?>

    <?php
    $porcentaje = round(($aciertos / $total) * 100);
    ?>

    <div class="resultado">

        <h2>Has acertado <?= $aciertos ?> de <?= $total ?> (<?= $porcentaje ?>%)</h2>

        <?php
        if ($aciertos === $total) {
            echo "<p>¡Perfecto!</p>";
        } elseif ($aciertos >= 4) {
            echo "<p>¡Muy bien!</p>";
        } elseif ($aciertos >= 2) {
            echo "<p>Sigue practicando</p>";
        } else {
            echo "<p>Repasa el material</p>";
        }
        ?>
        <a href="test.html">Volver a hacer el test</a>

    </div>

<?php endif; ?>

</div>

</body>
</html>