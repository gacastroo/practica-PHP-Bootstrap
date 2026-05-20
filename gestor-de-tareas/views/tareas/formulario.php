<?php
require "views/layouts/header.php";
?>

<main class="container">

    <h2>Nueva tarea</h2>

    <?php if (!empty($error)): ?>
        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?pagina=tareas&action=crear">

        <label for="titulo">Título de la tarea</label>
        <input
            type="text"
            id="titulo"
            name="titulo"
            placeholder="Mínimo 3 caracteres"
            value="<?= htmlspecialchars($_POST["titulo"] ?? "") ?>"
        >

        <button type="submit">Crear tarea</button>

        <a id="btn-cancelar" href="index.php?pagina=tareas&action=listar">Cancelar</a>

    </form>

</main>

<?php require "views/layouts/footer.php"; ?>
