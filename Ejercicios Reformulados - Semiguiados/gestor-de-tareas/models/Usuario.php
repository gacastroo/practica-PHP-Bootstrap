<?php

/**
 * models/Usuario.php
 *
 * Modelo de usuario. Almacena los usuarios en un array estático.
 * En UF1845 esto se sustituirá por consultas a base de datos.
 */
class Usuario {

    private static array $usuarios = [
        [
            "usuario" => "admin",
            "clave"   => "1234",
            "nombre"  => "Admin"
        ],
        [
            "usuario" => "juan",
            "clave"   => "abcd",
            "nombre"  => "Juan Pérez"
        ]
    ];

    /**
     * Valida las credenciales de un usuario.
     *
     * @param string $usuario  Nombre de usuario introducido en el formulario.
     * @param string $clave    Contraseña introducida en el formulario.
     * @return array|null      El array del usuario si las credenciales son correctas,
     *                         null si no coinciden.
     */
    public static function validar(string $usuario, string $clave): ?array {
        foreach (self::$usuarios as $u) {
            if ($u["usuario"] === $usuario && $u["clave"] === $clave) {
                return $u;
            }
        }
        return null;
    }
    

    /**
     * Devuelve todos los usuarios (sin la clave).
     * Útil para listados de administración.
     *
     * @return array
     */
    public static function todos(): array {
        return array_map(function ($u) {
            return [
                "usuario" => $u["usuario"],
                "nombre"  => $u["nombre"]
            ];
        }, self::$usuarios);
    }
    
}
