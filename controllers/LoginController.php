<?php
namespace Controllers;
use MVC\Router;
use Model\Admin;

class LoginController{
    public static function login(Router $router){
        $errores = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Admin($_POST);

            $errores = $auth->validar();

            if(empty($errores)){ //se ingresan correo y contraseña reales
                //verificar si el usuario existe
                $resultado = $auth->existeUsuario(); //realiza la consulta mysql
                // debuggear($resultado); //resultado es un onjeto con num_rows etc
                
                if(!$resultado){ //si no hay un correo correcto
                    $errores = Admin::getErrores(); //recupera los errores. funcion estatica
                    // debuggear($errores); //el usuario no existe
                }else{ //
                    //verificar el password
                    $autenticado=$auth->comprobarPassword($resultado);
                    if($autenticado){ //si la contraseña coincide
                        //autenticar el usuario
                        $auth->autenticar();
                    }else{
                        //password incorrecto, mensaje de error
                        $errores = Admin::getErrores(); //recupera los errores, "el password es incorrecto"
                    }
                    
                }
                
            }
        }
        $router->render('auth/login', [
            'errores' => $errores
        ]);
    }
    public static function logout(){
        session_start(); //accede a la sesion actual
        $_SESSION = []; //cierra la sesion borrando el contenido del array
        header('Location: /');
    }
}