<?php

require_once 'funciones.php';

$resultado = null;
$error = '';
$simbolo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validación segura (mejor que usar $_POST directamente)
    $a = filter_input(INPUT_POST, 'operando1', FILTER_VALIDATE_FLOAT);
    $b = filter_input(INPUT_POST, 'operando2', FILTER_VALIDATE_FLOAT);
    $operacion = filter_input(INPUT_POST, 'operacion', FILTER_UNSAFE_RAW);

    if ($a === false || $b === false) {

        $error = "Introduce números válidos.";

    } else {

        switch ($operacion) {

            case 'suma':
                $resultado = suma($a, $b);
                $simbolo = '+';
                break;

            case 'resta':
                $resultado = resta($a, $b);
                $simbolo = '-';
                break;

            case 'multiplicacion':
                $resultado = multiplicacion($a, $b);
                $simbolo = '×';
                break;

            case 'division':

                if ($b == 0) {
                    $error = "No se puede dividir entre cero.";
                } else {
                    $resultado = division($a, $b);
                    $simbolo = '÷';
                }

                break;

            default:
                $error = "Selecciona una operación.";
        }
    }
}