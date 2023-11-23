<?php
include("../db/conexionBD.php");
include("../dao/comentarioDAO.php");
include("../dao/productoDAO.php");
include("../dao/usuarioDAO.php");
$con = conectar();
session_start();
$idUsuario = $_POST["idUsuario"];
$idProducto = $_POST["idProducto"];
$comentarioUsuario = $_POST["comentario"];

if ($idUsuario === 'null' or $idProducto === 'null') {  
    mysqli_close($con);
    header("location: ../login.php");
    die("ERRORRRR");
}else{
    $arInfoUsuario = obtenerInfoUsuario($idUsuario, $con);
    if(empty($arInfoUsuario)){
        //ERROR NO SE PUEDE INSERTAR COMENTARIO
        mysqli_close($con);
        die("Error al intentar publicar un comentario");
    }else{
        foreach($arInfoUsuario as $infoUsuario){
            $nombreUsuario = $infoUsuario["nombreUsuario"];
            $apellidoUsuario = $infoUsuario["apellidoUsuario"];
            $correoUsuario = $infoUsuario["correoUsuario"];
        }
        $resultado = insertarComentario($idProducto, $idUsuario, $nombreUsuario, $apellidoUsuario, $correoUsuario, $comentarioUsuario, $con);
        if ($resultado){
            mysqli_close($con);
            header("Location: ../producto.php?idProd=" . $idProducto);
        }else{
            mysqli_close($con);
            die("ERROR al publicar comentario" .$resultado);
        }
    }
    exit(); // Asegúrate de que el script se detenga después de la redirección
}

?>
