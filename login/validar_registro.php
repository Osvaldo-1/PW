<?php
session_start();

if (isset($_POST['usuario']) && isset($_POST['correo']) && isset($_POST['pass']) && isset($_POST['rol'])) {
 
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $pass = $_POST['pass'];
    $rol = $_POST['rol'];

 
    $conexion = mysqli_connect("localhost", "root", "", "barber");


    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    $consulta = "SELECT * FROM usuario WHERE NombreUsuario = '$usuario' OR CorreoUsuario = '$correo'";
    $resultado = mysqli_query($conexion, $consulta);
    $filas = mysqli_num_rows($resultado);

    if ($filas > 0) {
        
        echo "El usuario o el correo ya están registrados.";
    } else {
        
        $insertar = "INSERT INTO usuario (NombreUsuario, CorreoUsuario, ContrasenaUsuario, RolIdRol) VALUES ('$usuario', '$correo', '$pass', '$rol')";
        if (mysqli_query($conexion, $insertar)) {
            echo "Registro exitoso.";
            header("Location: login.php"); 
            exit; 
        } else {
            echo "Error: " . $insertar . "<br>" . mysqli_error($conexion);
        }
    }

    mysqli_free_result($resultado);
    mysqli_close($conexion);
} else {
    echo "Todos los campos son obligatorios.";
}
?>