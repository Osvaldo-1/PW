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

$query = "SELECT * FROM cita";
$resultado = mysqli_query($conexion, $query);
$citas = [];

while ($fila = mysqli_fetch_assoc($resultado)) {
    $citas[] = $fila;
}

mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Citas</title>
    <link rel="stylesheet" href="http://localhost/PW/css/style.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const citas = <?php echo json_encode($citas); ?>;
            const searchInput = document.getElementById('termino_busqueda');
            const tableBody = document.getElementById('tabla_citas_body');

            function mostrarCitas(filtradas) {
                tableBody.innerHTML = '';
                filtradas.forEach(cita => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${cita.IdCita}</td>
                        <td>${cita.FechaCita}</td>
                        <td>${cita.HoraCita}</td>
                        <td>${cita.UsuarioIdUsuario}</td>
                        <td>
                            <select name="nuevo_estado" onchange="actualizarEstado(${cita.IdCita}, this.value)">
                                <option value="1" ${cita.EstadoIdEstado == 1 ? 'selected' : ''}>Pendiente</option>
                                <option value="2" ${cita.EstadoIdEstado == 2 ? 'selected' : ''}>Aceptado</option>
                                <option value="3" ${cita.EstadoIdEstado == 3 ? 'selected' : ''}>Rechazado</option>
                            </select>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            window.actualizarEstado = function(idCita, nuevoEstado) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "actualiza_cita.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        if (xhr.responseText.trim() === "Estado actualizado correctamente") {
                            citas.forEach(cita => {
                                if (cita.IdCita == idCita) {
                                    cita.EstadoIdEstado = nuevoEstado;
                                }
                            });
                            mostrarCitas(citas);
                            alert("Estado actualizado correctamente");
                        } else {
                            alert("Error al actualizar el estado de la cita: " + xhr.responseText);
                        }
                    }
                };
                xhr.send("id_cita=" + idCita + "&nuevo_estado=" + nuevoEstado);
            };

            searchInput.addEventListener('input', function() {
                const termino = searchInput.value.toLowerCase();
                const filtradas = citas.filter(cita => 
                    cita.IdCita.toString().includes(termino) || 
                    cita.FechaCita.toLowerCase().includes(termino) || 
                    cita.HoraCita.toLowerCase().includes(termino) || 
                    cita.UsuarioIdUsuario.toString().includes(termino)
                );
                mostrarCitas(filtradas);
            });

            mostrarCitas(citas);
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
        <h2>Administrar Citas</h2>
        <form action="javascript:void(0);">
            <label for="termino_busqueda">Buscar Cita:</label>
            <input type="text" id="termino_busqueda" name="termino_busqueda">
        </form>
        <h3>Lista de Citas</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>IdCita</th>
                    <th>FechaCita</th>
                    <th>HoraCita</th>
                    <th>UsuarioIdUsuario</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody id="tabla_citas_body">

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