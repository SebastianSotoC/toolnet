<?php 
session_start();
include("db/conexionBD.php");
include("dao/carritoDAO.php");
$con = conectar();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/navbarStyle.css">
    <title>Buscar Productos</title>
</head>
<body>
    <?php 
    include("templates/navbar.php"); 
    mysqli_close($con);
    ?>
    <div class="container mt-4">
        <h2>Buscar Productos</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="imagen_producto_1.jpg" class="card-img-top" alt="Producto 1">
                    <div class="card-body">
                        <h5 class="card-title">Guantes de Trabajo</h5>
                        <p class="card-text">Guantes resistentes para el trabajo.</p>
                        <p class="card-text">$XX.XX</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="imagen_producto_2.jpg" class="card-img-top" alt="Producto 2">
                    <div class="card-body">
                        <h5 class="card-title">Guantes de Jardín</h5>
                        <p class="card-text">Guantes ideales para la jardinería.</p>
                        <p class="card-text">$XX.XX</p>
                    </div>
                </div>
            </div>
            <!-- Agrega más tarjetas de productos aquí -->
        </div>
    </div>

    <script>
        function filterProducts() {
            var input, filter, cards, card, title, i;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            cards = document.querySelectorAll(".card");
            
            for (i = 0; i < cards.length; i++) {
                card = cards[i];
                title = card.querySelector(".card-title");
                if (title.innerText.toUpperCase().indexOf(filter) > -1) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>