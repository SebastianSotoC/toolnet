<?php
session_start();
// Verifica si $_SESSION["idUsuario"] ya está definida
if (!isset($_SESSION["idUsuario"])) {
    // Si no está definida, inicialízala en 0
    $_SESSION["idUsuario"] = 0;
    
}else{
    if ($_SESSION["idUsuario"] >0){
        $idUsuario = $_SESSION["idUsuario"]; // Reemplaza esto con el ID del usuario deseado
    }else{
        $idUsuario = $_SESSION["idUsuario"];
    }   
} 


die($search);
include("db/conexionBD.php");
include("dao/productoDAO.php");
include("dao/productoCarritoDAO.php");
include("dao/carritoDAO.php");
include("dao/comentarioDAO.php");
$con = conectar();
?>
