<?php

namespace MVC;

class Router{
    //al crear un objeto Router solo contiene estos dos atributos
    public $rutasGET = [];
    public $rutasPOST = [];

    //key = url | value = funcion asociada
    //asigna al objeto el controlador y su metodo
    public function get($url, $fn){
        $this->rutasGET[$url] = $fn;
        // debuggear(($this->rutasGET[$url]));
        //debuggear imprime un array asoc con 
        //[0] Controllers\PropiedadController
        //[1] "index"
    }
    public function post($url, $fn){
        $this->rutasPOST[$url] = $fn;
        
    }
    //comprueba la url actual y el tipo de reques method
    public function comprobarRutas(){
        session_start(); //inicia sesion para verificar que la ruta está protegida
        $auth=$_SESSION['login'] ?? null;
        // debuggear($auth);
        //arreglo de rutas protegidas
        $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar', '/adminblog', '/blog/crearblog', '/blog/actualizarblog', '/blog/eliminarblog'];

        //lee la url en la que se encuentra
        $urlActual = strtok($_SERVER['REQUEST_URI'], '?') ?? '/'; //url actual separada por el ? o solo el '/'
        // debuggear($urlActual);  
        $metodo = $_SERVER['REQUEST_METHOD'];
        
        if($metodo === 'GET'){ //si la url no es valida, se asigna '/'
            // var_dump($this); //imprime el objeto con todas las url y sus metodos
            // var_dump($this->rutasGET[$urlActual]);
            //aqui fn es un arreglo asoc con el [0] controlador y [1] el metodo
            $fn = $this->rutasGET[$urlActual] ?? null;
        }else{
            $fn = $this->rutasPOST[$urlActual] ?? null; //contiene el controlador [0]=> Controllers\PropiedadController y [1] => "crear"     
        }

        //proteger las rutas
        if(in_array($urlActual, $rutas_protegidas) && !$auth){ //in_array retorna true si existe el elemento buscado
            header('Location: /');
        }

        if($fn){
            // echo "<pre>";
            // var_dump($fn); //Hasta aqui va bien
            // echo "</pre>";
            //la url existe y hay una funcion asociada
            //busca el callback que tiene fn en la instancia del objeto $this
            call_user_func($fn, $this);   //llama al metodo que este asociada a la ruta del controlador
        }else{
            echo "Página no encontrada";
        }
    }
    //Muestra una vista o renderizacion de la pagina web
    public function render($view, $datos = []){ //(pagina a ser vista, arreglo de datos)
        foreach($datos as $key => $value){ //recorre el arreglo $datos
            $$key = $value; //usando el primer elemento, equivale a $mensaje = 'Desde la vista';
                            //despues sería $propiedades = 'Casa';
                            //finlamente $propiedades = $propiedades
        }
        //para admin, el foreach crea $propiedades y $resultado
        ob_start(); //inicia el almacenamiento en memoria
        //__DIR__ es el directorio actual, la raiz + pagina a ser vista
        include __DIR__ . "/views/$view.php";  //almacena la pagina view.php en memoria
        $contenido = ob_get_clean(); //se limpia el buffer en $contenido para desplegar
        //este contenido se va a desplegar en layout
        include __DIR__ . "/views/layout.php";
    }
}