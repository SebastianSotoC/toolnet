<?php
include("../db/conexionBD.php");
include("../dao/productoDAO.php");
include("../dao/productoCarritoDAO.php");
include("../dao/carritoDAO.php");
$con = conectar();
session_start();
if (isset($_GET['idProd'], $_SESSION['idUsuario'])) {
    $idUsuario = $_SESSION["idUsuario"];
    $idProductoABorrar = $_GET['idProd'];
    if($_SESSION['idUsuario'] == 0){
        //USUARIO INVITADO
        $arProductosCarrito = $_SESSION['carrito'];      
        foreach ($_SESSION['carrito'] as $posProd => $producto) {
            if ($producto['idProducto'] == $idProductoABorrar) {
                unset($_SESSION['carrito'][$posProd]); // Elimina el producto del carrito
                header("location: ../carrito.php");
                break; // Rompe el bucle una vez que encuentres el producto
            }
        }          
    }else{
        //USUARIO LOGEADO
        $resultado = borrarProductoDelCarrito($idUsuario, $idProductoABorrar, $con);
        actualizarCarrito($idUsuario, $con);
        if ($resultado) {
            // El producto se eliminó del carrito con éxito.
            header("location: ../carrito.php");
        } else {
            // Ocurrió un error al eliminar el producto del carrito.
            die("ERROR AL BORRAR PRODUCTO HANDLER FALSE");
        }
    }
}else{
    echo 'ID DEL PRODUCTO O EL ID DEL USUARIO NO SE HAN PROPORCIONADO';
}
   
?>

