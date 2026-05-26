<?php
session_start();

unset($_SESSION['historial']);

header('Location: historial.php');
exit;