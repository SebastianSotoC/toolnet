<?php
session_start();
include("db/conexionBD.php");
include("dao/carritoDAO.php");
$con = conectar();
include("templates/getUsuario.php");
if ($idUsuario === 0) {
    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
        $logCheck = 1;        
    }else{
        $logCheck = 0;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Login</title>
    <style>
        .login-container {
            margin-top: 150px;
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
            <div class="col-md-4 login-container">
                <h2 class="text-center">Inicio de Sesión</h2>
                <form action="handlers/validarUser.php" method="post" name="formLoginUser">
                    <input type="hidden" name="logCheck" id="logCheck" value="<?php echo $logCheck; ?>">
                    <div class="form-group">
                        <label for="username">Usuario:</label>
                        <input type="email" class="form-control" name="correo" id="correo"
                            placeholder="Ingresa tu Email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="Ingresa tu contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                </form>
                <p class="mt-3 text-center">
                    <a href="../src/Registro.php">Registrarse</a> | <a href="#">¿Olvidaste tu contraseña?</a>
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
} else {
    if ($_SESSION["cuentaRegistrada"]) {
        echo '<script>alert("Cuenta creada exitosamente. Inicia sesion con tus credenciales");</script>';
        $_SESSION["cuentaRegistrada"] = null;
    } else {

    }
}

if (!isset($_SESSION["cuentaLogeada"])) {
    // Si no está definida, inicialízala en 0
    $_SESSION["cuentaLogeada"] = null;

} else {
    if (!$_SESSION["cuentaLogeada"]) {
        echo '<script>alert("Credenciales incorrectas, ingresa nuevamente.");</script>';
        $_SESSION["cuentaLogeada"] = null;
    }
}
?>