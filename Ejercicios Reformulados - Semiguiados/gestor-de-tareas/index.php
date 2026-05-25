<?php
session_start();

require_once "controllers/TareasController.php";
require_once "controllers/AuthController.php";

$pagina = $_GET["pagina"] ?? "tareas";
$action = $_GET["action"] ?? "listar";

if ($pagina !== "auth") {
    if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
        header("Location: index.php?pagina=auth&action=loginForm");
        exit;
    }
}

switch ($pagina) {

    case "tareas":
        $ctrl = new TareasController();
        $ctrl->$action();
        break;

    case "auth":
        $ctrl = new AuthController();
        $ctrl->$action();
        break;

    default:
        http_response_code(404);
        echo "Página no encontrada";
}