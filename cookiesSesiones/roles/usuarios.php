<?php
require_once 'funciones.php';
requireRol(['admin']);

// Inicializar usuarios en sesión si no existen
if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [
        ['id' => 1, 'usuario' => 'admin',  'clave' => 'admin123',  'nombre' => 'Ana García',  'rol' => 'admin'],
        ['id' => 2, 'usuario' => 'editor', 'clave' => 'editor123', 'nombre' => 'Pedro López', 'rol' => 'editor'],
        ['id' => 3, 'usuario' => 'lector', 'clave' => 'lector123', 'nombre' => 'María Ruiz',  'rol' => 'lector'],
    ];
    $_SESSION['next_user_id'] = 4;
}

$mensaje = '';
$error   = '';
$editando = null;

// ── Crear usuario ──────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'crear') {
    $nombre  = trim($_POST['nombre']  ?? '');
    $usuario = trim($_POST['usuario'] ?? '');
    $clave   = trim($_POST['clave']   ?? '');
    $rol     = $_POST['rol'] ?? '';

    $roles_validos = ['admin', 'editor', 'lector'];

    if ($nombre === '' || $usuario === '' || $clave === '' || !in_array($rol, $roles_validos)) {
        $error = 'Todos los campos son obligatorios y el rol debe ser válido.';
    } else {
        // Verificar usuario duplicado
        $existe = array_filter($_SESSION['usuarios'], fn($u) => $u['usuario'] === $usuario);
        if ($existe) {
            $error = 'El nombre de usuario ya existe.';
        } else {
            $_SESSION['usuarios'][] = [
                'id'      => $_SESSION['next_user_id']++,
                'usuario' => $usuario,
                'clave'   => $clave,
                'nombre'  => $nombre,
                'rol'     => $rol,
            ];
            $mensaje = 'Usuario creado correctamente.';
        }
    }
}

// ── Guardar edición ────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'guardar') {
    $id      = (int)$_POST['id'];
    $nombre  = trim($_POST['nombre']  ?? '');
    $usuario = trim($_POST['usuario'] ?? '');
    $clave   = trim($_POST['clave']   ?? '');
    $rol     = $_POST['rol'] ?? '';

    $roles_validos = ['admin', 'editor', 'lector'];

    if ($nombre === '' || $usuario === '' || $clave === '' || !in_array($rol, $roles_validos)) {
        $error = 'Todos los campos son obligatorios.';
        $editando = ['id' => $id, 'nombre' => $nombre, 'usuario' => $usuario, 'clave' => $clave, 'rol' => $rol];
    } else {
        foreach ($_SESSION['usuarios'] as &$u) {
            if ($u['id'] === $id) {
                $u['nombre']  = $nombre;
                $u['usuario'] = $usuario;
                $u['clave']   = $clave;
                $u['rol']     = $rol;
                break;
            }
        }
        unset($u);
        $mensaje = 'Usuario actualizado correctamente.';
    }
}

// ── Eliminar usuario ───────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
    $id = (int)$_POST['id'];
    // No permitir eliminar al propio admin logueado
    if ($id === 1) {
        $error = 'No puedes eliminar al administrador principal.';
    } else {
        $_SESSION['usuarios'] = array_values(
            array_filter($_SESSION['usuarios'], fn($u) => $u['id'] !== $id)
        );
        $mensaje = 'Usuario eliminado correctamente.';
    }
}

// ── Cargar formulario edición ──────────────────────
if (isset($_GET['editar']) && !$editando) {
    $id = (int)$_GET['editar'];
    foreach ($_SESSION['usuarios'] as $u) {
        if ($u['id'] === $id) {
            $editando = $u;
            break;
        }
    }
}

