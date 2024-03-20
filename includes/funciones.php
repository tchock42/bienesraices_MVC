<?php

define('TEMPLATES_URL', __DIR__ . '/templates'); //DIR permite acceder a la ruta especificac del archivo, ddesde c//:...
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');   //propiedades
define('CARPETA_FOTOS', $_SERVER['DOCUMENT_ROOT'] . '/fotos/');         //vendedores
define('IMAGENES_BLOG', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/blog/'); //blog

function incluirTemplate( string $nombre, bool $inicio = false ){ //asigna por default inicio como false
    include TEMPLATES_URL . "/$nombre.php"; //concatenacion de la ubicacion de  la direccion del template
}
function estaAutenticado(){
    session_start();
    // echo "<pre>";
    // var_dump($_SESSION['login']);
    // echo "</pre>";
    //revisa el stado de $_session
    if(!$_SESSION['login']){
        header('Location: /'); //si está autenticado, sale de la función
    }
}

function debuggear($variable){
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
//escapa / sanitizar el html
function s($html) : string{
    $s = htmlspecialchars($html);
    return $s;
}
//evalua si el tipo de contenido es valido
function validarTipoContenido($tipo){
    $tipos = ['vendedor', 'propiedad', 'blog'];
    return in_array($tipo, $tipos); //busca en $tipos si hay un tipo
                        //true si lo encuentra y false si no
}
//muestra las alertas
function mostrarNotificacion($codigo){
    $mensaje = '';
    switch($codigo){
        case 1:
            $mensaje = 'Creado correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado correctamente';
            break;
        case 3: 
            $mensaje = 'Eliminado correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;
}
function validarORedireccionar(string $url){
    //validar la url por id valido
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT); //el id obtenido es de tipo int
    // var_dump($id);
    if(!$id){
        header("Location: $url"); //si id no esta definido, retorna a index.php
    }
    return $id;
}