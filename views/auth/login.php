<main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>

        <?php endforeach; ?>

        <form method="POST" class="formulario" action="/login">
            <fieldset>
                <legend>Email y password</legend>
                <label for="email">Email</label>
                <input name="email" type="email" placeholder="Tu Email" id="email">

                <label for="password">Password</label>
                <input name = password type="password" placeholder="Tu Password" id="password">
            </fieldset>
            <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
        </form>
    </main>