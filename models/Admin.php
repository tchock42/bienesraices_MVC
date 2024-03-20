<?php

namespace Model;

class Admin extends ActiveRecord{
    protected static $tabla = 'usuarios'; //tabla de usuarios en la BD
    protected static $columnasDB = ['id', 'email', 'password'];

    public $id;
    public $email;
    public $password;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validar(){
        if(!$this->email){
            self::$errores[] = 'El email es obligatorio';
        }
        if(!$this->password){
            self::$errores[] = 'El password es obligatorio';
        }

        return self::$errores;
    }
    public function existeUsuario(){ //revisa si existe un usuario con el correo dado
        //revisar si un usuario existe
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT  1";
        // debuggear($query);
        $resultado = self::$db->query($query);
        // debuggear($resultado);

        if(!$resultado->num_rows){ //revisa que num_rows tenga algo, si no, no existe el usuario
            self::$errores[] = "El usuario no existe"; //no existe el usuario
            return; //si no existe usuario, deja de ejecutarse el codigo
        }
        //si si existe el usuario
        return $resultado; 
    }
    public function comprobarPassword($resultado){
        $usuario = $resultado->fetch_object(); //extra de resultado lo que se encontró en la base de datos
        // debuggear($this);
        $autenticado = password_verify($this->password, $usuario->password); //retorna true si coinciden
        
        //autenticado es true si coincide, false si no 
        if( !$autenticado){ //si no está autenticado
            self::$errores[] = 'El password es incorrecto';
        }
        return $autenticado;
    }
    public function autenticar(){
        session_start();
        // debuggear($_SESSION);
        //llenar el arreglo de sesion
        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;

        header('Location: /admin');
    }
}
