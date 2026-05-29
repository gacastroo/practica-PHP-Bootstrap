<?php

header('Content-Type: application/json');

$num1 = isset($_POST['num1']) ? (float)$_POST['num1'] : null;
$num2 = isset($_POST['num2']) ? (float)$_POST['num2'] : null;
$op = $_POST['op'] ?? null;

function error_json(string $mensaje): void {
    echo json_encode([
        'ok' => false,
        'mensaje' => $mensaje
    ]);
    exit;
}

// Validar números
if ($num1 === null || $num2 === null) {
    error_json('Faltan números');
}

$opvalidas = ['suma', 'resta', 'multiplicacion', 'division'];

if (!in_array($op, $opvalidas)) {
    error_json('Operación no válida');
}

switch ($op) {
    case 'suma':
        $resultado = $num1 + $num2;
        $simbolo = '+';
        break;

    case 'resta':
        $resultado = $num1 - $num2;
        $simbolo = '-';
        break;

    case 'multiplicacion':
        $resultado = $num1 * $num2;
        $simbolo = '*';
        break;

    case 'division':
        if ($num2 == 0) {
            error_json('No se puede dividir por cero');
        }

        $resultado = $num1 / $num2;
        $simbolo = '/';
        break;
}

echo json_encode([
    'ok' => true,
    'resultado' => round($resultado, 6),
    'operacion' => "$num1 $simbolo $num2"
]);