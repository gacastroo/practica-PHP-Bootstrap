<?php

/**
 * models/Tarea.php
 *
 * Modelo de tarea. Almacena los datos en $_SESSION["tareas"]
 * para que persistan entre peticiones (sin base de datos).
 * En UF1845 esto se sustituirá por consultas a base de datos.
 */
class Tarea {

    /**
     * Inicializa el almacén de tareas en sesión si no existe.
     */
    private static function inicializar(): void {
        if (!isset($_SESSION["tareas"])) {
            $_SESSION["tareas"] = [];
        }
    }

    /**
     * Devuelve todas las tareas de un usuario concreto.
     */
    public static function todas(string $usuario): array {
        self::inicializar();
        return array_values(array_filter($_SESSION["tareas"], function ($t) use ($usuario) {
            return $t["usuario"] === $usuario;
        }));
    }

    /**
     * Crea una nueva tarea y la guarda en sesión.
     */
    public static function crear(string $titulo, string $usuario): void {
        self::inicializar();

        // ID único basado en el máximo existente para evitar colisiones tras eliminar
        $ids = array_column($_SESSION["tareas"], "id");
        $nuevoId = empty($ids) ? 1 : max($ids) + 1;

        $_SESSION["tareas"][] = [
            "id"         => $nuevoId,
            "titulo"     => $titulo,
            "usuario"    => $usuario,
            "completada" => false
        ];
    }

    /**
     * Marca una tarea como completada.
     */
    public static function completar(int $id): bool {
        self::inicializar();
        foreach ($_SESSION["tareas"] as &$t) {
            if ($t["id"] === $id) {
                $t["completada"] = true;
                return true;
            }
        }
        return false;
    }

    /**
     * Elimina una tarea.
     */
    public static function eliminar(int $id): bool {
        self::inicializar();
        foreach ($_SESSION["tareas"] as $i => $t) {
            if ($t["id"] === $id) {
                unset($_SESSION["tareas"][$i]);
                $_SESSION["tareas"] = array_values($_SESSION["tareas"]);
                return true;
            }
        }
        return false;
    }
}
