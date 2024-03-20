<?php

namespace Model;

class ActiveRecord {
    //es protected porque solo se va a acceder a la base de datos desde la clase
    //es static porque siempre se va a usar la misma conexion a la base de datos
    protected static $db; //no forma parte del constructor, no se va a reescribir nunca, solo es la referencia a la base de datos
    //este $db ya se configuró con la conexión a la base de datos en app.php
    //variable columnasDB para iterar en cada atributo
    protected static $columnasDB = [];
    protected static $tabla = '';
    
    //Errores. La variable es protected porque solo la clase es capaz de modificarla
    //static porque no va requerir instanciarse
    protected static $errores = [];
    
    
    //al ser el objeto $db estatico, el metodo tambien tiene que se estatico
    //al ser $db protected, se debe acceder solo mediante un metodo
    //definir la conexion a la base de datos
    public static function setDB($database){
        self::$db = $database;
    }

    public function guardar(){
        //tiene un id? si->actualiza | no->crea
        if(!is_null($this->id)) { //revisa si existe un id
            //is_null revisa si una variable tiene un valor nulo
            //actualizar
            $this->actualizar(); //actualiza
        }else{
            //creando un nuevo registro
            $this->crear();
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
        $query .= "') ";
        // debuggear($query);
        //se pasa la sentencia mysql con self porqu es estatico y se usa el metodo query pasandole el query
        $resultado=self::$db->query($query); 
        
        //Mensaje de exito o error
        if($resultado){
            // echo "Insertado Correctamente";
            header('Location: /admin?resultado=1');
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
            header('Location: /admin?resultado=2');
        }
    }

    //eliminar un registro
    public function eliminar(){
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado){
            $this->borrarImagen();
            //redirecciona a /admin
            header('Location: /admin?resultado=3');
        }
    }


    //funcion para iterar en cada columna de la base de datos
    //identificar y unir los atributos de la base de datos
    public function atributos(){
        $atributos = []; //este va a iterar en los atributos (en una columna)
        foreach(static::$columnasDB as $columna){
            if($columna === 'id') continue; //cuando llegue a id lo ignora
            //queremos ignorar id porque cuando se crea un nuevo registro, el id no existe
            //columna lleva $ porque no es propiedad o atributo. Es una variable del foreach
            $atributos[$columna] = $this->$columna; //se crea un nuevo arreglo con los atributos y datos del objeto
            // echo $this->$columna;
            
            //$this->columna lleva el valor del objeto en memoria
        }
        return $atributos;
    }
 
    public function sanitizarAtributos(){
        $atributos = $this->atributos(); //mapear las columnas con el objeto en memoria 
        $sanitizado = [];   //guarda los elementos sanitizados
        // debuggear($atributos);
        //se hace un abarrido en cada elemento de atributos, pero se hace referencia a cada llave y valor de cada arreglo asociativo
        //porque atributos es un arreglo de arreglos asociativos
        foreach($atributos as $key => $value){
            $sanitizado[$key] = self::$db->escape_string($value); //sanitiza antes de que se almacenen en base de datos
        }
        // debuggear($sanitizado);
        return $sanitizado;
    }   

    //subida de rchivos
    public function setImagen($imagen){
        //elimina la imagen previa
        if ( !is_null( $this->id )){ //si se está editando
            $this->borrarImagen(); //llama al metodo que borra la imagen

        }
        //asignar al atributo de imagen el nombre de la imagen
        if($imagen){
            $this->imagen= $imagen;
        }
    }

    //elimina archivo
    public function borrarImagen(){
        
    }

    //validacion -> metodo para validar
    public static function getErrores(){ //El metodo getErrores por si solo no hace nada, se reeescribe en las clases hijo
        return static::$errores;
    }
    public function validar(){
        static::$errores = []; //se borra el contenido cada vez que se haga la validacion
        //static por para que vaya al atributo $errores en la clase hijo 
        return static::$errores;
    }
    //Lista todas las propiedades
    public static function all(){
        $query = "SELECT * FROM " . static::$tabla;
        // debuggear($query);
        $resultado = self::consultarSQL($query);
        
        return $resultado; //retorna la consulta de la base de datos como 
                            //un array de objetos
        
    }

    //Obtiene determinado numero de registros
    public static function get($cantidad){
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;

        // debuggear($query);
        $resultado = self::consultarSQL($query);
        
        return $resultado; //retorna la consulta de la base de datos como 
                            //un array de objetos
        
    }
    //busca un registro por su id para actualizar
    //static porque no se requiere una nueva instancia
    //pblic porque se va a acceder desde un archivo actualizar.php
    public static function find($id){
        $query = "SELECT * FROM " . static::$tabla ." WHERE id = $id";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }


    public static function consultarSQL($query){
        //consultar la base de datos
        $resultado = self::$db->query($query);
        //iterar los resultados
        $array = []; //en cada iteración se va a ir llenando con cada objeto
        while($registro = $resultado->fetch_assoc()){ //registro es un arreglo
            $array[] = static::crearObjeto($registro); //active Record solo maneja objetos en memoria
        }
        // debuggear($array);

        //liberar la memoria
        $resultado->free();

        //retornar los resultados
        return $array;
    }
    protected static function crearObjeto( $registro ){ //pprotected porque solo es usado por la clase
        //crea nuevos objetos
        $objeto = new static; //nueva propiedad de la clase padre, solo tiene las etiquetas
        // debuggear($registro);
        foreach($registro as $key => $value){   //itera en el array registro
            if(property_exists($objeto, $key)){ //evalua si key exite en objeto
                $objeto->$key = $value; //asigna al objeto el atributo key y su valor
            }
        }
        return $objeto;
    }

    //sincroiza el objeto en memoria del metodo find con los cambios realizados por el usuario
    public function sincronizar( $args = [] ){
        foreach($args as $key => $value ){
            if(property_exists($this, $key) && !is_null($value)){ //si existe el key de args en $propiedad actual, se cumple el if
                //sustituye el valor de la propiedad del objeto en memoria
                //con el valor cargado desde args
                $this->$key = $value;   //si no tuviera el $ sería un atributo de la clase
                                        //de esta forma no se tiene que hacer uno por uno
                
            }
        }
    }
}