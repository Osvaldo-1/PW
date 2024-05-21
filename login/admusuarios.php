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

$query = "SELECT * FROM usuario";
$resultado = mysqli_query($conexion, $query);
$usuarios = [];

while ($fila = mysqli_fetch_assoc($resultado)) {
    $usuarios[] = $fila;
}

mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios</title>
    <link rel="stylesheet" href="http://localhost/PW/css/style.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const usuarios = <?php echo json_encode($usuarios); ?>;
            const searchInput = document.getElementById('termino_busqueda');
            const tableBody = document.getElementById('tabla_usuarios_body');

            function mostrarUsuarios(filtrados) {
                tableBody.innerHTML = '';
                filtrados.forEach(usuario => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${usuario.IdUsuario}</td>
                        <td>${usuario.NombreUsuario}</td>
                        <td>${usuario.CorreoUsuario}</td>
                        <td>
                            <select name="nuevo_rol" onchange="actualizarRol(${usuario.IdUsuario}, this.value)">
                                <option value="1" ${usuario.RolIdRol == 1 ? 'selected' : ''}>Admin</option>
                                <option value="2" ${usuario.RolIdRol == 2 ? 'selected' : ''}>Usuario</option>
                            </select>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            window.actualizarRol = function(idUsuario, nuevoRol) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "actualizar_rol.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        if (xhr.responseText.trim() === "Rol actualizado correctamente") {
                            usuarios.forEach(usuario => {
                                if (usuario.IdUsuario == idUsuario) {
                                    usuario.RolIdRol = nuevoRol;
                                }
                            });
                            mostrarUsuarios(usuarios);
                            alert("Rol actualizado correctamente");
                        } else {
                            alert("Error al actualizar el rol del usuario: " + xhr.responseText);
                        }
                    }
                };
                xhr.send("id_usuario=" + idUsuario + "&nuevo_rol=" + nuevoRol);
            };

            searchInput.addEventListener('input', function() {
                const termino = searchInput.value.toLowerCase();
                const filtrados = usuarios.filter(usuario => 
                    usuario.NombreUsuario.toLowerCase().includes(termino) || 
                    usuario.CorreoUsuario.toLowerCase().includes(termino)
                );
                mostrarUsuarios(filtrados);
            });

            mostrarUsuarios(usuarios);
        });
    </script>
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
                    <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="container">
        <h2>Administrar Usuarios</h2>
        <form action="javascript:void(0);">
            <label for="termino_busqueda">Buscar Usuario:</label>
            <input type="text" id="termino_busqueda" name="termino_busqueda">
        </form>
        <h3>Lista de Usuarios</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>IdUsuario</th>
                    <th>NombreUsuario</th>
                    <th>CorreoUsuario</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody id="tabla_usuarios_body">
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