<?php

function insertarUsuario($nombre, $apellido, $correo, $password, $con){
    $sql = "SELECT id FROM usuario WHERE correo = '$correo'";
    try{
        $result= mysqli_query($con, $sql);
        if ($result->num_rows == 1){
            //NO INSERTA UN USUAIO YA EXISTENTE
            $_SESSION["cuentaRegistrada"]=false;
            mysqli_close($con);
            header("Location: ../registro.php");
            exit();
        }else{
            //INSERTA UN USUARIO YA QUE NO EXISTE
            $sql = "INSERT INTO usuario (nombre, apellido, correo, contrasenia) VALUES ('$nombre', '$apellido', '$correo', '$password');";
            try {
                mysqli_query($con, $sql);
                $_SESSION["cuentaRegistrada"]=true;
                $idUsuarioInsertado = mysqli_insert_id($con);
            
                // Insertar un carrito para el usuario con el ID obtenido
                $totalCarrito = 0;  // Puedes establecer otros valores predeterminados si es necesario
                $cantidadProductos = 0;  // Puedes establecer otros valores predeterminados si es necesario
            
                insertarCarrito($idUsuarioInsertado, $totalCarrito, $cantidadProductos, $con);
                mysqli_close($con);
                exit();
            
            }catch (Exception $e){
                mysqli_close($con);
                echo '<script>alert("Error(2) al crear la cuenta: ' . mysqli_error($con) . '");</script>';
                exit();
            } 
                }
    }catch (Exception $e){
        mysqli_close($con);
        echo '<script>alert("Error(1) al crear la cuenta: ' . mysqli_error($con) . '");</script>';
        exit();
    }    
}

function obtenerUsuario($correo, $password, $con){
    // Evita inyección SQL utilizando consultas preparadas
    $sql = "SELECT * FROM usuario WHERE correo = ? AND contrasenia = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $correo, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $idUsuario = null;
    if ($result->num_rows > 0) {
        // Iniciar sesión y redirigir al usuario
        $row = $result->fetch_assoc(); 
        $idUsuario = $row["id"]; //se obtiene el id del usuario
        $_SESSION["cuentaLogeada"]=true;
    } else {
        // Mostrar un mensaje de error       
    }
    return $idUsuario;
}

function encontrarUsuario($correo, $con){
    $sql = "SELECT id FROM usuario WHERE correo = $correo;";
    
    try{
        $result= mysqli_query($con, $sql);
        if ($result->num_rows > 0){
            //existe usuario
            return true;
        }else{
            //no existe usuario
            return false;
        }

    }catch (Exception $e){
        mysqli_close($con);
        header("Location: ../registro.php");
        exit();
    }
}

function obtenerInfoUsuario($idUsuario, $con){
    $sql = "SELECT nombre, apellido, correo FROM usuario WHERE id = $idUsuario;";
    try{
        $result= $con->query($sql);
        $arInfoUsuario = array();

        if($result->num_rows > 0){
            
            $row = $result->fetch_assoc(); 
            $nombreUsuario = $row["nombre"];
            $apellidoUsuario = $row["apellido"];
            $correoUsuario = $row["correo"];

            $arInfoUsuario[] = array(
                "nombreUsuario" => $nombreUsuario,
                "apellidoUsuario" => $apellidoUsuario,
                "correoUsuario" => $correoUsuario
            );
        }
        return $arInfoUsuario;
    }catch(Exception $e){
        mysqli_close($con);
        die("ERROR obtenerInfoUsuario ".$e);
       
    }
}

function obtenerNombreUsuario($idUsuario, $con){
    $sql = "SELECT nombre FROM usuario WHERE id = $idUsuario";
    try{
        $result= $con->query($sql);
        
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $nombreUsuario = $row["nombre"];
        }else{
            $NombreUsuario = null;
        }
        return $nombreUsuario;
    }catch(Exception $e){
        mysqli_close($con);
        die("Error al obtener el nombre del usuario".$e);
    }
}