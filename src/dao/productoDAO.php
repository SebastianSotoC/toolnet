<?php
function insertarProducto(){
    
}

function obtenerProductos($con){
    $sql= "SELECT * 
           FROM producto";

    $result = $con->query($sql);
    $arProductos = array(); // Un arreglo para almacenar los datos del carrito

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        // Crear un array para almacenar los productos
        // Recorrer los resultados y guardarlos en el array
        while ($row = $result->fetch_assoc()) {
            $idProducto = $row["id"];
            $nombreProducto = $row["nombre"];
            $precioProducto = $row["precio"];
            $descripcionProducto = $row["descripcion"];
            $fichaTecnicaProducto = $row["fichaTecnica"];
            $stockProducto = $row["stock"];
            $descuentoProducto = $row["descuento"];
            $imagenProducto = $row["imagen"];
            $reseniaProducto = $row["resenia"];

            // Agregar los datos del producto al arreglo del carrito
            $arProductos[] = array(
                "idProducto" => $idProducto,
                "nombreProducto" => $nombreProducto,
                "precioProducto" => $precioProducto,
                "descripcionProducto" => $descripcionProducto,
                "fichaTecnicaProducto" => $fichaTecnicaProducto,
                "stockProducto" => $stockProducto,
                "descuentoProducto" => $descuentoProducto,
                "imagenProducto" => $imagenProducto,
                "reseniaProducto" => $reseniaProducto
            );
        }
    } 

    return $arProductos;
}

function obtenerProductoConId($idProducto, $con){
    $sql= "SELECT * 
           FROM producto
           WHERE id = $idProducto";

    $result = $con->query($sql);
    $arProducto = array(); // Un arreglo para almacenar los datos del carrito

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        // Crear un array para almacena r los productos
        $row = $result->fetch_assoc();
        $idProducto = $row["id"];
        $nombreProducto = $row["nombre"];
        $precioProducto = $row["precio"];
        $descripcionProducto = $row["descripcion"];
        $fichaTecnicaProducto = $row["fichaTecnica"];
        $stockProducto = $row["stock"];
        $descuentoProducto = $row["descuento"];
        $imagenProducto = $row["imagen"];
        $reseniaProducto = $row["resenia"];
         // Recorrer los resultados y guardarlos en el array
    
        // Agregar los datos del producto al arreglo del carrito
        $arProducto[] = array(
            "idProducto" => $idProducto,
            "nombreProducto" => $nombreProducto,
            "precioProducto" => $precioProducto,
            "descripcionProducto" => $descripcionProducto,
            "fichaTecnicaProducto" => $fichaTecnicaProducto,
            "stockProducto" => $stockProducto,
            "descuentoProducto" => $descuentoProducto,
            "imagenProducto" => $imagenProducto,
            "reseniaProducto" => $reseniaProducto
        );
        

    } else {
       echo "No se encontro el producto.";
    }

    return $arProducto;
}

function obtenerPrecioProducto($idProducto, $con){
    $sql = "SELECT precio
            FROM producto
            WHERE id = $idProducto;";

    $result = $con->query($sql);
    $precioProducto = 0;
    if ($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $precioProducto = $row["precio"];
    }

    return $precioProducto;
}

function buscarProductosPorTermino($searchTerm, $con){
    // Realizar la consulta SQL
    $sql = "SELECT * FROM producto
            WHERE nombre LIKE '%$searchTerm%'";
    
    try{
        $result = mysqli_query($con, $sql);
        $arProductosEntontrados = array();
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $idProducto = $row["id"];
                $nombreProducto = $row["nombre"];
                $precioProducto = $row["precio"];
                $descripcionProducto = $row["descripcion"];
                $fichaTecnicaProducto = $row["fichaTecnica"];
                $stockProducto = $row["stock"];
                $descuentoProducto = $row["descuento"];
                $imagenProducto = $row["imagen"];
                $reseniaProducto = $row["resenia"];

                $arProductosEntontrados[] = array(
                    "idProducto" => $idProducto,
                    "nombreProducto" => $nombreProducto,
                    "precioProducto" => $precioProducto,
                    "descripcionProducto" => $descripcionProducto,
                    "fichaTecnicaProducto" => $fichaTecnicaProducto,
                    "stockProducto" => $stockProducto,
                    "descuentoProducto" => $descuentoProducto,
                    "imagenProducto" => $imagenProducto,
                    "reseniaProducto" => $reseniaProducto
                );
            }
        }
        return $arProductosEntontrados;
    }catch(Exception $e){
        die("ERROR AL BUSCAR PRODUCTO POR TERMINO");
    }
    
}
