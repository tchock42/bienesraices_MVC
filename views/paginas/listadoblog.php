<?php foreach($blogs as $blog){ ?>
    <?php $resumen = substr($blog->contenido, 0, 75); ?>
        <article class="entrada-blog">
            <div class="imagen">
                    <img src="/imagenes/blog/<?php echo $blog->imagen; ?>" alt="Texto Entrada Blog" loading="lazy">
            </div>
            <div class="texto-entrada">
                <a href="/entrada?id=<?php echo $blog->id; ?>">
                    <h4> <?php echo $blog->titulo ?></h4>
                    <p class="informacion-meta">Escrito el: <span><?php echo $blog->fecha?> </span> por: <span><?php echo $blog->autor ?> </span> </p>
                    <p>
                        <?php echo $resumen . '... [LEER MAS]'; ?>
                    </p>
                </a>
            </div>
        </article>
<?php } ?>