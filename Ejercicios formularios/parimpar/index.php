<?php
$resultado = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $num = (int)($_POST["numero"] ?? 0);

    $paridad = ($num % 2 === 0) ? "par" : "impar";

    // Calcular signo
    if ($num > 0) {
        $signo = "positivo";
    } elseif ($num < 0) {
        $signo = "negativo";
    } else {
        $signo = "cero";
    }

    $resultado = "El número $num es $paridad y $signo.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Par o impar</title>
</head>
<body>

    <h1>Par o impar</h1>

    <?php if ($resultado !== ""): ?>
        <p><?= $resultado ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="number" name="numero" required>
        <button type="submit">Calcular</button>
    </form>

</body>
</html>