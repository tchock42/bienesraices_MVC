<main class="contenedor seccion">
        <h1>Más Sobre Nosotros</h1>
        <?php include 'iconos.php' ?>
    </main>
    <section class="seccion contenedor">
        <h2>Casas y Depas en Venta</h2>

        <?php
            $limite = 3;
            include 'listado.php';
        ?>

        <div class="alinear-derecha">
            <a href="/propiedades" class="boton-verde alinear-derecha">Ver todas</a>
        </div>
    </section>
    
    <section class="imagen-contacto">
        <h2>Encuentra la casa de tus sueños</h2>
        <p>Llena el formulario de contacto y un asesor se pondrá en contacto contigo a la brevedad.</p>
        <a href="/contacto" class="boton-amarillo">Contáctanos</a>
    </section>
    
    <div class="contenedor seccion seccion-inferior">
        <section class="blog">
            <h3>Nuestro Blog</h3>

            <?php include 'listadoblog.php'; ?>
            
        </section>

        <section class="testimoniales">
            <h3>Testimoniales</h3>
            <div class="testimonial">
                <blockquote>
                    El personal se comportó de una excelente forma, muy buena atención y la casa  que me
                    ofrecieron cumple con todas mis expectativas.
                </blockquote>
                <p>- Jacob Gómez Carrillo</p>
            </div>
        </section>
    </div>