<?php
function conectar(){
    $host = 'cs.ilab.cl';// cs.ilab.cl - localhost
    $user = '2_BD_66';// 2_BD_66 - root
    $pwd = 'benjamin.gonzalezca23';// benjamin.gonzalezca23 - 1234
    $bd = '2_BD_66';// 2_BD_66 - toolnet
    
    try{
        $con = mysqli_connect($host, $user, $pwd); // se efectua la conexion
    }catch (Exception $e){
        die("Conexión a DataBase fallida");
    }
  
    try{
        mysqli_select_db($con, $bd); // se selecciona la base de datos
    }catch(Exception $e){
        die("Seleccion de DataBase fallida.");
    }          
    
    return $con; // se devuelve objeto con la conexion   
}
