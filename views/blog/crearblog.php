<main class="contenedor seccion">
        <h1>Crear entrada de Blog</h1>

        <!--Codigo para mostrar al usuario si existen errores en el formulaio-->
        <?php foreach($errores as  $error): ?>  <!--crea un alias para el array $errores-->
            <div class="alerta error">
                <?php echo $error; ?>       <!--se imprimen los errores generados-->
            </div>
        <?php endforeach; ?>
        <a href="/adminblog" class="boton boton-verde">Volver</a>
        <form class="formulario" method="POST" enctype="multipart/form-data">
            <?php include __DIR__ . '/formulario.php'; ?>
            <input type="submit" value="Crear Entrada" class="boton boton-verde">
        </form>
</main>