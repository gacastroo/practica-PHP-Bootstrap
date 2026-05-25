<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<?php

if (!isset($_POST["valor"]) || $_POST["valor"] === "") {

    echo "<h2>Error: debes introducir un valor.</h2>";
    echo '<a href="conversor.html">← Volver al conversor</a>';
    exit;
}

$valor = $_POST["valor"];
$conversion = $_POST["conversion"];

if (!is_numeric($valor)) {

    echo "<h2>Error: el valor debe ser numérico.</h2>";
    echo '<a href="conversor.html">← Volver al conversor</a>';
    exit;
}

$resultado = 0;
$unidadOrigen = "";
$unidadDestino = "";

switch ($conversion) {

    // Longitud
    case "km_m":
        $resultado = $valor * 1000;
        $unidadOrigen = "km";
        $unidadDestino = "m";
        break;

    case "m_km":
        $resultado = $valor / 1000;
        $unidadOrigen = "m";
        $unidadDestino = "km";
        break;

    // Peso
    case "kg_g":
        $resultado = $valor * 1000;
        $unidadOrigen = "kg";
        $unidadDestino = "g";
        break;

    case "g_kg":
        $resultado = $valor / 1000;
        $unidadOrigen = "g";
        $unidadDestino = "kg";
        break;

    case "lb_kg":
        $resultado = $valor * 0.453592;
        $unidadOrigen = "lb";
        $unidadDestino = "kg";
        break;

    case "kg_lb":
        $resultado = $valor / 0.453592;
        $unidadOrigen = "kg";
        $unidadDestino = "lb";
        break;

    // Temperatura
    case "c_f":
        $resultado = ($valor * 9/5) + 32;
        $unidadOrigen = "°C";
        $unidadDestino = "°F";
        break;

    case "f_c":
        $resultado = ($valor - 32) * 5/9;
        $unidadOrigen = "°F";
        $unidadDestino = "°C";
        break;

    default:
        echo "<h2>Error: conversión no válida.</h2>";
        echo '<a href="conversor.html">← Volver al conversor</a>';
        exit;
}

// Formatear números
$valorFormateado = number_format($valor, 2, ",", ".");
$resultadoFormateado = number_format($resultado, 2, ",", ".");

echo "<h1>Resultado de la conversión</h1>";

echo "<p>";
echo "$valorFormateado $unidadOrigen = ";
echo "$resultadoFormateado $unidadDestino";
echo "</p>";

?>

<br>

<a href="conversor.html">← Volver al conversor</a>

</body>
</html>