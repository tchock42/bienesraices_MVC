<?php

namespace Model;

class Blog extends ActiveRecord{
    protected static $tabla = 'blogs';
    protected static $columnasDB = ['id', 'titulo', 'fecha', 'autor', 'contenido', 'imagen'];

    public $id;
    public $titulo;
    public $fecha;
    public $autor;
    public $contenido;
    public $imagen;

    public function __construct($args=[])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->fecha = date('Y/m/d');
        $this->autor = $args['autor'] ?? '';
        $this->contenido = $args['contenido'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
    }

    public function validar(){
        // debuggear($this);
        //Validaciones del formulario. Revisa si el $_POST tiene elementos vacíos
        if(!$this->titulo){ //revisa que el arreglo este vacío
            self::$errores[] = "El titulo de la entrada de blog es obligatorio";
        }
        if(!$this->autor){ //revisa que el arreglo este vacío
            self::$errores[] = "El nombre del autor es obligatorio";
        }
        if(strlen($this->contenido) < 50 ){ //revisa que el arreglo este vacío
            self::$errores[] = "El contenido de la entrada de blog es obligatoria y debe contener más de 50 carcteres";
        }
        if(!$this->imagen){ //revisa que el arreglo este vacío
            self::$errores[] = "El telefono del vendedor es obligatorio";
        }


        return self::$errores; //Vendedor::$errores
    }
       //elimina archivo
    public function borrarImagen(){
        // debuggear($this);
        // Comprobar si existe el archivo
        $existeArchivo = file_exists(IMAGENES_BLOG . $this->imagen);
        // echo IMAGENES_BLOG . $this->imagen;
        // echo "<pre>";
        // var_dump($this);
        // echo "</pre>";
        // debuggear($existeArchivo);
        // var_dump(empty($this->imagen));
        // debuggear(is_null($this->imagen));
        if($existeArchivo){ //si existe el archivo
            // echo "No deberías ver esto";
            unlink(IMAGENES_BLOG . $this->imagen); //se elimina de la carpeta
            //$this->imagen hace referencia al  objeto, no al argumento $imagen
        }
        
    }
    public function crear(){
        // echo "guardando en la base de datos";
        
        //sanitizar la entrada de datos llamando a un metodo dentro de otro metodo
        $atributos = $this->sanitizarAtributos();
        // debuggear($atributos);
        //insertar en la base de datos creando la sentencia mysql usando el array atributos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ('";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";
        // debuggear($query);
        //se pasa la sentencia mysql con self porqu es estatico y se usa el metodo query pasandole el query
        $resultado=self::$db->query($query); 
        
        //Mensaje de exito o error
        if($resultado){
            // echo "Insertado Correctamente";
            header('Location: /adminblog?resultado=1');
        }
    }

    public function actualizar(){
        //sanitizar los datos
        $atributos = $this->sanitizarAtributos(); //crea un arreglo asociativo con los datos del registro en memoria
                                                //crea internamente un arreglo identico pero sanitizado
        $valores = [];
        foreach($atributos as $key => $value){
            $valores[] = "{$key} = '{$value}'";
        }
        $query = "UPDATE " . static::$tabla . " SET "; //construye el enunciado SQL
        $query .= join(', ', $valores );    //une los elementos del array asociativo
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";
        
        $resultado = self::$db->query($query); //ejecuta el query en el objeto
        
        if($resultado){
            //redirecciona a /admin
            header('Location: /adminblog?resultado=2');
        }
    }
        //eliminar un registro
        public function eliminar(){
            $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
            $resultado = self::$db->query($query);
    
            if($resultado){
                $this->borrarImagen();
                //redirecciona a /admin
                header('Location: /adminblog?resultado=3');
            }
        }
}
