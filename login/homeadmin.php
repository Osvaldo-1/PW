<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 1) {
    header("Location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz de Administrador</title>
    <link rel="stylesheet" href="http://localhost/PW/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="http://localhost/PW/images/logo.png" height="100px" width="100px" alt="Logo">
            </a>
            <div class="navbar-menu">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="homeadmin.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="admusuarios.php">Administrar Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="admcita.php">Administrar Citas</a></li>
                    <li class="nav-item"><a class="nav-link" href="admcomentario.php">Administrar Comentarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="cuenta.php">Cuenta</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Interfaz de Administrador</h1>
    </div>
</body>
</html>