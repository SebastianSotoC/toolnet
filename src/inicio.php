<?php
session_start();
// Verifica si $_SESSION["idUsuario"] ya está definida
include("templates/getUsuario.php");

if (!isset($_GET["search"])) {
    $search = null;
} else {
    // Se obtiene id del producto pasado a traves de la url
    $search = $_GET["search"];
}

include("db/conexionBD.php");
include("dao/productoDAO.php");
include("dao/carritoDAO.php");
$con = conectar();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Página Principal</title>
    <style>
        .card-text {
            max-height: 3em;
            /* Ajusta la altura máxima según tus necesidades */
            overflow: hidden;
            text-overflow: ellipsis;

        }
    </style>
</head>

<body>
    <?php include("templates/navbar.php"); ?>
    <div class="container mt-4">
        <?php
        $filaProducto = 0;
        if ($search === null) {
            $arProducto = obtenerProductos($con);
            if (empty($arProducto)) {
                echo '<br/>';
                echo '<div class="text-center" style="font-size: 20px;">No hay productos disponibles en este momento.</div>';
            } else {
                echo '<div class="row">';
                foreach ($arProducto as $producto) {
                    if($producto["descuentoProducto"] != 0 and $producto["descuentoProducto"] != null){                     
                        $descuentoProducto = (100 - $producto["descuentoProducto"])/100;
                        $precioProductoDescontado = $producto["precioProducto"] * $descuentoProducto;
                        $precioProductoDescuentoFormat = number_format($precioProductoDescontado, 0, ',', '.');                                
                    }  
                    $precioProductoFormat = number_format($producto["precioProducto"], 0, ',', '.');
                    $descripcionProducto = $producto["descripcionProducto"];
                    // Limita el nombre del producto a 30 caracteres
                    if (strlen($descripcionProducto) > 60) {
                        $descripcionProducto = substr($descripcionProducto, 0, 60) . "...";
                    }
                    echo '<div class="col-md-3 mb-4">'; // Cambia 4 a 3 para quepa 4 tarjetas en una fila
                    echo '<a href="producto.php?idProd=' . $producto["idProducto"] . '" style="text-decoration: none; color: inherit;">'; // Enlace que rodea toda la tarjeta
                    echo '<div class="card" style="width: 100%; height: 100%;">';
                    echo '<img src="' . $producto["imagenProducto"] . '" class="card-img-top center-image" alt="' . $producto["nombreProducto"] . '" style="width: 195px; height: 215px; margin: 0 auto; display: block;">';
                    echo '<div class="card-body" style="display: flex; flex-direction: column; justify-content: space-between; width: 100%; height: 100%;">';
                    echo '<h5 class="card-title">' . $producto["nombreProducto"] . '</h5>';
                    echo '<p class="card-text">' . $descripcionProducto . '</p>';
                    echo '<div class="precioProducto">';
                    if($producto["descuentoProducto"] != 0 and $producto["descuentoProducto"] != null){
                        echo '<p class="card-text " style=""><strong>&nbsp;$'. $precioProductoDescuentoFormat . '</strong> &nbsp;&nbsp;
                        <del>$' . $precioProductoFormat . '</del><strong id="descuentoProducto"> -'.$producto["descuentoProducto"].'%</strong></p>';      
                                
                    }else{
                        echo '<p class="card-text " style=""><strong>&nbsp;$' . $precioProductoFormat . '</strong></p>';           
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</a>'; // Cierre del enlace
                    echo '</div>';
                }
                echo '</div>'; // Cierra la última fila
            }
        } else {
            // Escapa el término de búsqueda para evitar SQL injection
            $search = mysqli_real_escape_string($con, $search);
            $arProductosEntontrados = buscarProductosPorTermino($search, $con);

            if (empty($arProductosEntontrados)) {
                // Muestra un mensaje si no se encuentran resultados
                if ($search != "") {
                    echo '<div class="mt-1">';
                    echo '  <span class="badge badge-secondary p-2 rounded-pill d-inline-flex align-items-center">';
                    echo '      <div class="flex-grow-1">';
                    echo '          Búsqueda: ' . $search . '&nbsp;';
                    echo '      </div>';
                    echo '      <a href="inicio.php" class="text-danger" data-toggle="tooltip" data-placement="top" title="Limpiar búsqueda">';
                    echo '          <i class="fas fa-times fa-lg"></i>';
                    echo '      </a>';
                    echo '  </span>';
                    echo '</div>';
                    echo '<br/>';
                }
                echo '<div class="text-center" style="font-size: 20px;">No se encontraron productos que coincidan con la búsqueda.</div>';
            } else {
                if ($search != "") {
                    echo '<div class="mt-1">';
                    echo '  <span class="badge badge-secondary p-2 rounded-pill" style="width: auto;">';
                    echo 'Búsqueda: ' . $search . ' ';
                    echo '<a href="inicio.php" class="text-danger" data-toggle="tooltip" data-placement="top" title="Limpiar búsqueda" style="vertical-align: middle;">';
                    echo '<i class="fas fa-times fa-lg"></i>';
                    echo '</a>';
                    echo '</span>';
                    echo '</div>';
                    echo '<br/>';
                }


                echo '<div class="row">';
                foreach ($arProductosEntontrados as $producto) {
                    if($producto["descuentoProducto"] != 0 and $producto["descuentoProducto"] != null){                     
                        $descuentoProducto = (100 - $producto["descuentoProducto"])/100;
                        $precioProductoDescontado = $producto["precioProducto"] * $descuentoProducto;
                        $precioProductoDescuentoFormat = number_format($precioProductoDescontado, 0, ',', '.');                                
                    }  
                    $precioProductoFormat = number_format($producto["precioProducto"], 0, ',', '.');
                    $descripcionProducto = $producto["descripcionProducto"];
                    // Limita el nombre del producto a 30 caracteres
                    if (strlen($descripcionProducto) > 60) {
                        $descripcionProducto = substr($descripcionProducto, 0, 60) . "...";
                    }
                    echo '<div class="col-md-3 mb-4">'; // Cambia 4 a 3 para quepa 4 tarjetas en una fila
                    echo '<a href="producto.php?idProd=' . $producto["idProducto"] . '" style="text-decoration: none; color: inherit;">'; // Enlace que rodea toda la tarjeta
                    echo '<div class="card" style="width: 100%; height: 100%;">';
                    echo '<img src="' . $producto["imagenProducto"] . '" class="card-img-top center-image" alt="' . $producto["nombreProducto"] . '" style="width: 195px; height: 215px; margin: 0 auto; display: block;">';
                    echo '<div class="card-body" style="display: flex; flex-direction: column; justify-content: space-between; width: 100%; height: 100%;">';
                    echo '<h5 class="card-title">' . $producto["nombreProducto"] . '</h5>';
                    echo '<p class="card-text">' . $descripcionProducto . '</p>';
                    echo '<div class="precioProducto">';
                    if($producto["descuentoProducto"] != 0 and $producto["descuentoProducto"] != null){
                        echo '<p class="card-text " style=""><strong>&nbsp;$'. $precioProductoDescuentoFormat . '</strong> &nbsp;&nbsp;
                        <del>$' . $precioProductoFormat . '</del><strong id="descuentoProducto"> -'.$producto["descuentoProducto"].'%</strong></p>';      
                                
                    }else{
                        echo '<p class="card-text " style=""><strong>&nbsp;$' . $precioProductoFormat . '</strong></p>';           
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</a>'; // Cierre del enlace
                    echo '</div>';
                }
                echo '</div>'; // Cierra la última fila
            }
        }

        mysqli_close($con);
        ?>
    </div> <!-- Cierra el contenedor principal -->
    <!-- pie de página aquí -->
    <?php include("templates/footer.php"); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<?php
if (!isset($_SESSION["cuentaLogeada"])) {
    // Si no está definida, inicialízala en 0
    $_SESSION["cuentaLogeada"] = null;
} else {
    if ($_SESSION["cuentaLogeada"]) {
        echo '<script>alert("Has iniciado sesion correctamente.");</script>';
        $_SESSION["cuentaLogeada"] = null;
    }
}
?>