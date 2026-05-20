<?php
require_once "models/Tarea.php";

class TareasController {

    public function listar(): void {
        $sesionActiva  = true;
        $nombreUsuario = $_SESSION["nombre"] ?? $_SESSION["user"];
        $tareas        = Tarea::todas($_SESSION["user"]);
        $error         = $_SESSION["error_tarea"] ?? "";
        unset($_SESSION["error_tarea"]);
        require "views/tareas/lista.php";
    }

    public function crear(): void {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $titulo = trim($_POST["titulo"] ?? "");

            if (strlen($titulo) < 3) {
                $_SESSION["error_tarea"] = "El título debe tener al menos 3 caracteres.";
                header("Location: index.php?pagina=tareas&action=crear");
                exit;
            }

            Tarea::crear($titulo, $_SESSION["user"]);
            header("Location: index.php?pagina=tareas&action=listar");
            exit;
        }

        $sesionActiva  = true;
        $nombreUsuario = $_SESSION["nombre"] ?? $_SESSION["user"];
        $error         = $_SESSION["error_tarea"] ?? "";
        $tituloPrevio  = "";
        unset($_SESSION["error_tarea"]);
        require "views/tareas/formulario.php";
    }

    public function completar(): void {
        $id = isset($_GET["id"]) ? (int)$_GET["id"] : null;
        if ($id) {
            Tarea::completar($id);
        }
        header("Location: index.php?pagina=tareas&action=listar");
        exit;
    }

    public function eliminar(): void {
        $id = isset($_GET["id"]) ? (int)$_GET["id"] : null;
        if ($id) {
            Tarea::eliminar($id);
        }
        header("Location: index.php?pagina=tareas&action=listar");
        exit;
    }
}
