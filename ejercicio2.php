<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio2</title>
</head>
<body>

<?php

$nombre = "Guillermo";
$apellido = "Castro";
$edad = 28;
$altura = 1.67;
$es_estudiante = true;

const IVA = 0.21;

/* ARRAY DE PRECIOS */
$precios = array(
    "precio1" => 2.75,
    "precio2" => 12,
    "precio3" => 556
);

/* FUNCIÓN JUBILACIÓN */
function aniosjubilacion($edad) {

    $aniosjubilacion = 67 - $edad;

    if ($aniosjubilacion <= 0) {
        return "Ya puedes jubilarte";
    } else {
        return "Te faltan " . $aniosjubilacion . " años para jubilarte";
    }
}

/* FUNCIÓN IVA */
function calcularIva($precio) {
    return $precio + ($precio * IVA);
}

/* DATOS PERSONALES */
echo "<h2>Tarjeta de presentación</h2>";

echo "Nombre: " . $nombre . "<br>";
echo "Apellido: " . $apellido . "<br>";
echo "Edad: " . $edad . "<br>";
echo "Altura: " . $altura . " m<br>";

if ($es_estudiante) {
    echo "Es estudiante<br>";
} else {
    echo "No es estudiante<br>";
}

/* JUBILACIÓN */
echo aniosjubilacion($edad) . "<br><br>";

/* PRECIOS CON IVA */
echo "<h3>Precios con IVA</h3>";

foreach ($precios as $nombrePrecio => $precio) {

    $precioFinal = calcularIva($precio);

    echo "<p> <strong>" . $nombrePrecio . "</strong>" . ": </p>" . number_format($precioFinal, 2) . " €<br>";
}

?>
<?php
echo "<br>";
echo var_dump($nombre);
echo "<br>";
var_dump($apellido);
echo "<br>";
var_dump($edad);
echo "<br>";
var_dump($altura);
echo "<br>";
var_dump($precioFinal);
echo "<br>";
var_dump($es_estudiante);
echo "<br>";
var_dump($precios);
echo "<br>";
var_dump($precio);
?>

</body>
</html>