<?php
session_start();

if (isset($_POST['usuario']) && isset($_POST['pass'])) {

    $usuario = $_POST['usuario'];
    $pass = $_POST['pass'];


    $conexion = mysqli_connect("localhost", "root", "", "barber");


    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    $consulta = "SELECT * FROM usuario WHERE NombreUsuario = '$usuario' AND ContrasenaUsuario = '$pass'";
    $resultado = mysqli_query($conexion, $consulta);
    $filas = mysqli_num_rows($resultado);

    if ($filas > 0) {
        $_SESSION['usuario'] = $usuario;
        header("Location:home.php");
        exit;
    } else {
        echo "Credenciales incorrectas. <br>";
    }


    mysqli_free_result($resultado);
    mysqli_close($conexion);
} else {
    echo "Todos los campos son obligatorios. <br>";
}
?>