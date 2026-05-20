<?php
require_once "Libro.php";

class Biblioteca {

    private array $catalogo = [];

    public function agregarLibro(Libro $libro): void {
        $this->catalogo[] = $libro;
    }

    public function buscarPorAutor(string $autor): array {
        return array_filter($this->catalogo, function ($libro) use ($autor) {
            return str_contains(strtolower($libro->getAutor()), strtolower($autor));
        });
    }

    public function buscarPorTitulo(string $titulo): array {
        return array_filter($this->catalogo, function ($libro) use ($titulo) {
            return stripos($libro->getTitulo(), $titulo) !== false;
        });
    }

    public function listarDisponibles(): array {
        return array_filter($this->catalogo, function ($libro) {
            return $libro->estaDisponible();
        });
    }

    public function getCatalogo(): array {
        return $this->catalogo;
    }
}