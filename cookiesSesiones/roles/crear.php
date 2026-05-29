<?php
require_once 'funciones.php';
requireRol(['admin', 'editor']);
require_once 'contenidos.php';

$mensaje = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $cuerpo = trim($_POST['cuerpo'] ?? '');

    if ($titulo === '' || $cuerpo === '') {
        $error = 'El título y el cuerpo son obligatorios.';
    } else {
        $nuevo = [
            'id'     => $_SESSION['next_id']++,
            'titulo' => $titulo,
            'cuerpo' => $cuerpo,
        ];
        $_SESSION['contenidos'][] = $nuevo;
        $mensaje = 'Contenido creado exitosamente.';
    }
}

function crearContenido() {
    return "Contenido creado exitosamente.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear contenido</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="pagina">

    <h1>Crear contenido</h1>

    <?php if ($mensaje): ?>
        <div class="mensaje editor"><?= $mensaje; ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="error"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="crear.php" style="display:flex; flex-direction:column; gap:12px; margin-top:1.5rem;">

        <div class="campo">
            <label for="titulo" style="font-size:13px; font-weight:500; color:var(--text); margin-bottom:4px; display:block;">Título</label>
            <input
                type="text"
                id="titulo"
                name="titulo"
                placeholder="Título del contenido"
                value="<?= htmlspecialchars($_POST['titulo'] ?? ''); ?>"
                style="width:100%; padding:10px 14px; border:1px solid var(--border); border-radius:var(--radius-sm); font-size:14px; background:var(--bg); color:var(--text); outline:none;"
            >
        </div>

        <div class="campo">
            <label for="cuerpo" style="font-size:13px; font-weight:500; color:var(--text); margin-bottom:4px; display:block;">Cuerpo</label>
            <textarea
                id="cuerpo"
                name="cuerpo"
                placeholder="Escribe el contenido aquí..."
                rows="5"
                style="width:100%; padding:10px 14px; border:1px solid var(--border); border-radius:var(--radius-sm); font-size:14px; background:var(--bg); color:var(--text); outline:none; resize:vertical; font-family:inherit;"
            ><?= htmlspecialchars($_POST['cuerpo'] ?? ''); ?></textarea>
        </div>

        <div>
            <button
                type="submit"
                style="padding:10px 22px; background:var(--primary); color:#fff; border:none; border-radius:var(--radius-sm); font-size:14px; font-weight:500; cursor:pointer; transition:background .15s;"
            >Crear contenido</button>
        </div>

    </form>

    <a href="panel.php" style="margin-top:1.5rem;">← Volver al panel</a>

</div>

</body>
</html>
