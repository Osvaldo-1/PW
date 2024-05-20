<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Cita</title>
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
                    <li class="nav-item"><a class="nav-link" href="home.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="Galeria.html">Galería</a></li>
                    <li class="nav-item"><a class="nav-link" href="comentarios.php">Comentarios</a></li>
                    <?php if (isset($_SESSION['usuario']) && isset($_SESSION['rol'])): ?>
                        <li class="nav-item"><a class="nav-link" href="appointment_form.php">Citas</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="acercade.html">Acerca de Nosotros</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="container">
        <h2>Confirmación de Cita</h2>
        <p>Tu cita ha sido agendada con éxito.</p>
        <a href="home.php">Volver al Inicio</a>
    </section>
    <footer>
        <div class="container">
            <p>&copy; 2024 Barber Shop. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>