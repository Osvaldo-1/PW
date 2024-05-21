<?php
if (!isset($_SESSION)) {
    session_start();
}

$conexion = mysqli_connect("localhost", "root", "", "barber");
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

if (isset($_SESSION['usuario'])) {
    $usuario_id = $_SESSION['usuario'];
    $consulta = "SELECT c.UsuarioIdUsuario, c.DescripcionComentario as comentario, c.Calificacion, u.NombreUsuario
                 FROM comentario c 
                 JOIN usuario u ON c.UsuarioIdUsuario = u.IdUsuario
                 WHERE c.UsuarioIdUsuario = '$usuario_id'";
    $resultado = mysqli_query($conexion, $consulta);
} else {

    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios</title>
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
                    <?php
                    $usuario_registrado = isset($_SESSION['usuario']) && isset($_SESSION['rol']);
                    if (!$usuario_registrado): ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>
                    <?php endif; ?>
                    <?php if ($usuario_registrado): ?>
                        <li class="nav-item"><a class="nav-link" href="crearcita.php">Citas</a></li>
                        <li class="nav-item"><a class="nav-link" href="citastatus2.php">Estado de cita</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <section class="container">
        <h2>Comentarios Publicados</h2>
        <div class="comments-list">
            <?php
            $consulta = "SELECT c.DescripcionComentario, c.Calificacion, u.NombreUsuario
                         FROM comentario c 
                         JOIN usuario u ON c.UsuarioIdUsuario = u.IdUsuario";
            $resultado = mysqli_query($conexion, $consulta);
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<div class='comment'>";
                    echo "<h4>" . htmlspecialchars($fila['NombreUsuario']) . "</h4>";
                    echo "<p>" . htmlspecialchars($fila['DescripcionComentario']) . "</p>";
                    echo "<small>Calificación: " . $fila['Calificacion'] . " estrellas</small><br>";
                }
            } else {
                echo "<p>No hay comentarios.</p>";
            }

            mysqli_close($conexion);
            ?>
        </div>
    </section>
    <footer>
        <div class="container">
            <p>&copy; 2024 Barber Shop. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="index.js"></script>
</body>
</html>