<main class="contenedor seccion">
        <h1>Actualizar Vendedor(a)</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <!--Codigo para mostrar al usuario si existen errores en el formulaio-->
        <?php foreach($errores as  $error): ?>  <!--crea un alias para el array $errores-->
        <div class="alerta error">
            <?php echo $error; ?>       <!--se imprimen los errores generados-->
        </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <?php include 'formulario.php'; ?>
            <input type="submit" value="Guardar Cambios" class="boton-verde boton">
        </form>
    </main>