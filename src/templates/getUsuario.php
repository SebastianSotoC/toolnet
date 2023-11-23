<?php
if (!isset($_SESSION["idUsuario"])) {
    // Si no está definida, inicialízala en 0
    $_SESSION["idUsuario"] = 0;
} else {
    if ($_SESSION["idUsuario"] > 0) {
        $idUsuario = $_SESSION["idUsuario"]; // Reemplaza esto con el ID del usuario deseado
        $_SESSION["idUsuario"] = $idUsuario;
    } else {
        $idUsuario = $_SESSION["idUsuario"];
        $_SESSION["idUsuario"] = $idUsuario;
    }
}
?>