<?php
session_start();
$idProducto = "";
$nombreProducto = "";
$precioProducto = "";
$totalCarrito = 0;
include("templates/getUsuario.php");
include("db/conexionBD.php");
//include("handlers/handlerProductoCarrito.php");
include("dao/productoCarritoDAO.php");
//include("handlers/handlerCarrito.php");      
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>Carro de Compras</title>
</head>

<body>
    <?php include("templates/navbar.php"); ?>
    <div class="container mt-4" style="max-width: 90%">
        <h2>Carrito de Compras</h2>
        <br>
        <table class="table">
            <thead>
                <!-- SE OBTIENE INFO DE LOS PRODUCTOS -->
                <?php
                if ($idUsuario === 0) {
                    //MUESTRA EL CARRITO TEMPORAL CUANDO EL USUARIO NO ESTA LOGEADO
                    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                        $arProductosCarritoTemporal = $_SESSION['carrito'];
                        $cantProductoEspecifico = 0;
                        foreach ($arProductosCarritoTemporal as $productoCarrito) {
                            $precioProductoFormat = number_format($productoCarrito["precioProducto"], 0, ',', '.');
                            $cantProductoEspecifico = $producto["cantProductoEspecifico"];
                            echo '<tr>';
                                echo '<div class="row" style="max-width: 100%;">';
                                // Contenedor del producto
                                echo '<div class="col-md-9">';
                                echo '<div class="card" style="width: 100%; margin-bottom: 50px; position: relative;">';
                                echo '<div class="d-flex align-items-center">';
                                echo '<div class="d-flex flex-column align-items-center" style="width: 5%; margin-left: 2%;">';
                                echo '<button class="btn btn-outline-secondary" type="button" id="sumarBtn" style="width: 40px">+</button>';
                                // Aumenté el ancho del input
                                echo '<input type="text" class="form-control" id="cantProducto" name="cantProducto" value="' . $cantProductoEspecifico . '" readonly style="width: 40px; text-align: center;">';
                                echo '<button class="btn btn-outline-secondary" type="button" id="restarBtn" style="width: 40px">-</button>';
                                echo '</div>';
                                // Otros detalles del producto (nombre, precio, etc.)
                                echo '<img src="' . $productoCarrito["imagenProducto"] . '" class="card-img-top" alt="' . $productoCarrito["nombreProducto"] . '" style="max-width: 17%; object-fit: cover; margin-left: 4%;">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title"><strong>' . $productoCarrito["nombreProducto"] . '</strong></h5>';
                                echo '<p class="card-text">Precio: $' . $precioProductoFormat . '</p>';
                                echo '</div>';
                                // Botón de borrar producto completamente centrado verticalmente
                                echo '<a class="btn btn-danger align-self-center position-absolute translate-middle" style="right: 0; margin-right: 3%" href="handlers/borrarProducto.php?idProd=' . $productoCarrito["idProducto"] . '"><i class="fas fa-trash"></i></a>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            echo '</tr>';

                            /*
                            echo '<div class="col-md-3">';
                                echo '<div class="card" style="width: 100%;">';
                                // ... Código de subtotal, total y botón aquí
                               
                                   
                                
                                echo '</div>';
                                echo '</div>';
                            */

                            /*
                            echo '<tr>';
                            echo '<td><img src="'.$productoCarrito["imagenProducto"].'" alt="' . $productoCarrito["nombreProducto"] . '" style="max-width: 150px;"></td>';
                            echo '<td> ' . $productoCarrito["nombreProducto"] . ' </td>';
                            echo '<td>$' . $precioProductoFormat . '</td>';
                            echo '<td> <a class="btn btn-danger" href="handlers/borrarProducto.php?idProd='.$productoCarrito["idProducto"].'"><i class="fas fa-trash"></i></a></td>';
                            echo '</tr>';
                            */
                        }
                    } else {
                        echo '<br><br><br><br>';
                        echo '<div class="info-carro-empty text-center">';
                        echo '<h2><span class="icon-bag"></span></h2>';
                        echo '<h3>Tu Carro está vacío</h3>';
                        echo '<h4>¿Quieres agregar productos?</h4>';
                        echo '<br>';
                        echo '<div class="row justify-content-center">';
                        echo '<div class="col-md-4"></div>';
                        echo '<div class="col-md-4">';
                        echo '<a href="inicio.php" class="btn btn-primary btn-continuar-total-carro">';
                        echo 'Continuar';
                        echo '</a>';
                        echo '</div>';
                        echo '<div class="col-md-4"></div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    $arProductosCarrito = obtenerProductosCarrito($idUsuario, $con); //include("dao/productoCarritoDAO.php");    
                    if (empty($arProductosCarrito)) {
                        echo '<br><br><br><br>';
                        echo '<div class="info-carro-empty text-center">';
                        echo '<h2><span class="icon-bag"></span></h2>';
                        echo '<h3>Tu Carro está vacío</h3>';
                        echo '<h4>¿Quieres agregar productos?</h4>';
                        echo '<br>';
                        echo '<div class="row justify-content-center">';
                        echo '<div class="col-md-4"></div>';
                        echo '<div class="col-md-4">';
                        echo '<a href="inicio.php" class="btn btn-primary btn-continuar-total-carro">';
                        echo 'Continuar';
                        echo '</a>';
                        echo '</div>';
                        echo '<div class="col-md-4"></div>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        foreach ($arProductosCarrito as $productoCarrito) {
                            $precioProductoFormat = number_format($productoCarrito["precioProducto"], 0, ',', '.');
                            $cantProductoEspecifico = $productoCarrito["cantProductoEspecifico"];
                            echo '<tr>';
                                echo '<div class="row" style="max-width: 100%;">';
                                // Contenedor del producto
                                echo '<div class="col-md-9">';
                                echo '<div class="card" style="width: 100%; margin-bottom: 50px; position: relative;">';
                                echo '<div class="d-flex align-items-center">';
                                echo '<div class="d-flex flex-column align-items-center" style="width: 5%; margin-left: 2%;">';
                                echo '<button class="btn btn-outline-secondary" type="button" id="sumarBtn" style="width: 40px">+</button>';
                                // Aumenté el ancho del input
                                echo '<input type="text" class="form-control" id="cantProducto" name="cantProducto" value="' . $cantProductoEspecifico . '" readonly style="width: 40px; text-align: center;">';
                                echo '<button class="btn btn-outline-secondary" type="button" id="restarBtn" style="width: 40px">-</button>';
                                echo '</div>';
                                // Otros detalles del producto (nombre, precio, etc.)
                                echo '<img src="' . $productoCarrito["imagenProducto"] . '" class="card-img-top" alt="' . $productoCarrito["nombreProducto"] . '" style="max-width: 17%; object-fit: cover; margin-left: 4%;">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title"><strong>' . $productoCarrito["nombreProducto"] . '</strong></h5>';
                                echo '<p class="card-text">Precio: $' . $precioProductoFormat . '</p>';
                                echo '</div>';
                                // Botón de borrar producto completamente centrado verticalmente
                                echo '<a class="btn btn-danger align-self-center position-absolute translate-middle" style="right: 0; margin-right: 3%" href="handlers/borrarProducto.php?idProd=' . $productoCarrito["idProducto"] . '"><i class="fas fa-trash"></i></a>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            echo '</tr>';
                        }
                    }
                }
                ?>
                </tbody>
        </table>
        <div class="text-right">
            <!-- SE MUESTRA EL TOTAL DEL CARRITO SIEMPRE Y CUANDO HAYAN PRODUCTOS -->
            <?php
            if ($idUsuario === 0) {
                if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                    $arProductosCarritoTemporal = $_SESSION['carrito'];
                    $totalCarrito = 0;
                    foreach ($arProductosCarritoTemporal as $productoCarrito) {
                        $totalCarrito += $productoCarrito["precioProducto"] * $productoCarrito["cantProductoEspecifico"];
                    }
                    if ($totalCarrito != 0) {
                        $precioProductoFormat = number_format($totalCarrito, 0, ',', '.');
                        echo '<p>Total: $' . $precioProductoFormat . '</p>';
                        echo '<a href="login.php" class="btn btn-primary btn-continuar-total-carro">';
                        mysqli_close($con);
                        echo 'Continuar Compra';
                        echo '</a>';
                    }
                }
            } else {
                if (empty($arProductosCarrito)) {
                    //NADA
                } else {
                    $totalCarrito = obtenerTotalCarrito($idUsuario, $con); //include("dao/carritoDAO.php");
                    if ($totalCarrito != null) {
                        echo '<p>Total: $' . $totalCarrito . '</p>';
                        mysqli_close($con);
                        echo '<a href="pago.php" class="btn btn-primary btn-continuar-total-carro">';
                        echo 'Continuar Compra';
                        echo '</a>';
                    }
                }
            }
            ?>
            <br>
            <br>
        </div>
    </div>
    <?php include("templates/footer.php"); ?>
    <script>
        // Obtener elementos del DOM
        var cantidadProductoInput = document.getElementById('cantProducto');
        var sumarBtn = document.getElementById('sumarBtn');
        var restarBtn = document.getElementById('restarBtn');

        // Manejar clic en el botón de suma
        sumarBtn.addEventListener('click', function () {
            // Obtener el valor actual y convertirlo a un número
            var cantidadActual = parseInt(cantidadProductoInput.value);

            // Incrementar la cantidad
            cantidadProductoInput.value = cantidadActual + 1;
        });

        // Manejar clic en el botón de resta
        restarBtn.addEventListener('click', function () {
            // Obtener el valor actual y convertirlo a un número
            var cantidadActual = parseInt(cantidadProductoInput.value);

            // Asegurarse de que la cantidad no sea menor que 1
            if (cantidadActual > 1) {
                // Decrementar la cantidad
                cantidadProductoInput.value = cantidadActual - 1;
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<?php
if (!isset($_SESSION["cuentaLogeada"])) {
    // Si no está definida, inicialízala en 0
    $_SESSION["cuentaLogeada"] = null;
} else {
    if ($_SESSION["cuentaLogeada"]) {
        echo '<script>alert("Has iniciado sesion correctamente.");</script>';
        $_SESSION["cuentaLogeada"] = null;
    }
}
?>