<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ejercicio 1</title>
</head>
<body>
<?php
    $nombre = "Guillermo";
    $hora = (int) date("H");
        if ($hora >= 0 && $hora < 6) {
            echo "zzzzz";
        }
        else if ($hora >= 6 && $hora < 12) {
            echo "Buenos días, ";
        }
        else if ($hora >= 12 && $hora < 19) {
            echo "Buenas tardes, ";
        }
        else {
            echo "Buenas noches, ";
        }
    echo "mi nombre es $nombre";
?>
    
</body>
</html>