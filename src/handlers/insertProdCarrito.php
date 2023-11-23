<?php
include("../db/conexionBD.php");
include("../dao/productoCarritoDAO.php");
include("../dao/productoDAO.php");
include("../dao/carritoDAO.php");
$con = conectar();
session_start(); //sesion

if (isset($_GET['idUsuario'], $_GET['idProducto'])) {
    $idUsuario = $_GET['idUsuario'];
    $idProducto = $_GET['idProducto'];
    $cantProdAActualizar = $_GET['cantProducto'];
  
    if ($idUsuario == 0) {
        if (!isset($_SESSION['carrito'])) {
            //SE CREA CARRITO TEMPORAL YA QUE EL USUARIO NO ESTA LOGEADO
            $_SESSION['carrito'] = array();
        }
        $arProductoEncontrado = obtenerProductoConId($idProducto, $con);
        if (empty($arProductoEncontrado)) {
            //PRODUCTO NO ENCONTRADO
        } else {
            $productoExistente = false;
            // Recorre el carrito para verificar si el producto ya está incluido
            foreach ($_SESSION['carrito'] as &$productoEnCarrito) {
                if ($productoEnCarrito["idProducto"] === $idProducto) {
                    // Si el producto ya está en el carrito, actualiza la cantidad
                    $productoEnCarrito["cantProductoEspecifico"] += $cantProdAActualizar;
                    $productoExistente = true;
                    break;  // No es necesario seguir recorriendo
                }
            }
            // Si el producto no estaba en el carrito, agrégalo
            if (!$productoExistente) {
                foreach ($arProductoEncontrado as $producto) {
                    $arProductosCarrito = array(
                        "idProducto" => $producto["idProducto"],
                        "nombreProducto" => $producto["nombreProducto"],
                        "precioProducto" => $producto["precioProducto"],
                        "imagenProducto" => $producto["imagenProducto"],
                        "cantProductoEspecifico" => $cantProdAActualizar
                    );
                }
                $_SESSION['carrito'][] = $arProductosCarrito;
            }         
        }
    } else {
        // Realiza la inserción en el carrito utilizando $idUsuario y $idProducto
        $result = insertarProductoCarrito($idUsuario, $idProducto, $cantProdAActualizar, $con);
        if ($result == true) {
            actualizarCarrito($idUsuario, $con);
        }

    }

} else {
    // Maneja el caso en el que no se proporcionaron los IDs
    echo "Los IDs de usuario y producto no se proporcionaron.";
}

mysqli_close($con);
header("Location: ../producto.php?idProd=" . $idProducto);
exit(); // Asegúrate de que el script se detenga después de la redirección
?>