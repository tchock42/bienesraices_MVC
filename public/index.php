<?php
require_once __DIR__ . '/../includes/app.php'; //conexion a la base de datos funciones y autoload

use Controllers\BlogController;
use Controllers\LoginController;
use MVC\Router;
use Controllers\PropiedadController;
use Controllers\VendedorController;
use Controllers\PaginasController;

$router = new Router();
// echo "<pre>";
// var_dump($router);
// echo "</pre>";

// debuggear(PropiedadControllers::class); //imprime el namespace donde se encuentra la clase
//imprime string(32) "Controllers\PropiedadControllers"

//llama al metodo que asigna las urls con su function
//Asociado al Router            //Asociado al controlador
//zona privada
$router->get('/admin', [PropiedadController::class, 'index']); //[clase del metodo, metodo]

$router->get('/propiedades/crear', [PropiedadController::class, 'crear']);
$router->post('/propiedades/crear', [PropiedadController::class, 'crear']);
$router->get('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
$router->post('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
$router->post('/propiedades/eliminar', [PropiedadController::class, 'eliminar']);

$router->get('/vendedores/crear', [VendedorController::class, 'crear']);
$router->post('/vendedores/crear', [VendedorController::class, 'crear']);
$router->get('/vendedores/actualizar', [VendedorController::class, 'actualizar']);
$router->post('/vendedores/actualizar', [VendedorController::class, 'actualizar']);
$router->post('/vendedores/eliminar', [VendedorController::class, 'eliminar']);

$router->get('/adminblog', [BlogController::class, 'indexblog']); //pagina donde el admin visualiza las propiedades 
$router->get('/blog/crearblog', [BlogController::class, 'crearblog']); //admin crea entrada
$router->post('/blog/crearblog', [BlogController::class, 'crearblog']); //admin da clic en crear entrada
$router->get('/blog/actualizarblog', [BlogController::class, 'actualizarblog']); //admin actualiza entrada
$router->post('/blog/actualizarblog', [BlogController::class, 'actualizarblog']); //admin da clic para actualizar entrada
$router->post('/blog/eliminarblog', [BlogController::class, 'eliminarblog']); //admin elimina entrada

//zona publica
//pagina principal
$router->get('/', [PaginasController::class, 'index']);
$router->get('/nosotros', [PaginasController::class, 'nosotros']);
$router->get('/propiedades', [PaginasController::class, 'propiedades']);
$router->get('/propiedad', [PaginasController::class, 'propiedad']);

$router->get('/contacto', [PaginasController::class, 'contacto']);
$router->post('/contacto', [PaginasController::class, 'contacto']);
$router->post('/entrada', [PaginasController::class, 'entrada']); //para enviar el formulario

//blog
$router->get('/blog', [BlogController::class, 'blog']);  //usuarios viualizan blog
$router->get('/entrada', [BlogController::class, 'entrada']); //usuario visualiza entrada

//login y autenticación
$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

$router->comprobarRutas();