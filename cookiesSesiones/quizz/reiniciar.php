<?php
session_start();

unset($_SESSION['rondas']);
unset($_SESSION['indices_ronda']);

header("Location: resultado.php");
exit;