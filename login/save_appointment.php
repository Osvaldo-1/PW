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

$date = $_POST['date'];
$time = $_POST['time'];
$user_id = $_POST['user_id'];
$estado_id = 1; 


$query = "INSERT INTO cita (FechaCita, HoraCita, UsuarioIdUsuario, EstadoIdEstado) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($query);
$stmt->bind_param("ssii", $date, $time, $user_id, $estado_id); 


if ($stmt->execute()) {

    header("Location: cita_agendada.php");
    exit; 
} else {

    header("Location: error.php");
    exit; 
}

mysqli_close($conexion);
?>