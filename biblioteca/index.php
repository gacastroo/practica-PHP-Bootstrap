<?php
require_once "catalogo/Biblioteca.php";
require_once "catalogo/Libro.php";
require_once "catalogo/Revista.php";

// Crear biblioteca
$biblioteca = new Biblioteca();

// Crear 5 libros
$libro1 = new Libro("111", "Don Quijote", "Miguel de Cervantes", 1605, 863);
$libro2 = new Libro("222", "La Sombra del Viento", "Carlos Ruiz Zafón", 2001, 565);
$libro3 = new Libro("333", "Cien Años de Soledad", "Gabriel García Márquez", 1967, 471);
$libro4 = new Libro("444", "El Principito", "Antoine de Saint-Exupéry", 1943, 96);
$libro5 = new Libro("555", "1984", "George Orwell", 1949, 328);

// Crear 1 revista
$revista = new Revista("666", "National Geographic", "Varios Autores", 2024, 120, 15);

// Agregar al catálogo
$biblioteca->agregarLibro($libro1);
$biblioteca->agregarLibro($libro2);
$biblioteca->agregarLibro($libro3);
$biblioteca->agregarLibro($libro4);
$biblioteca->agregarLibro($libro5);
$biblioteca->agregarLibro($revista);

// Función para mostrar tabla
function mostrarTabla(array $libros): void {
    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr>
            <th>Código</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Año</th>
            <th>Páginas</th>
            <th>Disponible</th>
          </tr>";

    foreach ($libros as $libro) {
        $disponible = $libro->estaDisponible() ? "Sí" : "No";
        echo "<tr>
                <td>{$libro->getCodigo()}</td>
                <td>{$libro->getTitulo()}</td>
                <td>{$libro->getAutor()}</td>
                <td>{$libro->getAnio()}</td>
                <td>{$libro->getPaginas()}</td>
                <td>{$disponible}</td>
              </tr>";
    }

    echo "</table><br>";
}

// 1. Mostrar catálogo completo (todos disponibles)
echo "<h2>Catálogo completo</h2>";
mostrarTabla($biblioteca->getCatalogo());

// 2. Simular préstamo de 2 libros
$libro1->prestar();
$libro2->prestar();

// 3. Mostrar solo los disponibles tras el préstamo
echo "<h2>Libros disponibles después del préstamo</h2>";

mostrarTabla($biblioteca->listarDisponibles());
echo str_repeat('-', 120) . "<br>";
echo str_repeat('-', 120) . "<br>";
echo str_repeat('-', 120) . "<br><br>";
mostrarTabla($biblioteca->getCatalogo());
