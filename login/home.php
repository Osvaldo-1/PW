<?php
session_start();
$usuario_registrado = isset($_SESSION['usuario']) && isset($_SESSION['rol']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barber Shop</title>
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
                    <?php if (!$usuario_registrado): ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>
                    <?php endif; ?>
                    <?php if ($usuario_registrado): ?>
                        <li class="nav-item"><a class="nav-link" href="coments.php">Comentarios</a></li>
                        <li class="nav-item"><a class="nav-link" href="crearcita.php">Citas</a></li>
                        <li class="nav-item"><a class="nav-link" href="citastatus2.php">Estado de cita</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <section class="container">
        <section class="servicios">
            <div class="container">
                <h2>Nuestros Servicios</h2>
                <div class="row">
                    <div class="card-container">
                        <div class="card">
                            <img src="http://localhost/PW/images/haircut1.jpg" class="card-img" alt="Foto1">
                            <div class="card-body">
                                <h5 class="card-title">High fade</h5>
                                <p class="card-text">Este estilo implica una transición abrupta desde la parte superior del cabello hasta los lados, comenzando justo debajo de la línea del cabello natural. Los lados se cortan muy cortos o incluso se afeitan completamente, creando un contraste llamativo y moderno.</p>
                            </div>
                        </div>
                        <div class="card">
                            <img src="http://localhost/PW/images/haircut2.jpg" class="card-img" alt="Foto2">
                            <div class="card-body">
                                <h5 class="card-title">Mid fade</h5>
                                <p class="card-text">Este estilo de corte de cabello se caracteriza por una transición suave y equilibrada entre las longitudes de cabello corto en los lados y la parte superior de la cabeza. La transición comienza típicamente en la mitad de la cabeza, justo por encima de las orejas, creando un aspecto bien definido y limpio.</p>
                            </div>
                        </div>
                        <div class="card">
                            <img src="http://localhost/PW/images/haircut3.jpg" class="card-img" alt="Foto3">
                            <div class="card-body">
                                <h5 class="card-title">Low fade</h5>
                                <p class="card-text">El "low fade" presenta una transición más suave y discreta desde la parte superior hasta los lados, comenzando cerca de la línea del cabello natural o ligeramente más abajo. Este estilo ofrece un aspecto más suave y menos marcado, ideal para aquellos que prefieren un acabado más natural.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <?php if ($usuario_registrado): ?>
        <section class="comentarios">
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
    <footer>
        <div class="container">
            <p>&copy; 2024 Barber Shop. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>