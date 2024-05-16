<?php
session_start();

$usuario_registrado = isset($_SESSION['usuario']) && isset($_SESSION['rol']) && $_SESSION['rol'] == 2;
if (!$usuario_registrado) {
    header("Location: index.php");
    exit;
}

$correo_usuario = $_SESSION['correo'] ?? '';

$nueva_contraseña = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["new_password"])) {
        $nueva_contraseña = $_POST["new_password"];
        
        $conexion = mysqli_connect("localhost", "root", "", "barber");
        
        if (!$conexion) {
            die("Conexión fallida: " . mysqli_connect_error());
        }

        $usuario = $_SESSION['usuario'];
        $hashed_password = password_hash($nueva_contraseña, PASSWORD_DEFAULT);

        $consulta = "UPDATE usuario SET ContrasenaUsuario='$hashed_password' WHERE NombreUsuario='$usuario'";

        if (mysqli_query($conexion, $consulta)) {
            echo "Contraseña actualizada exitosamente.";
        } else {
            echo "Error al actualizar la contraseña: " . mysqli_error($conexion);
        }

        mysqli_close($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta</title>
    <link rel="stylesheet" href="http://localhost/PW/css/cuenta.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="http://localhost/PW/images/logo.png" height="100px" width="100px" alt="Logo">
            </a>
            <div class="navbar-menu">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Galeria.html">Galería</a>
                    </li>
                    <?php if ($usuario_registrado): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="Citas.html">Citas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="coments.html">Comentarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cuenta.php">Cuenta</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="acercade.html">Acerca de Nosotros</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <section class="container">
        <div class="card">
            <div class="card-body">
                <h2>Configuración de la cuenta</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="correo">Correo electrónico:</label>
                        <input type="email" id="correo" name="correo" value="<?php echo $correo_usuario; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="new_password">Nueva contraseña:</label>
                        <input type="password" id="new_password" name="new_password" value="<?php echo $nueva_contraseña; ?>">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Guardar cambios">
                    </div>
                </form>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2024 Barber Shop. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>