// ── Modo: mostrar formulario de creación ───────────
$mostrar_crear = isset($_GET['nuevo']) || ($error && !$editando && empty($_POST['accion'] === 'guardar'));
if (isset($_POST['accion']) && $_POST['accion'] === 'crear' && $error) {
    $mostrar_crear = true;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de usuarios</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="pagina" style="max-width:780px;">

    <h1>Gestión de usuarios</h1>

    <?php if ($mensaje): ?>
        <div class="mensaje editor"><?= $mensaje; ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="error"><?= $error; ?></div>
    <?php endif; ?>

    <?php if ($editando): ?>

        <!-- ── Formulario edición ── -->
        <h2 style="font-size:15px; margin-top:1.5rem; color:var(--text); border:none;">Editar usuario #<?= $editando['id']; ?></h2>

        <form method="POST" action="usuarios.php" style="display:flex; flex-direction:column; gap:12px; margin-top:1rem;">
            <input type="hidden" name="accion" value="guardar">
            <input type="hidden" name="id"     value="<?= $editando['id']; ?>">

            <?php include __DIR__ . '/inc_usuario_campos.php'; ?>

            <div style="display:flex; gap:10px; margin-top:4px;">
                <button type="submit" style="padding:10px 22px; background:var(--primary); color:#fff; border:none; border-radius:var(--radius-sm); font-size:14px; font-weight:500; cursor:pointer;">Guardar cambios</button>
                <a href="usuarios.php" style="margin-top:0; background:var(--muted);">Cancelar</a>
            </div>
        </form>

    <?php elseif ($mostrar_crear): ?>

        <!-- ── Formulario creación ── -->
        <h2 style="font-size:15px; margin-top:1.5rem; color:var(--text); border:none;">Nuevo usuario</h2>

        <form method="POST" action="usuarios.php" style="display:flex; flex-direction:column; gap:12px; margin-top:1rem;">
            <input type="hidden" name="accion" value="crear">

            <?php
            $editando = ['nombre' => $_POST['nombre'] ?? '', 'usuario' => $_POST['usuario'] ?? '', 'clave' => '', 'rol' => $_POST['rol'] ?? ''];
            include __DIR__ . '/inc_usuario_campos.php';
            ?>

            <div style="display:flex; gap:10px; margin-top:4px;">
                <button type="submit" style="padding:10px 22px; background:var(--primary); color:#fff; border:none; border-radius:var(--radius-sm); font-size:14px; font-weight:500; cursor:pointer;">Crear usuario</button>
                <a href="usuarios.php" style="margin-top:0; background:var(--muted);">Cancelar</a>
            </div>
        </form>

    <?php else: ?>

        <!-- ── Listado de usuarios ── -->
        <div style="display:flex; justify-content:flex-end; margin-bottom:1rem;">
            <a href="usuarios.php?nuevo=1" style="margin-top:0;">+ Nuevo usuario</a>
        </div>

        <div class="tabla-contenidos">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['usuarios'] as $u): ?>
                        <tr>
                            <td><?= $u['id']; ?></td>
                            <td><?= htmlspecialchars($u['nombre']); ?></td>
                            <td><?= htmlspecialchars($u['usuario']); ?></td>
                            <td>
                                <span class="badge-rol badge-<?= $u['rol']; ?>"><?= ucfirst($u['rol']); ?></span>
                            </td>
                            <td>
                                <a href="usuarios.php?editar=<?= $u['id']; ?>" style="margin-top:0; padding:5px 12px; font-size:12px;">Editar</a>
                            </td>
                            <td>
                                <?php if ($u['id'] !== 1): ?>
                                    <form method="POST" action="usuarios.php" style="margin:0;" onsubmit="return confirm('¿Eliminar a <?= htmlspecialchars($u['nombre']); ?>?');">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <input type="hidden" name="id"     value="<?= $u['id']; ?>">
                                        <button type="submit" style="padding:5px 12px; background:#c53030; color:#fff; border:none; border-radius:var(--radius-sm); font-size:12px; font-weight:500; cursor:pointer;">Eliminar</button>
                                    </form>
                                <?php else: ?>
                                    <span style="font-size:11px; color:var(--muted);">Protegido</span>
                                <?php endif; ?>
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
