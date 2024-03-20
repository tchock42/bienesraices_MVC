<?php
    if(!isset($_SESSION)){
        session_start();
    }
    
    // var_dump($_SESSION);
    $auth = $_SESSION['login'] ?? false; //si no esta definido session, asigna null
    // var_dump($auth);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes raices</title>
    <link rel="stylesheet" href="/build/css/app.css"> 
    <!--El / al inicio de la dirección indica que html debe buscar en la raiz del proyecto una carpeta llamada build-->
    <link rel="preload" href="">
</head>
<body>
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="index.php">
                    <img class="logo-header" src="/build/img/logo.svg" alt="logotipo de Bienes Raices">
                </a>

                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="icono menu responsive">
                </div>
                <div class="derecha">
                    <img src="/build/img/dark-mode.svg" class="dark-mode-boton">
                    <nav class="navegacion">
                        <a href="/nosotros.php">Nosotros</a>
                        <a href="/anuncios.php">Anuncios</a>
                        <a href="/blog.php">Blog</a>
                        <a href="/contacto.php">Contacto</a>
                        <?php if($auth): ?>
                            <a href="/cerrar-sesion.php">Cerrar Sesión</a>
                        <?php endif; ?>
                    </nav>
                </div>
                
            </div><!--cierre de la barra-->

            <?php if($inicio){ ?>
                <h1>Venta de Casa y Departamentos Exclusivos de Lujo</h1>
            <?php } ?>
        </div>
    </header>