<?php


$conexion = mysqli_connect("localhost", "root", "", "barber");
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}


$usuario_id = $_SESSION['usuario'];
$consulta = "SELECT c.UsuarioIdUsuario, c.DescripcionComentario as comentario, c.Calificacion, u.NombreUsuario
             FROM comentario c 
             JOIN usuario u ON c.UsuarioIdUsuario = u.IdUsuario
             WHERE c.UsuarioIdUsuario = '$usuario_id'";
$resultado = mysqli_query($conexion, $consulta);

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
    <header>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="http://localhost/PW/images/logo.jpg" height="100px" width="100px" alt="Logo">
            </a>
            <div class="navbar-menu">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="home.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="Galeria.html">Galería</a></li>
                    <li class="nav-item"><a class="nav-link" href="coments.php">Comentarios</a></li>
                    <?php
                    session_start();
                    $usuario_registrado = isset($_SESSION['usuario']) && isset($_SESSION['rol']);
                    if (!$usuario_registrado): ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>
                    <?php endif; ?>
                    <?php if ($usuario_registrado): ?>
                        <li class="nav-item"><a class="nav-link" href="appointment_form.php">Citas</a></li>
                        <li class="nav-item"><a class="nav-link" href="cuenta.php">Cuenta</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="acercade.html">Acerca de Nosotros</a></li>
                </ul>
            </div>
        </div>
    </nav>
    </header>
    <section class="container">
    

    
    <section class="comentarios" id="comentarios">
            <div class="container">
                <h2>Comentarios</h2>
                <div class="comment">
                    <p>Este es un comentario de ejemplo 1.</p>
                </div>
                <div class="comment">
                    <p>Este es un comentario de ejemplo 2.</p>
                </div>
                <!-- Aquí puedes añadir más comentarios -->
            </div>
        </section>
        
        <?php if ($usuario_registrado): ?>
        <section class="publicar-comentario">
            <div class="container">
                <h2>Publicar un Comentario</h2>
                <form method="post" action="procesar_comentario.php">
                    <div class="input-container">
                        <label for="comentario">Comentario</label>
                        <textarea name="comentario" id="comentario" required></textarea>
                    </div>
                    <div class="input-container">
                        <label for="calificacion">Calificación</label>
                        <select name="calificacion" id="calificacion" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="input-container">
                        <input type="submit" value="Publicar Comentario">
                    </div>
                </form>
            </div>
        </section>
        <?php endif; ?>
    </section>
    
    <button id="toggle-comments">Ver Comentarios</button>
        
        <section class="comentarios" id="comentarios">
            <div class="container">
                <h2>Comentarios</h2>
                <div class="comment">
                    <p>Este es un comentario de ejemplo 1.</p>
                </div>
                <div class="comment">
                    <p>Este es un comentario de ejemplo 2.</p>
                </div>
                
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