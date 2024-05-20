<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="http://localhost/PW/css/loginestilo.css">
</head>
<body>
    <form action="validar_login.php" method="post">
        <div class="container">
            <div class="form-container">
                <h2>Inicio de Sesión</h2>

                <div class="input-container">
                    <input type="text" placeholder="Usuario" name="usuario" required>
                </div>

                <div class="input-container">
                    <input type="password" placeholder="Contraseña" name="pass" required>
                </div>

                <div class="input-container">
                    <input type="submit" value="Iniciar Sesión">
                </div>
            </div>
        </div>
    </form>
</body>
</html>