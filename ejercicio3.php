<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
</head>
<body>

<?php
// =====================
// 1. TABLA DE MULTIPLICAR 10x10
// =====================
echo "<h2>Tabla de multiplicar</h2>";
echo '<table border="1">';

for ($fila = 1; $fila <= 10; $fila++) {
    echo '<tr>';
    for ($col = 1; $col <= 10; $col++) {
        echo '<td>' . ($fila * $col) . '</td>';
    }
    echo '</tr>';
}

echo '</table>';


// =====================
// 2. TABLA DE PAÍSES
// =====================
echo "<h2>Países y capitales</h2>";

$paises = array(
    "España" => "Madrid",
    "Francia" => "París",
    "Alemania" => "Berlín",
    "Portugal" => "Lisboa",
    "Italia" => "Roma"
);

echo '<table border="1">';

$i = 0;

foreach ($paises as $pais => $capital) {
    $i++;
    $color = ($i % 2 === 0) ? "#f0f0f0" : "#dab9b9";

    echo "<tr style='background-color: $color;'>
            <td>$pais</td>
            <td>$capital</td>
          </tr>";
}

echo '</table>';


// =====================
// 3. ESTACIÓN DEL AÑO
// =====================
echo "<h2>Estación del año</h2>";

$mes = date("n");
$estacion = "";

switch ($mes) {
    case 12:
    case 1:
    case 2:
        $estacion = "❄️ Invierno";
        break;

    case 3:
    case 4:
    case 5:
        $estacion = "🌸 Primavera";
        break;

    case 6:
    case 7:
    case 8:
        $estacion = "☀️ Verano";
        break;

    case 9:
    case 10:
    case 11:
        $estacion = "🍂 Otoño";
        break;
}

echo "La estación del año es: $estacion";

?>

</body>
</html>