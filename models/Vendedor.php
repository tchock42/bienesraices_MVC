<?php

namespace Model;

class Vendedor extends ActiveRecord{
    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'imagen', 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $imagen;
    public $telefono;

    public function __construct($args=[])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar(){
        // debuggear($this);
        //Validaciones del formulario. Revisa si el $_POST tiene elementos vacíos
        if(!$this->nombre){ //revisa que el arreglo este vacío
            self::$errores[] = "El nombre del vendedor es obligatorio";
        }
        if(!$this->apellido){ //revisa que el arreglo este vacío
            self::$errores[] = "El apellido del vendedor es obligatorio";
        }
        if(!$this->imagen){ //revisa que el arreglo este vacío
            self::$errores[] = "La foto del vendedor es obligatorio";
        }
        if(!$this->telefono){ //revisa que el arreglo este vacío
            self::$errores[] = "El telefono del vendedor es obligatorio";
        }
        //revisa $telefono con expresion regular de 0-9 de 10 digitos
        if(!preg_match('/[0-9]{10}/', $this->telefono)){
            //si no hay una expresion regular en $telefono, hay error
            self::$errores[] = "El telefono no es válido";
        }

        return self::$errores; //Vendedor::$errores
    }
    //elimina archivo
    public function borrarImagen(){
        
        // Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_FOTOS . $this->imagen);
        // var_dump(empty($this->imagen));
        // debuggear(is_null($this->imagen));
        if($existeArchivo && !empty($this->imagen)){ //si existe el archivo
            // echo "No deberías ver esto";
            unlink(CARPETA_FOTOS . $this->imagen); //se elimina de la carpeta
            //$this->imagen hace referencia al  objeto, no al argumento $imagen
        }
        
    }
}