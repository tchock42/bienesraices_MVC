
<main class="contenedor seccion">
        <h1>Editor de entradas de blog</h1>
        <?php 
        if($resultado){
            $mensaje = mostrarNotificacion( intval($resultado) );
            if($mensaje){ ?>
                <p class="alerta exito"> <?php echo s($mensaje) ?>  </p>
            <?php } ?>
            <?php } ?>
            
        
        

        <a href="/blog/crearblog" class="boton boton-verde">Nueva Entrada de blog</a>
        

        <h2>Blog</h2>
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>     <!--elemento de fila-->
                    <th>Titulo</th>
                    <th>Autor</th>
                    <th>Contenido</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody> <!--Mostrar los resultados-->
                <!--Itera sobre la base de datos-->
                <?php foreach ($blogs as $blog): ?>
                    <tr>
                        <td> <?php echo $blog->id; ?> </td>
                        <td> <?php echo $blog->titulo; ?> </td>
                        <td> <?php echo $blog->autor; ?> </td>
                        <td> <?php echo substr( $blog->contenido, 0, 25 ) . '...'; ?> </td>
                        <td> <img src="/imagenes/blog/<?php echo $blog->imagen; ?>" class="imagen-tabla"> </td>
                        
                        <td>
                            <form method="POST" class="w-100" action="/blog/eliminarblog">
                                <input type="hidden" name = "id" value="<?php echo $blog->id ?>">
                                <input type="hidden" name = "tipo" value="blog">
                                <input type="submit" class="boton-rojo-block" value="Eliminar">
                            </form>
                            <a href="/blog/actualizarblog?id=<?php echo $blog->id;?>" class="boton-amarillo-block">Actualizar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>