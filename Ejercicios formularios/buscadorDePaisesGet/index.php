<?php

$paises = [
    "Alemania", "Argentina", "Australia", "Brasil", "Canada",
    "Chile", "China", "Colombia", "Espana", "Francia",
    "Grecia", "India", "Italia", "Japon", "Mexico",
    "Nigeria", "Peru", "Polonia", "Portugal", "Reino Unido",
    "Rusia", "Sudafrica", "Turquia", "Uruguay", "Venezuela",
];

// Leer búsqueda desde la URL
$busqueda = trim($_GET["q"] ?? "");

// Array de resultados
$resultados = [];

// Si no hay búsqueda, mostrar todos
if ($busqueda === "") {
    $resultados = $paises;
} else {

    // Filtrar países
    foreach ($paises as $pais) {

        // Buscar ignorando mayúsculas/minúsculas
        if (stripos($pais, $busqueda) !== false) {
            $resultados[] = $pais;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscador de países</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<body>

    <h1>Buscador de países</h1>

    <form method="GET" action="">
        <input
            type="text"
            name="q"
            placeholder="Escribe un país..."
            value="<?= htmlspecialchars($busqueda) ?>"
        >

        <button type="submit">Buscar</button>
    </form>

    <?php if (count($resultados) > 0): ?>

        <p>
            Se encontraron <?= count($resultados) ?> países
        </p>

        <ul>
            <?php foreach ($resultados as $pais): ?>
                <li><?= htmlspecialchars($pais) ?></li>
            <?php endforeach; ?>
        </ul>

    <?php else: ?>

        <p>No se encontraron países con ese nombre.</p>

    <?php endif; ?>

</body>
</html>