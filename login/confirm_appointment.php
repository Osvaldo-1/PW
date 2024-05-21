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

$date = $_POST['date'];
$time = $_POST['time'];
$service_id = $_POST['service'];

$query = "SELECT * FROM servicio WHERE IdServicio = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $service_id);
$stmt->execute();
$result = $stmt->get_result();
$service = $result->fetch_assoc();

mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Cita</title>
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
                        <li class="nav-item"><a class="nav-link" href="cuenta.php">Cuenta</a></li>
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
        <h2>Confirmar Cita</h2>
        <form action="save_appointment.php" method="POST">
            <input type="hidden" name="date" value="<?php echo htmlspecialchars($date); ?>">
            <input type="hidden" name="time" value="<?php echo htmlspecialchars($time); ?>">
            <input type="hidden" name="service_id" value="<?php echo htmlspecialchars($service['IdServicio']); ?>">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['usuario']; ?>">
            <p><strong>Fecha:</strong> <?php echo htmlspecialchars(date('d-m-Y', strtotime($date))); ?></p>
            <p><strong>Hora:</strong> <?php echo htmlspecialchars($time); ?></p>
            <p><strong>Servicio:</strong> <?php echo htmlspecialchars($service['Descripcion']); ?></p>
            <p><strong>Precio:</strong> $<?php echo htmlspecialchars($service['PrecioProducto']); ?></p>
            <button type="submit">Confirmar Cita</button>
        </form>
    </section>
    <footer>
        <div class="container">
            <p>&copy; 2024 Barber Shop. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>