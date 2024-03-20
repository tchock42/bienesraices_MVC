<fieldset>
    <legend>Información General</legend>
        <label for="titulo">Titulo:</label>
        <input type="text" id="titulo" name="blog[titulo]" placeholder="Titulo de la entrada de Blog" value="<?php echo s( $blog->titulo ); ?>">

        <label for="autor">Autor:</label>
        <input type="text" id="autor" name="blog[autor]" placeholder="Nombre de Autor"  value="<?php echo s( $blog->autor ); ?>">

        <label for="contenido">Contenido:</label>
        <textarea id="contenido" name="blog[contenido]"> <?php echo s($blog->contenido); ?> </textarea>
</fieldset>
<fieldset>
    <legend>Información extra</legend>
        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" accept="image/jpeg image/png" name="blog[imagen]">
        <?php if($blog->imagen){ ?>
                    <img src="/imagenes/blog/<?php echo $blog->imagen ?>" class="imagen-small">
                <?php } ?>
                
        
</fieldset>

                
           