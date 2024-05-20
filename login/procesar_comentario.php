<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $conexion = mysqli_connect("localhost", "root", "", "barber");

    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    $consulta_verificar = "SELECT * FROM comentario WHERE UsuarioIdUsuario = '$usuario'";
    $resultado_verificar = mysqli_query($conexion, $consulta_verificar);

    if (mysqli_num_rows($resultado_verificar) > 0) {
        echo "Ya has realizado un comentario anteriormente.";
    } else {
    
        if (isset($_POST['comentario']) && isset($_POST['calificacion'])) {
            $comentario = $_POST['comentario'];
            $calificacion = $_POST['calificacion'];


            $conexion = mysqli_connect("localhost", "root", "", "barber");


            if (!$conexion) {
                die("Error de conexión: " . mysqli_connect_error());
            }

            $consulta = "INSERT INTO comentario (DescripcionComentario, UsuarioIdUsuario, Calificacion) VALUES ('$comentario', '$usuario', '$calificacion')";

            if (mysqli_query($conexion, $consulta)) {
                echo "Comentario publicado exitosamente.";
            } else {
                echo "Error al publicar el comentario: " . mysqli_error($conexion);
            }

            mysqli_close($conexion);
        } else {
            echo "Todos los campos son obligatorios.";
        }
    }

    mysqli_close($conexion);
} else {
    echo "Debe iniciar sesión para publicar un comentario.";
}
?>