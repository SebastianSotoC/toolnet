
<?php 
session_start();
include("db/conexionBD.php");
include("dao/carritoDAO.php");
$con = conectar();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Registro</title>
    <style>
        .register-container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <?php 
    include("templates/navbar.php");
    mysqli_close($con);
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 register-container">
                <h2 class="text-center">Registra tu cuenta</h2>
                <br>
                <form action="handlers/registrarUser.php" method = "post" name="formRegistroUser" onsubmit="return validarFormulario();"> <!--se llama a la base de datos y se registra al usuario -->
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa tu nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Ingresa tu apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo Electrónico:</label>
                        <input type="email" class="form-control" name="correo" id="correo" placeholder="Ingresa tu correo electrónico" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Ingresa tu contraseña" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirmar Contraseña:</label>
                        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirma tu contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                </form>
                <script>//confirmar contrasenia
                    function validarFormulario() {
                    var password = document.getElementById("password").value;
                    var confirmPassword = document.getElementById("confirmPassword").value;

                    if (password !== confirmPassword) {
                        alert("Las contraseñas no coinciden.");
                        return false;
                    }
                    return true;
                    }           
                </script>
                <p class="mt-3 text-center">
                    ¿Ya tienes una cuenta? <a href="login.php">Iniciar Sesión</a>
                </p>
            </div>
        </div>
    </div>
    <?php include("templates/footer.php"); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>  
</body>
</html>
<?php
if (!isset($_SESSION["cuentaRegistrada"])) {
    // Si no está definida, inicialízala en 0
    $_SESSION["cuentaRegistrada"] = null;
}else{
    if(!$_SESSION["cuentaRegistrada"]){
        echo '<script>alert("La cuenta ya existe. Inténtalo de nuevo con otro correo.");</script>';
        $_SESSION["cuentaRegistrada"] = null;
    }
}
?>