<?php
require_once 'funciones.php';
requireRol(['admin', 'editor']);
require_once 'contenidos.php';

$mensaje = '';
$error   = '';
$editando = null;

// Guardar cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    $id     = (int)$_POST['id'];
    $titulo = trim($_POST['titulo'] ?? '');
    $cuerpo = trim($_POST['cuerpo'] ?? '');

    if ($titulo === '' || $cuerpo === '') {
        $error = 'El título y el cuerpo son obligatorios.';
        $editando = ['id' => $id, 'titulo' => $_POST['titulo'], 'cuerpo' => $_POST['cuerpo']];
    } else {
        foreach ($_SESSION['contenidos'] as &$c) {
            if ($c['id'] === $id) {
                $c['titulo'] = $titulo;
                $c['cuerpo'] = $cuerpo;
                break;
            }
        }
        unset($c);
        $mensaje = 'Contenido editado exitosamente.';
    }
}

// Cargar formulario de edición
if (isset($_GET['id']) && !$editando) {
    $id = (int)$_GET['id'];
    foreach ($_SESSION['contenidos'] as $c) {
        if ($c['id'] === $id) {
            $editando = $c;
            break;
        }
    }
}

function editarContenido() {
    return "Contenido editado exitosamente.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar contenido</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="pagina">

    <h1>Editar contenido</h1>

    <?php if ($mensaje): ?>
        <div class="mensaje editor"><?= $mensaje; ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="error"><?= $error; ?></div>
    <?php endif; ?>

    <?php if ($editando): ?>

        <!-- Formulario de edición -->
        <form method="POST" action="editar.php" style="display:flex; flex-direction:column; gap:12px; margin-top:1.5rem;">
            <input type="hidden" name="id" value="<?= $editando['id']; ?>">
            <input type="hidden" name="guardar" value="1">

            <div class="campo">
                <label style="font-size:13px; font-weight:500; color:var(--text); margin-bottom:4px; display:block;">Título</label>
                <input
                    type="text"
                    name="titulo"
                    value="<?= htmlspecialchars($editando['titulo']); ?>"
                    style="width:100%; padding:10px 14px; border:1px solid var(--border); border-radius:var(--radius-sm); font-size:14px; background:var(--bg); color:var(--text); outline:none;"
                >
            </div>

            <div class="campo">
                <label style="font-size:13px; font-weight:500; color:var(--text); margin-bottom:4px; display:block;">Cuerpo</label>
                <textarea
                    name="cuerpo"
                    rows="5"
                    style="width:100%; padding:10px 14px; border:1px solid var(--border); border-radius:var(--radius-sm); font-size:14px; background:var(--bg); color:var(--text); outline:none; resize:vertical; font-family:inherit;"
                ><?= htmlspecialchars($editando['cuerpo']); ?></textarea>
            </div>

            <div style="display:flex; gap:10px;">
                <button
                    type="submit"
                    style="padding:10px 22px; background:var(--primary); color:#fff; border:none; border-radius:var(--radius-sm); font-size:14px; font-weight:500; cursor:pointer;"
                >Guardar cambios</button>
                <a href="editar.php" style="margin-top:0; background:var(--muted);">Cancelar</a>
            </div>
        </form>

    <?php else: ?>

        <!-- Listado de contenidos -->
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
                                    <a
                                        href="editar.php?id=<?= $c['id']; ?>"
                                        style="margin-top:0; padding:6px 14px; font-size:12px;"
                                    >Editar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <a href="panel.php" style="margin-top:1.5rem;">← Volver al panel</a>

</div>

</body>
</html>
