<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 1) {
    header("Location: login.php");
    exit;
}

$conexion = mysqli_connect("localhost", "root", "", "barber");
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

$query = "SELECT * FROM comentario";
$resultado = mysqli_query($conexion, $query);
$comentarios = [];

while ($fila = mysqli_fetch_assoc($resultado)) {
    $comentarios[] = $fila;
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Comentarios</title>
    <link rel="stylesheet" href="http://localhost/PW/css/style.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const comentarios = <?php echo json_encode($comentarios); ?>;
            const tableBody = document.getElementById('tabla_comentarios_body');

            function mostrarComentarios() {
                tableBody.innerHTML = '';
                comentarios.forEach(comentario => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${comentario.DescripcionComentario}</td>
                        <td>${comentario.UsuarioIdUsuario}</td>
                        <td>${comentario.Calificacion}</td>
                        <td>
                            <button onclick="eliminarComentario(${comentario.UsuarioIdUsuario})">Eliminar</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            window.eliminarComentario = function(idUsuario) {
                if (confirm("¿Estás seguro de eliminar este comentario?")) {
                    const xhr = new XMLHttpRequest();
                    xhr.open("POST", "eliminar_comentario.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            if (xhr.responseText.trim() === "Comentario eliminado correctamente") {
                                const index = comentarios.findIndex(comentario => comentario.UsuarioIdUsuario === idUsuario);
                                if (index !== -1) {
                                    comentarios.splice(index, 1);
                                    mostrarComentarios();
                                    alert("Comentario eliminado correctamente");
                                }
                            } else {
                                alert("Error al eliminar el comentario: " + xhr.responseText);
                            }
                        }
                    };
                    xhr.send(`id_comentario=${idUsuario}`);
                }
            };

            mostrarComentarios();
        });
    </script>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="http://localhost/PW/images/logo.jpg" height="100px" width="100px" alt="Logo">
            </a>
            <div class="navbar-menu">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="homeadmin.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="admusuarios.php">Administrar Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="admcita.php">Administrar Citas</a></li>
                    <li class="nav-item"><a class="nav-link" href="admcomentario.php">Administrar Comentarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="container">
        <h2>Administrar Comentarios</h2>
        <table>
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>ID Usuario</th>
                    <th>Calificación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla_comentarios_body">

            </tbody>
        </table>
    </section>
    <footer>
        <div class="container">
            <p>&copy; 2024 Barber Shop. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
