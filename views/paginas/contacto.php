<main class="contenedor seccion">
    <h1>Contacto</h1>

    <?php 
    if ($mensaje){ ?>
        <p class='alerta exito'> <?php echo $mensaje; ?>  </p>;

    <?php }    ?>

    <picture>
        <source srcset="build/img/destacada3.webp" type="image/webp">
        <source srcset="build/img/destacada3.jpg" type="image/jpeg">
        <img loading="lazy" src="build/img/destacada3.jpg" alt="Imagen Contacto">
    </picture>
        
    <h2>Llene el formulario de Contacto</h2>

    <form action="" class="formulario" action="/contacto" method="POST" >
        <fieldset>
            <legend>Informacion Personal</legend>
            <label for="nombre">Nombre</label>
            <input type="text" placeholder="Tu Nombre" id="nombre" name="contacto[nombre]" >

            <label for="mensaje">Mensaje</label>
            <textarea id="mensaje" name="contacto[mensaje]" ></textarea>
        </fieldset>
        <fieldset>
            <legend>Información Sobre la Propiedad</legend>

            <label for="mensaje">Vende o Compra</label>
            <select id="opciones" name="contacto[tipo]" >
                <option value="" disabled selected>-- Seleccione --</option>
                <option value="Compra">Compra</option>
                <option value="Vende">Vende</option>
            </select>
            <label for="mensaje">Precio o Presupuesto</label>
            <input type="number" placeholder="Tu Precio o Presupuesto" id="presupuesto" name="contacto[precio]" >
        </fieldset>

        <fieldset>
            <legend>Información sobre la Propiedad</legend>
            <p>Cómo desea ser contactado</p>
            <div class="forma-contacto">
                <label for="contactar-telefono">Teléfono</label>
                <input type="radio" value="telefono" id="contactar-telefono" name="contacto[contacto]" >

                <label for="contactar-email">E-mail</label>
                <input type="radio" value="email" id="contactar-email" name="contacto[contacto]" >
            </div>

            <div id="contacto"></div>

        </fieldset>
        <input type="submit" value="enviar" class="boton-verde">
    </form>

</main>