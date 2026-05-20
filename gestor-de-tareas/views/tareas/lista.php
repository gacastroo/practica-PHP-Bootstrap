<?php
/*
 * views/tareas/lista.php
 *
 * Muestra el listado de tareas del usuario autenticado.
 * El controlador pasa: $tareas (array), $error (string, puede estar vacío)
 */
require "views/layouts/header.php";
?>

<main class="container">

    <h2>Mis tareas</h2>

    <?php if (!empty($error)): ?>
        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (empty($tareas)): ?>
        <p class="sin-tareas">No tienes tareas todavía. ¡Crea la primera!</p>
    <?php else: ?>
        <ul class="lista-tareas">
            <?php foreach ($tareas as $t): ?>
                <li class="tarea <?= $t["completada"] ? "completada" : "" ?>">

                    <span class="tarea-titulo">
                        <?php if ($t["completada"]): ?>
                            <del><?= htmlspecialchars($t["titulo"]) ?></del>
                        <?php else: ?>
                            <?= htmlspecialchars($t["titulo"]) ?>
                        <?php endif; ?>
                    </span>

                    <span class="tarea-actiones">
                        <?php if (!$t["completada"]): ?>
                            <a
                                href="index.php?pagina=tareas&action=completar&id=<?= $t["id"] ?>"
                                class="btn-completar"
                                title="Marcar como completada"
                            >✔</a>
                        <?php endif; ?>

                        <a
                            href="index.php?pagina=tareas&action=eliminar&id=<?= $t["id"] ?>"
                            class="btn-eliminar"
                            title="Eliminar tarea"
                            onclick="return confirm('¿Seguro que quieres eliminar esta tarea?')"
                        >✕</a>
                    </span>

                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a href="index.php?pagina=tareas&action=crear" class="nueva-tarea-link">+ Nueva tarea</a>

</main>

<?php require "views/layouts/footer.php"; ?>
