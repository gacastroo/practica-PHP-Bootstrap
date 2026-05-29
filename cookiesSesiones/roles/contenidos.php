<?php
// Inicializa el array de contenidos en sesión si no existe
if (!isset($_SESSION['contenidos'])) {
    $_SESSION['contenidos'] = [
        ['id' => 1, 'titulo' => 'Primer artículo', 'cuerpo' => 'Este es el contenido del primer artículo.'],
        ['id' => 2, 'titulo' => 'Segundo artículo', 'cuerpo' => 'Este es el contenido del segundo artículo.'],
    ];
    $_SESSION['next_id'] = 3;
}
