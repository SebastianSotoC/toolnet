<link rel="stylesheet" href="../css/comentarioStyle.css">
<div class="comment-section">
    <form action="handlers/insertComentario.php" id="comment-form" method="post">    
        <?php 
        if ($idUsuario > 0){
            echo '<input type="hidden" id="idUsuario" name="idUsuario" value="'.$idUsuario.'">'; // Cambia el valor con el ID real del usuario 
            echo '<input type="hidden" id="idProducto" name="idProducto" value="'.$idProducto.'">'; //Cambia el valor con el ID real del producto 
        }else{
            echo '<input type="hidden" id="idUsuario" name="idUsuario" value="null">'; // Cambia el valor con el ID real del usuario 
            echo '<input type="hidden" id="idProducto" name="idProducto" value="null">'; //Cambia el valor con el ID real del producto 
        }
        
        ?>
        <div class="form-group">
            <label for="comentario">Comentario:</label>
            <textarea id="comentario" name="comentario" placeholder="Deja tu comentario" required></textarea>
        </div>
        <button type="submit">Enviar comentario</button>
    </form>
    <br>
    <ul id="comment-list">
        <!-- Los comentarios existentes se cargarán aquí desde la base de datos -->
        <li>   
            <?php 
            $arComentarios = obtenerComentarios($idProducto, $con);
            if (empty($arComentarios)){
                echo '<h4>El producto no tiene reseñas hasta el momento</h4>';
            }else{
                foreach($arComentarios as $rowComentario){
                    echo '<div class="comment-header">';
                    echo '<span class="user-name">'.$rowComentario["nombreUsuario"].' '.$rowComentario["apellidoUsuario"].'</span>';
                    echo '<span class="user-email">'.$rowComentario["correoUsuario"].'</span>';
                    echo '<span class="comment-date">'.$rowComentario["fechaPublicacion"].'</span>';
                    echo '</div>';
                    echo '<p class="user-comment">'.$rowComentario["comentarioUsuario"].'</p>';
                }  
            }
            mysqli_close($con);
            ?>
        </li>
    </ul>
</div>