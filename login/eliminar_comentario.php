<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 1) {
    echo "Acceso denegado.";
    exit;
}

if (isset($_POST['id_comentario'])) {
    $idUsuario = $_POST['id_comentario']; // Aquí utilizamos el id de usuario como identificador de comentario

    $conexion = mysqli_connect("localhost", "root", "", "barber");
    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    $query = "DELETE FROM comentario WHERE UsuarioIdUsuario = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "i", $idUsuario);

    if (mysqli_stmt_execute($stmt)) {
        echo "Comentario eliminado correctamente";
    } else {
        echo "Error al eliminar el comentario: " . mysqli_error($conexion);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
} else {
    echo "ID de comentario no especificado.";
}
?>