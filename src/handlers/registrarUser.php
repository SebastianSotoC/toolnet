<?php
include("../db/conexionBD.php");
include("../dao/carritoDAO.php");
include("../dao/usuarioDAO.php");
$con = conectar();
session_start(); //sesion

$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$correo = $_POST["correo"];
$password = $_POST["password"];

insertarUsuario($nombre, $apellido, $correo, $password ,$con);

    
