<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 1) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['id_cita']) && isset($_POST['nuevo_estado'])) {
    $id_cita = $_POST['id_cita'];
    $nuevo_estado = $_POST['nuevo_estado'];

    $conexion = mysqli_connect("localhost", "root", "", "barber");
    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    $query = "UPDATE cita SET EstadoIdEstado = ? WHERE IdCita = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "ii", $nuevo_estado, $id_cita);

    if (mysqli_stmt_execute($stmt)) {
        echo "Estado actualizado correctamente";
    } else {
        echo "Error al actualizar el estado de la cita.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
} else {
    echo "Datos incompletos.";
}
?>