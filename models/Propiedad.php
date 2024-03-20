<?php
namespace Model;

class Propiedad extends ActiveRecord{ //creacion de la clase php 7
    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public function __construct($args=[])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? ''; //args deben coincidir con las keys de post
    }
    public function validar(){
        //Validaciones del formulario. Revisa si el $_POST tiene elementos vacíos
        if(!$this->titulo){ //revisa que el arreglo este vacío
            self::$errores[] = "Debes escribir un titulo";
        }
        if(!$this->precio){
            self::$errores[] = "El campo de precio es obligatorio";
        }
        if(strlen($this->descripcion) < 50 ){
            self::$errores[] = "El campo de descripción es obligatorio y debe tener a menos 50 caracteres";
        }
        if(!$this->habitaciones){
            self::$errores[] = "El campo de habitaciones es obligatorio";
        }
        if(!$this->wc){
            self::$errores[] = "El campo de WC es obligatorio";
        }
        if(!$this->estacionamiento){
            self::$errores[] = "El campo de estacionamiento es obligatorio";
        }
        if(!$this->vendedores_id){
            // var_dump($this->vendedores_id);
            self::$errores[] = "Selecciona un vendedor";
        }
        if(!$this->imagen){
            
            self::$errores[] = "La imagen de la propiedad es obligatoria";
        }
        //ya no es necesario validar el tamaño de la imagen por el resizing que se hizo
        return self::$errores;
    }
    //elimina archivo
    public function borrarImagen(){
        // debuggear(CARPETA_IMAGENES . $this->imagen);
        // Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        
        if($existeArchivo){ //si existe el archivo
            unlink(CARPETA_IMAGENES . $this->imagen); //se elimina de la carpeta
            //$this->imagen hace referencia al  objeto, no al argumento $imagen
        }
        
    }
}
