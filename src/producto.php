<?php
session_start();
// Verifica si $_SESSION["idUsuario"] ya está definida
include("templates/getUsuario.php");

if (!isset($_GET["idProd"])) {
    $idProducto = null;
} else {
    // Se obtiene id del producto pasado a traves de la url
    $idProducto = $_GET["idProd"];
}

include("db/conexionBD.php");
include("dao/productoDAO.php");
include("dao/productoCarritoDAO.php");
include("dao/carritoDAO.php");
include("dao/comentarioDAO.php");
$con = conectar();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Detalles del Producto</title>
</head>

<body>
    <?php include("templates/navbar.php"); ?>
    <div class="container mt-4">
        <br>
        <br>
        <div class="row">

            <?php
            if ($idProducto === null) {
                echo 'PRODUCTO NO ENCONTRADO';
            } else {
                $arProducto = obtenerProductoConId($idProducto, $con);
                if (empty($arProducto)) {
                    //VACIO
                } else {
                    foreach ($arProducto as $producto) {
                        if ($producto["descuentoProducto"] != 0 and $producto["descuentoProducto"] != null) {
                            $descuentoProducto = (100 - $producto["descuentoProducto"]) / 100;
                            $precioProductoDescontado = $producto["precioProducto"] * $descuentoProducto;
                            $precioProductoDescuentoFormat = number_format($precioProductoDescontado, 0, ',', '.');
                        }
                        $precioProductoFormat = number_format($producto["precioProducto"], 0, ',', '.');
                        echo '<div class="col-md-6" style="text-align: end;">'; 
                        echo '<img src="' . $producto["imagenProducto"] . '" class="img-fluid mx-auto" style="width: 78%; height: 85%;" alt="' . $producto["nombreProducto"] . '">';
                        echo '<form action="handlers/insertProdCarrito.php" method="get">';
                        echo '<input type="hidden" name="idUsuario" value="' . $idUsuario . '">';
                        echo '<input type="hidden" name="idProducto" value="' . $producto["idProducto"] . '">';
                        echo '</div>';

                        echo '<div class="col-md-6">';
                        echo '<h2>' . $producto["nombreProducto"] . '</h2>';
                        echo '<p>' . $producto["descripcionProducto"] . '</p>';
                        echo '<p><strong>Stock de producto: </strong> ' . $producto["stockProducto"] . '</p>';
                        if ($producto["descuentoProducto"] != 0 and $producto["descuentoProducto"] != null) {
                            echo '<p><strong>Precio normal:</strong> <del>$' . $precioProductoFormat . '</del></p>';
                            echo '<p><strong>Descuento:</strong> -' . $producto["descuentoProducto"] . '%</p>';
                            echo '<p><strong>Precio con descuento:</strong> $' . $precioProductoDescuentoFormat . '</p>';
                        } else {
                            echo '<p><strong>Precio normal:</strong> $' . $precioProductoFormat . '</p>';
                        }
                        echo '<br>';

                        echo '<div class="d-flex justify-content-start align-items-center">';
                        // Contenedor del grupo de botones de cantidad
                        echo '<div class="card" style="width: 20.8%; margin-right: 10px;">';
                        echo '<div class="input-group">';
                        echo '<button class="btn btn-outline-secondary" type="button" id="restarBtn">-</button>';
                        echo '<input type="text" class="form-control" id="cantProducto" name="cantProducto" value="1" readonly>';
                        echo '<button class="btn btn-outline-secondary" type="button" id="sumarBtn">+</button>';
                        echo '</div>';
                        echo '</div>';
                        // Botón "Añadir al Carrito"
                        echo '<button type="submit" class="btn btn-primary" style="margin-left: 10px;">Añadir al Carrito</button>';
                        echo '</div>'; // Cierre del contenedor flexible
            


                        echo '</form>';

                    }
                }
            }
            ?>
        </div>
    </div>
    <br><br>
    <?php include("templates/comentarios.php"); ?>
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