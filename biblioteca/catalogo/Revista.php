<?php
require_once "Libro.php";

class Revista extends Libro {

    private int $numEjemplar;

    public function __construct(
        string $isbn,
        string $titulo,
        string $autor,
        int $anio,
        int $paginas,
        int $numEjemplar
    ) {
        parent::__construct($isbn, $titulo, $autor, $anio, $paginas);
        $this->numEjemplar = $numEjemplar;
    }

    public function getNumEjemplar(): int {
        return $this->numEjemplar;
    }
}