<?php
date_default_timezone_set('Europe/Madrid');

/**
 * Formatea la fecha actual en castellano.
 */
function obtenerFechaCastellano(): string
{
    $dias = [
        'Sunday' => 'domingo',
        'Monday' => 'lunes',
        'Tuesday' => 'martes',
        'Wednesday' => 'miércoles',
        'Thursday' => 'jueves',
        'Friday' => 'viernes',
        'Saturday' => 'sábado'
    ];

    $meses = [
        'January' => 'enero',
        'February' => 'febrero',
        'March' => 'marzo',
        'April' => 'abril',
        'May' => 'mayo',
        'June' => 'junio',
        'July' => 'julio',
        'August' => 'agosto',
        'September' => 'septiembre',
        'October' => 'octubre',
        'November' => 'noviembre',
        'December' => 'diciembre'
    ];

    $diaSemana = $dias[date('l')] ?? date('l');
    $dia = date('d');
    $mes = $meses[date('F')] ?? date('F');
    $anio = date('Y');

    return "$diaSemana, $dia de $mes de $anio";
}

/**
 * Devuelve true si la fecha cae en fin de semana.
 */
function esFinDeSemana(DateTime $fecha): bool
{
    return (int) $fecha->format('N') >= 6; // 6=sábado, 7=domingo
}

/**
 * Clasifica una hora en punta, llano o valle.
 *
 * Nota:
 * - Los fines de semana se consideran valle durante todo el día.
 * - Para festivos nacionales habría que añadir un calendario de festivos
 *   o consultar una fuente externa fiable.
 */
function clasificarPeriodo(DateTime $fecha): string
{
    $hora = (int) $fecha->format('H');

    if (esFinDeSemana($fecha)) {
        return 'valle';
    }

    if (($hora >= 10 && $hora < 14) || ($hora >= 18 && $hora < 22)) {
        return 'punta';
    }

    if (($hora >= 8 && $hora < 10) || ($hora >= 14 && $hora < 18) || ($hora >= 22 && $hora < 24)) {
        return 'llano';
    }

    return 'valle';
}

/**
 * Realiza una petición HTTP sencilla con timeout.
 */
function obtenerContenidoUrl(string $url): string|false
{
    $contexto = stream_context_create([
        'http' => [
            'timeout' => 10,
            'ignore_errors' => true,
            'header' => "Accept: application/json\r\n"
        ]
    ]);

    return file_get_contents($url, false, $contexto);
}

/**
 * Devuelve el registro con el precio mínimo de un tramo.
 */
function obtenerMinimo(array $periodo): ?array
{
    if (empty($periodo)) {
        return null;
    }

    $precios = array_column($periodo, 'precio');
    $minimo = min($precios);
    $indice = array_search($minimo, $precios, true);

    return $periodo[$indice];
}

/**
 * Devuelve el registro con el precio máximo de un tramo.
 */
function obtenerMaximo(array $periodo): ?array
{
    if (empty($periodo)) {
        return null;
    }

    $precios = array_column($periodo, 'precio');
    $maximo = max($precios);
    $indice = array_search($maximo, $precios, true);

    return $periodo[$indice];
}

/**
 * Renderiza una tarjeta de periodo horario.
 */
function renderizarPeriodo(
    string $titulo,
    string $descripcion,
    array $datos,
    ?array $minimo,
    ?array $maximo,
    string $tipoPeriodo,
    string $etiquetaPeriodo
): void {
    $clasePeriodo = 'card-' . $tipoPeriodo;
    ?>
    <section class="card <?= htmlspecialchars($clasePeriodo, ENT_QUOTES, 'UTF-8') ?>">
        <div class="encabezado-periodo">
            <span class="etiqueta-periodo"><?= htmlspecialchars($etiquetaPeriodo, ENT_QUOTES, 'UTF-8') ?></span>
            <h2><?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?></h2>
        </div>
        <p class="descripcion"><?= htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8') ?></p>

        <?php if ($minimo && $maximo): ?>
            <div class="destacados">
                <div class="alerta verde">
                    <span>Hora recomendada</span>
                    <strong><?= htmlspecialchars($minimo['horaTexto'], ENT_QUOTES, 'UTF-8') ?></strong>
                    <small><?= number_format($minimo['precio'], 5, ',', '.') ?> €/kWh</small>
                </div>

                <div class="alerta roja">
                    <span>Hora a evitar</span>
                    <strong><?= htmlspecialchars($maximo['horaTexto'], ENT_QUOTES, 'UTF-8') ?></strong>
                    <small><?= number_format($maximo['precio'], 5, ',', '.') ?> €/kWh</small>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Hora</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $registro): ?>
                        <?php
                            $esHoraMasBarata = $minimo
                                && isset($registro['hora'], $registro['precio'], $minimo['hora'], $minimo['precio'])
                                && $registro['hora'] === $minimo['hora']
                                && abs($registro['precio'] - $minimo['precio']) < 0.00001;
                        ?>
                        <tr class="<?= $esHoraMasBarata ? 'fila-minima' : '' ?>">
                            <td class="celda-hora">
                                <span><?= htmlspecialchars($registro['horaTexto'], ENT_QUOTES, 'UTF-8') ?></span>
                                <?php if ($esHoraMasBarata): ?>
                                    <span class="badge-minimo">Más barata</span>
                                <?php endif; ?>
                            </td>
                            <td><?= number_format($registro['precio'], 5, ',', '.') ?> €/kWh</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="error">No hay datos disponibles para este periodo.</p>
        <?php endif; ?>
    </section>
    <?php
}

