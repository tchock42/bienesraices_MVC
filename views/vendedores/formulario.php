<fieldset>
    <legend>Información General</legend>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre Vendedor(a)" value="<?php echo s( $vendedor->nombre ); ?>">
    
    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido Vendedor(a)" value="<?php echo s( $vendedor->apellido ); ?>">
</fieldset>

<fieldset>
    <legend>Información Extra</legend>

    <label for="imagen">Fotografía:</label>
    <input type="file" id="imagen" accept="image/jpeg image/png" name="vendedor[imagen]">

    <?php if($vendedor->imagen){ ?>
        <img src="/fotos/<?php echo $vendedor->imagen ?>" class="imagen-small">
    <?php } ?>

    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" name="vendedor[telefono]" placeholder="Telefono del Vendedor(a)" value="<?php echo s( $vendedor->telefono ); ?>">
</fieldset>