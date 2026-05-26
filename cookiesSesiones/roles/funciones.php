<?php
    function requireRol(array $roles_permitidos): void
    {
        session_start();

        // Verifica si el usuario ha iniciado sesión
        if (!isset($_SESSION['login'])) {
            header('Location: login.php');
            exit;
        }

        // Verifica si el rol del usuario está permitido
        if (!in_array($_SESSION['rol'], $roles_permitidos)) {
            $_SESSION['error_acceso'] = 'No tienes permiso para acceder a esta sección.';

            header('Location: panel.php');
            exit;
        }
    }

    