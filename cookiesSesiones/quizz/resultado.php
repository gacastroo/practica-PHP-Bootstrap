<?php
session_start();

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

    ['pregunta' => '¿Cuál es la capital de Japón?',
     'opciones' => ['Seúl','Tokio','Pekín','Bangkok'],
     'correcta' => 1],

    ['pregunta' => '¿Quién pintó la Mona Lisa?',
     'opciones' => ['Miguel Ángel','Da Vinci','Picasso','Van Gogh'],
     'correcta' => 1],

    ['pregunta' => '¿Qué gas respiramos principalmente?',
     'opciones' => ['Oxígeno','Hidrógeno','Nitrógeno','CO2'],
     'correcta' => 2],

    ['pregunta' => '¿Cuántos continentes hay?',
     'opciones' => ['5','6','7','8'],
     'correcta' => 2],

    ['pregunta' => '¿Cuál es el océano más grande?',
     'opciones' => ['Atlántico','Índico','Ártico','Pacífico'],
     'correcta' => 3],

    ['pregunta' => '¿Cuál es el idioma más hablado del mundo?',
     'opciones' => ['Inglés','Español','Chino mandarín','Hindi'],
     'correcta' => 2],
];

$indices = $_SESSION['indices_ronda'] ?? [];

if (!$indices) {
    header("Location: quizz.php");
    exit;
}

$aciertos = 0;

foreach ($indices as $pos => $idx) {
    $respuesta = (int)($_POST["r$pos"] ?? -1);

    if ($respuesta === $preguntas[$idx]['correcta']) {
        $aciertos++;
    }
}

// Guardar ronda
$_SESSION['rondas'][] = [
    'ronda' => count($_SESSION['rondas']) + 1,
    'aciertos' => $aciertos,
    'fecha' => date('H:i:s')
];

$rondas = $_SESSION['rondas'];

// Estadísticas
$total = array_sum(array_column($rondas, 'aciertos'));
$mejor = max(array_column($rondas, 'aciertos'));
$peor = min(array_column($rondas, 'aciertos'));

$total_preguntas = count($rondas) * 5;
$porcentaje = round(($total / $total_preguntas) * 100);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<h1>Resultados de la ronda</h1>

<p><strong>Aciertos:</strong> <?= $aciertos ?>/5</p>
<p><strong>Total acumulado:</strong> <?= $total ?></p>
<p><strong>Mejor ronda:</strong> <?= $mejor ?>/5</p>
<p><strong>Peor ronda:</strong> <?= $peor ?>/5</p>
<p><strong>Porcentaje global:</strong> <?= $porcentaje ?>%</p>

<h2>Historial</h2>

<?php foreach ($rondas as $r): 
    $barra = str_repeat('█', $r['aciertos']) . str_repeat('░', 5 - $r['aciertos']);
?>
    <p>
        Ronda <?= $r['ronda'] ?>:
        <?= $barra ?> <?= $r['aciertos'] ?>/5 —
        <?= $r['fecha'] ?>
    </p>
<?php endforeach; ?>

<br>

<a href="quizz.php"><button>Jugar otra ronda</button></a>
<a href="reiniciar.php"><button>Reiniciar todo</button></a>

</body>
</html>