<?php
function insertarCarrito($idUsuarioInsertado, $totalCarrito, $cantidadProductos, $con){
    $sql = "INSERT INTO carrito (usuario_id, totalCarrito, cantidadProductos) VALUES ($idUsuarioInsertado, $totalCarrito, $cantidadProductos)";

    if ($con->query($sql) === TRUE) {
        header("Location: ../login.php");
    } else { 
        die("Error al insertar carrito: " . $con->error);
    }
    exit;
}

function obtenerCarrito($idUsuario, $con){
    $sql = "SELECT *
            FROM carrito
            WHERE usuario_id = $idUsuario;";
    
    $result = $con->query($sql);
    $arCarrito = array();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); 
        $totalCarrito = $row["totalCarrito"];
        $cantidadProductos = $row["cantidadProductos"];  
        //$totalCarritoFormat = number_format($totalCarrito, 0, ',', '.');

        $arCarrito[] = array(
            "totalCarrito" => $totalCarrito,
            "cantidadProductos" => $cantidadProductos 
        );
    } 
    return $arCarrito;
}

function actualizarCarrito($idUsuario, $con){
    //actualizar producto
    $arProductosCarrito = obtenerProductosCarrito($idUsuario, $con);
    $totalCarrito = 0;
    $cantidadProductos = 0;
    foreach($arProductosCarrito as $producto){
        $precioProducto = $producto["precioProducto"];
        $cantProductoEspecifico = $producto["cantProductoEspecifico"];
        $totalCarrito += $precioProducto * $cantProductoEspecifico;
        $cantidadProductos += $cantProductoEspecifico;
    }

    $sql ="UPDATE carrito
           SET
           totalCarrito = $totalCarrito,
           cantidadProductos = $cantidadProductos
          WHERE usuario_id = $idUsuario;";
    try{
            $con->query($sql);
    }catch(Exception $e){
        echo "ERROR AL ACTUALIZAR CARRITO";
    }
}


function obtenerTotalCarrito($idUsuario, $con) {
    $totalCarrito = 0;
    $totalCarritoFormat = 0;
    //SACAR SOLO TOTALCARRITO DESPUESAAAAAAAAAAAAA
    $sql = "SELECT * FROM carrito WHERE usuario_id = $idUsuario";

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); 
        $totalCarrito = $row["totalCarrito"];    
        $totalCarritoFormat = number_format($totalCarrito, 0, ',', '.');
    } 

    return $totalCarritoFormat;
}

function obtenerCantidadProdCarrito($idUsuario, $con){
    $cantidadProductos = 0;
    $sql = "SELECT cantidadProductos
            FROM carrito
            WHERE usuario_id = '$idUsuario'";
    $result = $con->query($sql);
    if ($result->num_rows > 0 ){
        $row = $result->fetch_assoc();
        $cantidadProductos = $row["cantidadProductos"];
        
    }
    
    return $cantidadProductos;

}



            
          