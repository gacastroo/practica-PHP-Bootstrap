<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php

$productos = [
    [
        "nombre" => "Portátil Lenovo ThinkPad",
        "precio" => 1200.99,
        "stock" => 15,
        "categoria" => "Informática"
    ],
    [
        "nombre" => "Samsung Galaxy S24",
        "precio" => 999.50,
        "stock" => 30,
        "categoria" => "Telefonía"
    ],
    [
        "nombre" => "Auriculares Sony WH-1000XM5",
        "precio" => 399.99,
        "stock" => 25,
        "categoria" => "Audio"
    ],
    [
        "nombre" => "Monitor LG 27 pulgadas",
        "precio" => 249.90,
        "stock" => 20,
        "categoria" => "Informática"
    ],
    [
        "nombre" => "Teclado mecánico Logitech",
        "precio" => 129.99,
        "stock" => 40,
        "categoria" => "Periféricos"
    ],
    [
        "nombre" => "Disco duro SSD 1TB",
        "precio" => 89.95,
        "stock" => 50,
        "categoria" => "Almacenamiento"
    ]
];


// FUNCIÓN 1
function calcularTotal(array $productos): float {
    $total = 0;

    foreach ($productos as $producto) {
        $total += $producto["precio"] * $producto["stock"];
    }

    return $total;
}


// MOSTRAR RESULTADO FUNCIÓN 1
echo "<h2>Total del inventario</h2>";
echo "El precio total de los productos es: " . calcularTotal($productos);



// FUNCIÓN 2
function filtrarPorCategoria(array $productos, string $cat): array {
    $resultado = [];

    foreach ($productos as $producto) {
        if ($producto["categoria"] === $cat) {
            $resultado[] = $producto;
        }
    }

    return $resultado;
}


// MOSTRAR RESULTADO FUNCIÓN 2
echo "<h2>Productos de la categoría Informática</h2>";

$informatica = filtrarPorCategoria($productos, "Informática");

foreach ($informatica as $producto) {
    echo "<br>";
    echo $producto["categoria"] . "<br>";
    echo $producto["nombre"] . " - " . $producto["precio"] . "€<br>";
}



// TABLA ORIGINAL
echo "<h2>Tabla de productos</h2>";

echo '<table border="1" cellpadding="10">';

echo "
<tr>
    <th>Nombre</th>
    <th>Stock</th>
    <th>Precio</th>
    <th>Categoría</th>
</tr>";

$i = 0;

foreach ($productos as $producto) {
    $i++;

    $color = ($i % 2 === 0) ? "#f0f0f0" : "#dab9b9";

    $nombre = $producto['nombre'];
    $stock = $producto['stock'];
    $precio = $producto['precio'];
    $categoria = $producto['categoria'];

    echo "<tr style='background-color: $color;'>    
        <td>$nombre</td>        
        <td>$stock</td>
        <td>$precio €</td>
        <td>$categoria</td>
    </tr>";
}

echo '</table>';



// FUNCIÓN 3
function ordenarProductos(array $productos): array {

    usort($productos, function($a, $b) {
        return $a["precio"] <=> $b["precio"];
    });

    return $productos;
}


// MOSTRAR RESULTADO FUNCIÓN 3
echo "<h2>Productos ordenados por precio</h2>";

$ordenados = ordenarProductos($productos);

foreach ($ordenados as $producto) {
    echo $producto["nombre"] . " - " . $producto["precio"] . "€<br>";
}

?>

</body>
</html>