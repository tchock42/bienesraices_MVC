<?php 
//se declaran los controladores
namespace Controllers; // namespace de controllers
use MVC\Router;
use Model\Propiedad; //importa el modelo de Propiedad de Bienes Raices
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;     

//controlador que va a tener asociada alguna funcion
class PropiedadController{

    public static function index(Router $router){ //si tiene static no se tiene que instanciar
        //en el argumento pasa la referencia del objeto para que no se tenga que hacer otra instancia

        $propiedades = Propiedad::all(); //importa de la base de datos las propiedades
        $vendedores = Vendedor::all();

        $resultado = $_GET['resultado'] ?? null; //obtiene el resultado de la barra de direcciones
        $router->render('propiedades/admin', [ //pasa la ubicacion de admin.php
            // 'mensaje' => 'Desde la vista',      //info para desplegar en admin.php dentro del layout
            // 'propiedades' => 'Casa'
            'propiedades' => $propiedades, //pasa un array asoc etique propiedades con $propiedades
            'resultado' => $resultado,       //un elemento del array con resultado
            'vendedores' => $vendedores
        ]);
        
    }
    public static function crear(Router $router){
        $propiedad = new Propiedad; //carga un objeto vacío
        $vendedores = Vendedor::all(); //carga todos los vendedores
        
        //arreglo con mensajes de errores
        $errores = Propiedad::getErrores();

        if( $_SERVER["REQUEST_METHOD"] === 'POST'){//sI SE PRESIONA EL BOTON, EL METODO SE HACE POST PORQUE EL FORMULARIO ES POST
                    //crea un objeto propiedad con atributos tomados del POST, enviado por el usuario
            //crea una nueva instancia
            $propiedad = new Propiedad($_POST['propiedad']); 
            //Generar un nombre único
            //este es el nombre del archivo
            $nombreImagen = md5( uniqid( rand(), true)) . ".jpg"; //md5 crea un string, se puede concatenar
            //setear la imagen
            //realiza un resize a la imagen con intervention
            if( $_FILES['propiedad']['tmp_name']['imagen'] ){ //si la imagen cargó
                //este es el archivo
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600); //imagen se declara con el name del input file. //tmp_name es el nombre temporal del archivo en el servidor
                $propiedad->setImagen($nombreImagen);
            }
            // debuggear($_SERVER['DOCUMENT_ROOT']);
            //validar 
            $errores = $propiedad->validar();
        
            //Revisar que el arreglo de errores esté vacío con la funcion
            if(empty($errores)){ //si está vacío, no hay errores e inserta en la base de datos
                
                //Crear una carpeta
                //usa la constante CARPETA_IMAGENES de funciones.php
                if(!is_dir(CARPETA_IMAGENES)){  //no existe una carpeta con esta dirección?
                    mkdir(CARPETA_IMAGENES);    //si no, crea la carpeta
                    chmod(CARPETA_IMAGENES, 0777); //otorga los permisos necesarios a la ubicacion
                }
    
                //Guarda la imagen en elservidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);          
               
                //Guarda en la basede datos
                $propiedad->guardar();           
            }
        }
        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }
    public static function actualizar(Router $router){
        $id = validarORedireccionar('/admin');
        $propiedad = Propiedad::find($id); //busca la propiedad para desplegar
        $vendedores = Vendedor::all(); //carga todos los vendedores
        $errores = Propiedad::getErrores(); //obtiene los errores de Propiedad

        if( $_SERVER["REQUEST_METHOD"] === 'POST'){//sI SE PRESIONA EL BOTON, EL METODO SE HACE POST PORQUE EL FORMULARIO ES POST
            // debuggear($_FILES['vendedor']['tmp_name']['imagen']);
            //asignar los valores
            $args = $_POST['propiedad'];
            //sincronizar objeto en memoria con lo que el usario escribe
            $propiedad->sincronizar($args);
            
            // debuggear($errores);
            //  Generar el nombre del archivo
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        
            if( $_FILES['propiedad']['tmp_name']['imagen'] ){
                //realizar el rezise
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600); //imagen se declara con el name del input file. //tmp_name es el nombre temporal del archivo en el servidor
        
                $propiedad->setImagen($nombreImagen); //borrar la imagen previa y asigna la nueva al objeto
            }
            $errores = $propiedad->validar();
            
            if(empty($errores)){
                if( $_FILES['propiedad']['tmp_name']['imagen'] ){ //si la imagen se cargó
                    //almacenar la imagen en el directorio
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
                $propiedad->guardar();
            }
        }

        $router->render('/propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores
        ]);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){ //si se da clic al boton hidden con metodo post
            // debuggear($_POST);
            $id = $_POST['id']; //id extraído de la global post del boton hidden
            $id = filter_var($id, FILTER_VALIDATE_INT); //valida que la entrada sea exactamente entero

            if($id){
    
                $tipo = $_POST['tipo'];
                // debuggear($tipo);
                if(validarTipoContenido($tipo)){
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }           
            }
        }
    }
}