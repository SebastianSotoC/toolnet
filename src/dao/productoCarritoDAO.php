<?php
function insertarProductoCarrito($idUsuario, $idProducto, $cantProdAActualizar, $con){
    $cantProductoEspecifico = obtenerCantProductoCarritoEspecifico($idUsuario, $idProducto, $con);
    if($cantProductoEspecifico != null AND $cantProductoEspecifico > 0){
        //HAY QUE MANDARLE NUMERO DE PRODUCTOS A INSERTAR
        $resultado = actualizarProductoCarritoEspecifico($idUsuario, $idProducto, $cantProductoEspecifico, $cantProdAActualizar, $con);
        if($resultado == true){
            //PRODUCTO CARRITO ESPECIFICO ACTUALIZADO CORRECTAMENTE
            return true;
        }else{
            die("ERROR AL ACTUALIZAR EL PRODUCTO CARRITO ESPECIFICO");
        }
    } else {
        $sql = "INSERT INTO carrito_has_producto (carrito_id, producto_id, cantProductoEspecifico) 
                    VALUES ($idUsuario, $idProducto, $cantProdAActualizar);";
        try {
            if ($con->query($sql) === TRUE) {
                return true;
            } else {
                die("Error al insertar producto al carrito: " . $con->error);
            }
        } catch (Exception $e) {
        }
    }
}

function obtenerProductosCarrito($idUsuario, $con){
    $sql = "SELECT *
            FROM producto p
            JOIN carrito_has_producto chp ON p.id = chp.producto_id
            JOIN carrito c ON chp.carrito_id = c.usuario_id
            WHERE c.usuario_id = $idUsuario;";

    $result = $con->query($sql);
    $productosCarrito = array(); // Un arreglo para almacenar los datos del carrito

    if ($result->num_rows > 0) {
        // Itera a través de los productos en el carrito
        while ($row = $result->fetch_assoc()) {
            $idProducto = $row["id"];
            $nombreProducto = $row["nombre"];
            $precioProducto = $row["precio"];
            $stockProducto = $row["stock"];
            $imagenProducto = $row["imagen"];
            $cantProductoEspecifico = $row["cantProductoEspecifico"];

            // Agregar los datos del producto al arreglo del carrito
            $productosCarrito[] = array(
                "idProducto" => $idProducto,
                "nombreProducto" => $nombreProducto,
                "precioProducto" => $precioProducto,
                "stockProducto" => $stockProducto,
                "imagenProducto" => $imagenProducto,
                "cantProductoEspecifico" => $cantProductoEspecifico
            );
        }
    }
    // Retornar el arreglo del carrito 
    return $productosCarrito;
}

function borrarProductoDelCarrito($idUsuario, $idProducto, $con)
{
    // Asegúrate de que el usuario y el producto existen en la base de datos
    // Aquí podrías realizar comprobaciones adicionales según tus necesidades
    $sql = "DELETE FROM carrito_has_producto
            WHERE carrito_id = $idUsuario
            AND producto_id = $idProducto";

    try {
        if ($con->query($sql) === TRUE) {
            // El producto se eliminó con éxito del carrito
            return true;
        } else {
            // Ocurrió un error al eliminar el producto del carrito
            return false;
        }
    } catch (Exception $e) {
        die("ERROR AL BORAR PRODUCTO DAO");
    }

}

function obtenerCantProductoCarritoEspecifico($idUsuario, $idProducto, $con){
    $sql = "SELECT cantProductoEspecifico
            FROM carrito_has_producto
            WHERE carrito_id = $idUsuario
            AND producto_id = $idProducto;
            ";

    $result = $con->query($sql);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        return $row["cantProductoEspecifico"];
    }else{
        return null;
    }  
}

function actualizarProductoCarritoEspecifico($idUsuario, $idProducto, $cantProductoEspecifico, $cantProdAActualizar, $con){  
    if($cantProductoEspecifico != null){
        $sql = "UPDATE carrito_has_producto
                   SET
                   cantProductoEspecifico = $cantProductoEspecifico + $cantProdAActualizar
                   WHERE carrito_id = $idUsuario AND producto_id = $idProducto;";

        if ($con->query($sql) === TRUE) {
            return true;
            //SE HA ACTUALIZADO EL CARRITO CORRECTAMENTE
        }else{
            return null;
                //ERROR AL ACTUALIZAR PRODCARRITO
        }
    }else{
        return false;
    }
}



