<?php
include("../db/conexionBD.php");
include("../dao/usuarioDAO.php");
include("../dao/productoCarritoDAO.php");
include("../dao/carritoDAO.php");
$con = conectar();
session_start();

$logCheck = $_POST["logCheck"];
$correo = $_POST["correo"];
$password = $_POST["password"];

$idUsuario = obtenerUsuario($correo, $password, $con);
if ($idUsuario === null){
    $_SESSION["cuentaLogeada"] = false;
    mysqli_close($con);
    header("location: ../login.php");
    exit();
}else{
    $_SESSION["idUsuario"] = $idUsuario;
    if($logCheck == 1){
        //USUARIO INVITADO CON PROD EN EL CARRITO, PRESIONA CONTINUAR COMPRA.   
        //DEBEMOS INSERTAR CARRITO AL USUARIO INGRESADO.
        $arProductosCarritoTemporal = array();
        if (isset($_SESSION["carrito"]) && !empty($_SESSION["carrito"])){
            $arProductosCarritoTemporal = $_SESSION["carrito"];
            $cantidadProductos = 0;
            $totalCarrito = 0;
            $cantProductoEspecifico = 0;
            foreach($arProductosCarritoTemporal as $producto){
                $idProducto = $producto["idProducto"];
                $totalCarrito += $producto["precioProducto"];
                $cantidadProductos += 1; 
                $cantProdAActualzar = $producto["cantProductoEspecifico"];
                insertarProductoCarrito($idUsuario, $idProducto, $cantProdAActualzar, $con);
            }
            actualizarCarrito($idUsuario, $con);
            $_SESSION["carrito"] = array();
            mysqli_close($con);
            header("location: ../carrito.php");
        }else{
            echo 'ERROR VALID ISSET CAR AND EMPTY CAR';
        }
    }else{
        //LOGEO NORMAL
        mysqli_close($con);
        header("location: ../inicio.php");
    }
    exit();
}






