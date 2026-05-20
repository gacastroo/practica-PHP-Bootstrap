<?php
require_once "Catalogable.php";

class Libro implements Catalogable {

    private string $isbn;
    private string $titulo;
    private string $autor;
    private int $anio;
    private int $paginas;
    private bool $disponible;

    public function __construct(string $isbn, string $titulo, string $autor, int $anio, int $paginas) {
        $this->isbn = $isbn;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->anio = $anio;
        $this->paginas = $paginas;
        $this->disponible = true;
    }

    public function prestar(): void {
        $this->disponible = false;
    }

    public function devolver(): void {
        $this->disponible = true;
    }

    public function getInfo(): string {
        return "{$this->titulo} - {$this->autor} ({$this->anio})";
    }

    public function getCodigo(): string {
        return $this->isbn;
    }

    public function getDescripcion(): string {
        return $this->getInfo();
    }

    // Getters útiles para la tabla
    public function getTitulo(): string {
        return $this->titulo;
    }

    public function getAutor(): string {
        return $this->autor;
    }

    public function getAnio(): int {
        return $this->anio;
    }

    public function getPaginas(): int {
        return $this->paginas;
    }

    public function estaDisponible(): bool {
        return $this->disponible;
    }
}