// -----------------------------
// 1. Construcción dinámica de URL
// -----------------------------

$fechaHoy = date('Y-m-d');

$url = "https://apidatos.ree.es/es/datos/mercados/precios-mercados-tiempo-real"
     . "?start_date={$fechaHoy}T00:00"
     . "&end_date={$fechaHoy}T23:59"
     . "&time_trunc=hour";

// -----------------------------
// 2. Petición HTTP a la API
// -----------------------------

$respuesta = obtenerContenidoUrl($url);

$error = null;
$punta = [];
$llano = [];
$valle = [];

if ($respuesta === false) {
    $error = "No se ha podido conectar con la API de Red Eléctrica.";
} else {
    $datos = json_decode($respuesta, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        $error = "La respuesta recibida no es un JSON válido.";
    } elseif (
        !isset($datos['included'][0]['attributes']['values']) ||
        !is_array($datos['included'][0]['attributes']['values'])
    ) {
        $error = "La estructura de datos recibida no es válida.";
    } else {
        $valores = $datos['included'][0]['attributes']['values'];

        foreach ($valores as $registro) {
            if (!isset($registro['value'], $registro['datetime'])) {
                continue;
            }

            // Precio original en €/MWh.
            $precioMWh = (float) $registro['value'];

            // Conversión a €/kWh.
            $precioKWh = round($precioMWh / 1000, 5);

            try {
                $fechaRegistro = new DateTime($registro['datetime']);
            } catch (Exception $e) {
                continue;
            }

            $hora = (int) $fechaRegistro->format('H');

            // Ejemplo: 08:00 - 09:00.
            $horaInicio = $fechaRegistro->format('H:00');
            $fechaFin = clone $fechaRegistro;
            $fechaFin->modify('+1 hour');
            $horaFin = $fechaFin->format('H:00');

            $item = [
                'hora' => $hora,
                'horaTexto' => "$horaInicio - $horaFin",
                'precio' => $precioKWh
            ];

            $periodo = clasificarPeriodo($fechaRegistro);

            switch ($periodo) {
                case 'punta':
                    $punta[] = $item;
                    break;

                case 'llano':
                    $llano[] = $item;
                    break;

                case 'valle':
                    $valle[] = $item;
                    break;
            }
        }
    }
}

// -----------------------------
// 3. Cálculo de máximos y mínimos
// -----------------------------

$minPunta = obtenerMinimo($punta);
$maxPunta = obtenerMaximo($punta);

$minLlano = obtenerMinimo($llano);
$maxLlano = obtenerMaximo($llano);

$minValle = obtenerMinimo($valle);
$maxValle = obtenerMaximo($valle);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Monitor de Precio de la Luz PVPC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header class="cabecera">
    <h1>Monitor de Precio de la Luz PVPC</h1>
    <p><?= htmlspecialchars(obtenerFechaCastellano(), ENT_QUOTES, 'UTF-8') ?></p>
</header>

<main class="contenedor">
    <?php if ($error): ?>
        <div class="mensaje-error">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php else: ?>
        <?php
            renderizarPeriodo(
                'Periodo Punta',
                'Precio alto: 10:00-14:00 y 18:00-22:00',
                $punta,
                $minPunta,
                $maxPunta,
                'punta',
                'Más caro'
            );

            renderizarPeriodo(
                'Periodo Llano',
                'Precio medio: 08:00-10:00, 14:00-18:00 y 22:00-24:00',
                $llano,
                $minLlano,
                $maxLlano,
                'llano',
                'Intermedio'
            );

            renderizarPeriodo(
                'Periodo Valle',
                'Precio económico: 00:00-08:00. Fines de semana: todo el día.',
                $valle,
                $minValle,
                $maxValle,
                'valle',
                'Más barato'
            );
        ?>
    <?php endif; ?>
</main>

<footer>
    <p>Datos obtenidos desde la API pública de Red Eléctrica de España.</p>
</footer>

</body>
</html>
