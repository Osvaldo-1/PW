<?php
session_start();


if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$date = $_POST['date'] ?? ''; 
$time = $_POST['time'] ?? '';

$conexion = mysqli_connect("localhost", "root", "", "barber");
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

$query = "SELECT * FROM servicio";
$result = mysqli_query($conexion, $query);

mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Servicio</title>
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
        <h2>Seleccionar Servicio</h2>
        <form action="confirm_appointment.php" method="POST">
            <input type="hidden" name="date" value="<?php echo htmlspecialchars($date); ?>">
            <input type="hidden" name="time" value="<?php echo htmlspecialchars($time); ?>">
            <label for="service">Seleccione un servicio:</label>
            <select name="service" id="service" required>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <option value="<?php echo $row['IdServicio']; ?>" data-price="<?php echo $row['PrecioProducto']; ?>">
                        <?php echo htmlspecialchars($row['Descripcion']); ?> - $<?php echo $row['PrecioProducto']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Siguiente</button>
        </form>
    </section>
    <footer>
        <div class="container">
            <p>&copy; 2024 Barber Shop. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>