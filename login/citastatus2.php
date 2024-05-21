<?php
session_start();


if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$conexion = mysqli_connect("localhost", "root", "", "barber");
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

$user_id = $_SESSION['usuario'];


$query = "SELECT * FROM cita WHERE UsuarioIdUsuario = ? LIMIT 1"; 
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de la Cita</title>
    <link rel="stylesheet" href="http://localhost/PW/css/style.css">
</head>
<body>
<nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="http://localhost/PW/images/logo.jpg" height="100px" width="100px" alt="Logo">
            </a>
            <div class="navbar-menu">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="home.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="coments.php">Comentarios</a></li>
                    <?php if (isset($_SESSION['usuario']) && isset($_SESSION['rol'])): ?>
                        <li class="nav-item"><a class="nav-link" href="crearcita.php">Citas</a></li>
                        <li class="nav-item"><a class="nav-link" href="citastatus2.php">Estado de cita</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <section class="container">
        <h2>Estado de la Cita</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php $cita = $result->fetch_assoc(); ?>
            <p>Fecha de Cita: <?php echo $cita['FechaCita']; ?></p>
            <p>Hora de Cita: <?php echo $cita['HoraCita']; ?></p>
            <?php

            $estado_id = $cita['EstadoIdEstado'];
            $query_estado = "SELECT Detalle FROM estado WHERE IdEstado = ?";
            $stmt_estado = $conexion->prepare($query_estado);
            $stmt_estado->bind_param("i", $estado_id);
            $stmt_estado->execute();
            $result_estado = $stmt_estado->get_result();
            if ($result_estado->num_rows > 0) {
                $estado = $result_estado->fetch_assoc();
                echo "<p>Estado: " . $estado['Detalle'] . "</p>";
            } else {
                echo "<p>Estado: No disponible</p>";
            }
            ?>
        <?php else: ?>
            <p>No se encontró ninguna cita para este usuario.</p>
        <?php endif; ?>
    </section>
    <footer>
        <div class="container">
            <p>&copy; 2024 Barber Shop. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>