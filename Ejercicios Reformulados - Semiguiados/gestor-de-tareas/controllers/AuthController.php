<?php
require_once "models/Usuario.php";

class AuthController {

    public function loginForm(): void {
        $error         = "";
        $usuarioPrevio = "";
        require "views/auth/login.php";
    }

    public function login(): void {
        $usuario = trim($_POST["usuario"] ?? "");
        $clave   = trim($_POST["clave"]   ?? "");
        $error   = "";

        if (empty($usuario) || empty($clave)) {
            $error         = "Todos los campos son obligatorios.";
            $usuarioPrevio = htmlspecialchars($usuario);
            require "views/auth/login.php";
            return;
        }

        $usuarioEncontrado = Usuario::validar($usuario, $clave);

        if ($usuarioEncontrado !== null) {
            session_regenerate_id(true);
            $_SESSION["login"]  = true;
            $_SESSION["user"]   = $usuarioEncontrado["usuario"];
            $_SESSION["nombre"] = $usuarioEncontrado["nombre"];

            header("Location: index.php?pagina=tareas&action=listar");
            exit;
        }

        $error         = "Usuario o contraseña incorrectos.";
        $usuarioPrevio = htmlspecialchars($usuario);
        require "views/auth/login.php";
    }

    public function logout(): void {
        $_SESSION = [];
        session_destroy();

        header("Location: index.php?pagina=auth&action=loginForm");
        exit;
    }
}
