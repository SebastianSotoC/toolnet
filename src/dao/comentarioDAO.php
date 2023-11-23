<?php
function insertarComentario($idProducto, $idUsuario, $nombreUsuario, $apellidoUsuario, $correoUsuario, $comentarioUsuario, $con){
    // Insertar comentario en la base de datos
    $sql = "INSERT INTO comentario (idProducto, idUsuario, nombreUsuario, apellidoUsuario, correoUsuario, comentarioUsuario)
            VALUES ($idProducto, $idUsuario, '$nombreUsuario', '$apellidoUsuario', '$correoUsuario', '$comentarioUsuario')";
    try{
        $result= mysqli_query($con, $sql);
        if ($result) {
            return true; // La inserción fue exitosa
        } else {
            return false; // Hubo un error en la inserción
        }
    }catch(Exception $e){
        return $e;
    }
}

function obtenerComentarios($idProducto, $con){
    // Consulta para recuperar los comentarios
    $sql = "SELECT nombreUsuario, apellidoUsuario, correoUsuario, comentarioUsuario, fechaPublicacion FROM comentario WHERE idProducto = $idProducto";
    try{
        $result = $con->query($sql);
        $arComentarios = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nombreUsuario = $row["nombreUsuario"];
                $apellidoUsuario = $row["apellidoUsuario"];
                $correoUsuario = $row["correoUsuario"];
                $comentarioUsuario = $row["comentarioUsuario"];
                $fechaPublicacion = $row["fechaPublicacion"];
                
                $arComentarios[] = array(
                    "nombreUsuario" => $nombreUsuario,
                    "apellidoUsuario" => $apellidoUsuario,
                    "correoUsuario" => $correoUsuario,
                    "comentarioUsuario" => $comentarioUsuario,
                    "fechaPublicacion" => $fechaPublicacion            
                );
                //echo "<p><strong>{$row['nombreUsuario']}:</strong> {$row['comentarioUsuario']}</p>";
            }
        }
        return $arComentarios;
    }catch(Exception $e){
        die("ERROR OBTENER COMENTARIOS");
    }
    

}
?>