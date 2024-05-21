<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 1) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['id_usuario']) && isset($_POST['nuevo_rol'])) {
    $id_usuario = $_POST['id_usuario'];
    $nuevo_rol = $_POST['nuevo_rol'];

    $conexion = mysqli_connect("localhost", "root", "", "barber");
    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    $query = "UPDATE usuario SET RolIdRol = ? WHERE IdUsuario = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "ii", $nuevo_rol, $id_usuario);

    if (mysqli_stmt_execute($stmt)) {
        echo "Rol actualizado correctamente";
    } else {
        echo "Error al actualizar el rol del usuario.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
} else {
    echo "Datos incompletos.";
}
?>