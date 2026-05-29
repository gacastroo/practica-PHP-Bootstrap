<?php
require_once 'funciones.php';
requireRol(['admin']);
require_once 'contenidos.php';

$mensaje = '';

// Eliminar contenido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $id = (int)$_POST['id'];
    $_SESSION['contenidos'] = array_values(
        array_filter($_SESSION['contenidos'], fn($c) => $c['id'] !== $id)
    );
    $mensaje = 'Contenido eliminado correctamente.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar contenido</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="pagina">

    <h1>Eliminar contenido</h1>

    <?php if ($mensaje): ?>
        <div class="mensaje admin"><?= $mensaje; ?></div>
    <?php endif; ?>

    <?php if (empty($_SESSION['contenidos'])): ?>
        <p style="color:var(--muted); font-size:13px; margin-top:1rem;">No hay contenidos disponibles.</p>
    <?php else: ?>
        <div class="tabla-contenidos" style="margin-top:1.5rem;">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Cuerpo</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['contenidos'] as $c): ?>
                        <tr>
                            <td><?= $c['id']; ?></td>
                            <td><?= htmlspecialchars($c['titulo']); ?></td>
                            <td><?= htmlspecialchars($c['cuerpo']); ?></td>
                            <td>
                                <form method="POST" action="eliminar.php" style="margin:0; padding:0;" onsubmit="return confirm('¿Seguro que deseas eliminar este contenido?');">
                                    <input type="hidden" name="id" value="<?= $c['id']; ?>">
                                    <input type="hidden" name="eliminar" value="1">
                                    <button
                                        type="submit"
                                        style="padding:6px 14px; background:#c53030; color:#fff; border:none; border-radius:var(--radius-sm); font-size:12px; font-weight:500; cursor:pointer;"
                                    >Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <a href="panel.php" style="margin-top:1.5rem;">← Volver al panel</a>

</div>

</body>
</html>
