<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$conexion = mysqli_connect("localhost", "root", "", "barber");
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Obtener las fechas y horas ya reservadas
$query = "SELECT FechaCita, HoraCita FROM cita";
$result = mysqli_query($conexion, $query);
$reservations = [];
while ($row = mysqli_fetch_assoc($result)) {
    $reservations[] = $row['FechaCita'] . ' ' . $row['HoraCita'];
}

mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita</title>
    <link rel="stylesheet" href="http://localhost/PW/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">
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
    <h2>Agendar Cita</h2>
    <input type="text" id="datetimepicker" name="appointmentDate" placeholder="Seleccione fecha y hora" />
    <button id="submitAppointment">Agendar</button>
    <form id="appointmentForm" action="select_service.php" method="POST" style="display: none;">
        <input type="hidden" id="date" name="date">
        <input type="hidden" id="time" name="time">
    </form>
</section>
<footer>
    <div class="container">
        <p>&copy; 2024 Barber Shop. Todos los derechos reservados.</p>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
<script>
    $(document).ready(function(){
        $('#datetimepicker').datetimepicker({
            format:'Y-m-d H:i', // Formato de fecha y hora
            step: 30, // Intervalo de minutos
            minDate: 0, // Fecha mínima (hoy)
            allowTimes: ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30'] // Horarios permitidos
        });

        $('#submitAppointment').click(function(){
            var selectedDateTime = $('#datetimepicker').val();
            $('#date').val(selectedDateTime.split(' ')[0]); // Separar la fecha y guardarla en el campo oculto
            $('#time').val(selectedDateTime.split(' ')[1]); // Separar la hora y guardarla en el campo oculto
            // Validación adicional si es necesaria
            
            // Envío del formulario
            $('#appointmentForm').submit();
        });
    });
</script>
</body>
</html>
