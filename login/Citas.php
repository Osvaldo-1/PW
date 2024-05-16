<?php
session_start();
$usuario_registrado = isset($_SESSION['usuario']) && isset($_SESSION['rol']) && $_SESSION['rol'] == 2;
if (!$usuario_registrado) {

    header("Location: index.html");
    exit;
}
?>