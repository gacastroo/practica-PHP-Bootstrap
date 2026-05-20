<?php require_once 'procesar.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Calculadora PHP</title>

    <link rel="stylesheet" href="estilos.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">

</head>

<body>

<div class="container">

    <h1>Calculadora GCA</h1>

    <form method="POST">

        <label>Primer número</label>
        <input type="number" name="operando1" step="any" required>

        <label>Segundo número</label>
        <input type="number" name="operando2" step="any" required>

        <label>Operación</label>

        <select name="operacion" required>

            <option value="">Selecciona</option>
            <option value="suma">Suma</option>
            <option value="resta">Resta</option>
            <option value="multiplicacion">Multiplicación</option>
            <option value="division">División</option>

        </select>

        <button type="submit">
            Calcular
        </button>

    </form>

    <?php if ($error): ?>

        <div class="error">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>

    <?php endif; ?>

    <?php if ($resultado !== null && !$error): ?>

        <div class="resultado">

            <p>
                <?= htmlspecialchars($a, ENT_QUOTES, 'UTF-8') ?>
                <?= htmlspecialchars($simbolo, ENT_QUOTES, 'UTF-8') ?>
                <?= htmlspecialchars($b, ENT_QUOTES, 'UTF-8') ?>
                =
            </p>

            <h2>
                <?= htmlspecialchars($resultado, ENT_QUOTES, 'UTF-8') ?>
            </h2>

        </div>

    <?php endif; ?>

</div>

</body>
</html>