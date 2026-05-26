<?php
session_start();

// Inicializar historial de rondas
if (!isset($_SESSION['rondas'])) {
    $_SESSION['rondas'] = [];
}

// Banco de preguntas (mínimo 10)
$preguntas = [
    ['pregunta' => '¿Cuál es el río más largo del mundo?',
     'opciones' => ['Nilo','Amazonas','Misisipi','Yangtsé'],
     'correcta' => 1],

    ['pregunta' => '¿En qué año llegó el hombre a la Luna?',
     'opciones' => ['1965','1969','1972','1975'],
     'correcta' => 1],

    ['pregunta' => '¿Cuántos planetas tiene el sistema solar?',
     'opciones' => ['7','8','9','10'],
     'correcta' => 1],

    ['pregunta' => '¿Cuál es el elemento más abundante en la Tierra?',
     'opciones' => ['Hierro','Oxígeno','Silicio','Nitrógeno'],
     'correcta' => 0],

    ['pregunta' => '¿Capital de Japón?',
     'opciones' => ['Seúl','Tokio','Pekín','Bangkok'],
     'correcta' => 1],

    ['pregunta' => '¿Quién pintó la Mona Lisa?',
     'opciones' => ['Van Gogh','Picasso','Da Vinci','Rembrandt'],
     'correcta' => 2],

    ['pregunta' => '¿Cuál es el océano más grande?',
     'opciones' => ['Atlántico','Índico','Ártico','Pacífico'],
     'correcta' => 3],

    ['pregunta' => '¿Cuántos continentes hay?',
     'opciones' => ['5','6','7','8'],
     'correcta' => 2],

    ['pregunta' => '¿Lenguaje de la web?',
     'opciones' => ['Python','HTML','C++','Java'],
     'correcta' => 1],

    ['pregunta' => '¿Cuál es la capital de España?',
     'opciones' => ['Barcelona','Madrid','Sevilla','Valencia'],
     'correcta' => 1],
];

// Seleccionar 5 preguntas aleatorias
$indices = array_rand($preguntas, 5);
$_SESSION['indices_ronda'] = $indices;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Quiz</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<h1>Quiz de Cultura General</h1>

<form action="resultado.php" method="POST">

<?php foreach ($indices as $pos => $idx): ?>
    <div class="pregunta">
        <h3><?= ($pos + 1) . ". " . $preguntas[$idx]['pregunta'] ?></h3>

        <?php foreach ($preguntas[$idx]['opciones'] as $i => $op): ?>
            <label>
                <input type="radio" name="r<?= $pos ?>" value="<?= $i ?>" required>
                <?= $op ?>
            </label><br>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

    <button type="submit">Corregir</button>
</form>

</body>
</html>