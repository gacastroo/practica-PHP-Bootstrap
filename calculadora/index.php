<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio3</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="contenedor">

<?php
require_once 'operaciones.php';
$resultado = 0; 
?>

<form method="POST">
    <label for="num1"><strong>Operador 1:</strong></label>
    <input type="number" id="num1" name="num1" required>

    <label for="num2"><strong>Operador 2:</strong></label>
    <input type="number" id="num2" name="num2" required>

    <select name="operacion">
        <option value="suma">suma</option>
        <option value="resta">resta</option>
        <option value="multiplicacion">multiplicacion</option>
        <option value="division">division</option>
    </select>

    <button type="submit">Enviar</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $a = $_POST["num1"];
    $b = $_POST["num2"];
    $op = $_POST["operacion"];

    switch ($op) {
        case "suma":
            $resultado = sumar($a, $b);
            break;
        case "resta":
            $resultado = restar($a, $b);
            break;
        case "multiplicacion":
            $resultado = multiplicar($a, $b);
            break;
        case "division":
            $resultado = dividir($a, $b);
            break;
        default:
            $resultado = "Seleccione una operación";
            break;
    }

    echo "<div class='resultado'>Resultado: $resultado</div>";
}
?>

</div>

</body>
</html>