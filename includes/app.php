<?php

use Model\ActiveRecord; //se carga el namespace de clase Propiedad
require __DIR__ . '/../vendor/autoload.php'; //diagonal para salirnos de includes. Autoload para clases de composer

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); //se extrae dependencia de dotenv y la registra en esta carpeta
$dotenv->safeLoad();                               //metodo de safeload para usar las variables de entorno


require 'funciones.php'; //funciones de db y templates
require 'config/database.php'; //conexion a la base de datos

// $propiedad = new Propiedad; //se instancia la clase Propiedad vacía
// var_dump($propiedad); //se imprime el objeto propiedad vacio

//conectarnos a la base de datos
$db = conectarDB(); //crea una nueva instacia de conexionde db


//al ser estático, no requiere instanciarse
//esta es la configuración de la base de datos, de aqui los metodos en Propiedad funcionan
ActiveRecord::setDB($db); //todos los objetos debajo de Propiedad tendran la referencia d la base de datos