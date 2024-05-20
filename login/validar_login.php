<?php
session_start();

if (isset($_POST['usuario']) && isset($_POST['pass'])) {
    $usuario = trim($_POST['usuario']);
    $pass = trim($_POST['pass']);

    $conexion = new mysqli("localhost", "root", "", "barber");

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    $stmt = $conexion->prepare("SELECT IdUsuario, RolIdRol, ContrasenaUsuario FROM usuario WHERE NombreUsuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($idUsuario, $rolIdRol, $storedPass);
        $stmt->fetch();

        if ($pass === $storedPass) {
            $_SESSION['usuario'] = $idUsuario;
            $_SESSION['rol'] = $rolIdRol;

            if ($rolIdRol == 1) {
                header("Location: homeadmin.php");
                exit;
            } else if ($rolIdRol == 2) {
                header("Location: home.php");
                exit;
            } else {
                echo "Rol de usuario no válido. <br>";
            }
        } else {
            echo "Credenciales incorrectas. <br>";
        }
    } else {
        echo "Credenciales incorrectas. <br>";
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "Todos los campos son obligatorios. <br>";
}
?>