<?php

$empresa = htmlspecialchars(trim($_POST["empresa"] ?? ""));
$email = filter_var(trim($_POST["email"] ?? ""), FILTER_VALIDATE_EMAIL);

$tipo = $_POST["tipo"] ?? "particular";
$urgente = isset($_POST["urgente"]);
$servicios = $_POST["servicios"] ?? [];

$errores = [];

// =========================
// VALIDACIÓN
// =========================
if (empty(trim($empresa))) {
    $errores[] = "El nombre de la empresa es obligatorio.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El email no tiene un formato válido.";
}

if (!$servicios) {
    $errores[] = "Debes seleccionar al menos un servicio.";
}

// =========================
// PRECIOS
// =========================
$precios = [
    "logo" => ["nombre" => "Diseño de logotipo", "precio" => 350],
    "web" => ["nombre" => "Página web básica", "precio" => 200],
    "mantenimiento" => ["nombre" => "Mantenimiento web", "precio" => 150],
    "seo" => ["nombre" => "SEO básico", "precio" => 100]
];

$subtotal = 0;
$lineas = [];

// =========================
// SOLO CALCULAR SI NO HAY ERRORES
// =========================
if (empty($errores)) {

    foreach ($servicios as $item) {
        if (!isset($precios[$item])) continue;

        $precio = $precios[$item]["precio"];
        $nombre = $precios[$item]["nombre"];

        $subtotal += $precio;

        $lineas[] = [
            "nombre" => $nombre,
            "precio" => $precio
        ];
    }

    $descuentos = [
        "particular" => 0,
        "autonomo" => 0.05,
        "empresa" => 0.10
    ];

    $descuento = $descuentos[$tipo] ?? 0;
    $importe_descuento = $subtotal * $descuento;

    $recargo = $urgente ? $subtotal * 0.20 : 0;

    $base = $subtotal - $importe_descuento + $recargo;
    $iva = $base * 0.21;
    $total = $base + $iva;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Presupuesto</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<h1>Presupuesto generado</h1>

<!-- =========================
     ERRORES EN DIV (SOLO PHP)
========================= -->
<div id="errores">
    <?php if (!empty($errores)): ?>
        <?php foreach ($errores as $error): ?>
            <p><?= $error ?></p>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php if (empty($errores)): ?>

<p><strong>Empresa:</strong> <?= $empresa ?></p>
<p><strong>Email:</strong> <?= $email ?></p>

<h2>Detalle</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Servicio</th>
        <th>Precio</th>
    </tr>

    <?php foreach ($lineas as $l): ?>
        <tr>
            <td><?= $l["nombre"] ?></td>
            <td><?= number_format($l["precio"], 2, ',', '.') . " €" ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Resumen</h2>

<p>Subtotal: <?= number_format($subtotal, 2, ',', '.') . " €" ?></p>
<p>Descuento: -<?= number_format($importe_descuento, 2, ',', '.') . " €" ?></p>
<p>Recargo urgente: +<?= number_format($recargo, 2, ',', '.') . " €" ?></p>
<p>Base imponible: <?= number_format($base, 2, ',', '.') . " €" ?></p>
<p>IVA (21%): <?= number_format($iva, 2, ',', '.') . " €" ?></p>

<h3>Total: <?= number_format($total, 2, ',', '.') . " €" ?></h3>

<?php endif; ?>

<a href="formulario.html">Volver al formulario</a>

</body>
</html>