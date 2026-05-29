<?php
require_once 'funciones.php';
requireRol(['admin', 'editor', 'lector']);
require_once 'contenidos.php';

$rol    = $_SESSION['rol'];
$nombre = $_SESSION['nombre'];
$contenidos = $_SESSION['contenidos'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="layout">

    <aside class="sidebar">

        <h2>Panel</h2>

        <p>
            <strong><?= $nombre; ?></strong>
        </p>

        <p>
            Rol: <strong><?= ucfirst($rol); ?></strong>
        </p>

        <hr>

        <ul>

            <?php if ($rol === 'admin' || $rol === 'editor'): ?>

                <li>
                    <a href="crear.php">Crear contenido</a>
                </li>

                <li>
                    <a href="editar.php">Editar contenido</a>
                </li>

            <?php endif; ?>

            <?php if ($rol === 'admin'): ?>

                <li>
                    <a href="eliminar.php">Eliminar contenido</a>
                </li>

                <li>
                    <a href="usuarios.php">Gestionar usuarios</a>
                </li>

            <?php endif; ?>

            <li>
                <a href="logout.php">Cerrar sesión</a>
            </li>

        </ul>

    </aside>

    <main class="contenido">

        <h1>Bienvenido al panel</h1>

        <?php if (isset($_SESSION['error_acceso'])): ?>
            <div class="error">
                <?= $_SESSION['error_acceso']; ?>
            </div>
            <?php unset($_SESSION['error_acceso']); ?>
        <?php endif; ?>

        <?php if ($rol === 'admin'): ?>
            <div class="mensaje admin">
                Tienes acceso completo al sistema.
            </div>
        <?php elseif ($rol === 'editor'): ?>
            <div class="mensaje editor">
                Puedes crear y editar contenidos.
            </div>
        <?php else: ?>
            <div class="mensaje lector">
                Solo puedes visualizar contenidos.
            </div>
        <?php endif; ?>

        <h2 style="font-size:18px; margin-top:2rem; margin-bottom:1rem; color:var(--text); border:none;">
            Contenidos del sistema
        </h2>

        <?php if (empty($contenidos)): ?>
            <p style="color:var(--muted); font-size:13px;">No hay contenidos aún.</p>
        <?php else: ?>
            <div class="tabla-contenidos">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Cuerpo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contenidos as $c): ?>
                            <tr>
                                <td><?= $c['id']; ?></td>
                                <td><?= htmlspecialchars($c['titulo']); ?></td>
                                <td><?= htmlspecialchars($c['cuerpo']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    </main>

</div>

</body>
</html>
