<?php

//se declaran los controladores
namespace Controllers;
use MVC\Router;
// use Model\Propiedad;
use Model\Vendedor; 
use Intervention\Image\ImageManagerStatic as Image;

//clase controlador que va a tener asociada alguna funcion

class VendedorController{

    public static function crear( Router $router){ //necesita la instancia de Router
        $errores=Vendedor::getErrores();
        $vendedor = new Vendedor; //se crea un objeto vacío para que los inputs esten vacíos sin error

        if( $_SERVER["REQUEST_METHOD"] === 'POST'){//sI SE PRESIONA EL BOTON, EL METODO SE HACE POST PORQUE EL FORMULARIO ES POST
            
            //crear una nueva instancia de vendedor
            $vendedor = new Vendedor($_POST['vendedor']);
            
            //*****CODIGO DE IMAGEN ********//
            //generar el nombre del archivo
            $nombreFoto = md5(uniqid(rand(), true)) . ".jpg";
            
            //realizar resize
            if($_FILES['vendedor']['tmp_name']['imagen']){
                //generar el archivo
                $photo = Image::make($_FILES['vendedor']['tmp_name']['imagen'])->fit(400,300);
                //condigura el nombre con el vendedor
                $vendedor->setImagen($nombreFoto);
            } //si no se carga imagen, no se cumple este if
        
            //validar que no haya campos vacíos
            $errores = $vendedor->validar();   
        
            //si no hay errores
            if(empty($errores)){
                
        
                //crear la carpeta de fotos de vendedores
                if(!is_dir(CARPETA_FOTOS)){ //si no existe
                    mkdir(CARPETA_FOTOS);   //crea la carpeta
                    chmod(CARPETA_FOTOS, 0777); //otorta permisos necesarios
                }
                //guarda la imagen archivo en el servidor
                $photo->save(CARPETA_FOTOS . $nombreFoto);
                // debuggear($vendedor);
                //guarda el objeto en memoria en la base de datos
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/crear', [   
            'errores' => $errores,
            'vendedor' => $vendedor
        ]); //se llama al metodo para visualizar
    }

    public static function actualizar( Router $router){
        $id = validarORedireccionar('/admin'); //valida la url
        $vendedor = Vendedor::find($id); //busca la propiedad para desplegar

        $errores = Vendedor::getErrores(); //obtiene los errores

        if( $_SERVER["REQUEST_METHOD"] === 'POST'){//sI SE PRESIONA EL BOTON, EL METODO SE HACE POST PORQUE EL FORMULARIO ES POST
            //asignar los valores
            $args = $_POST['vendedor'];
            //sincronizar objeto en memoria con lo que el usario escribe
            $vendedor->sincronizar($args);
            // Generar el nombre del archivo
            $nombreFoto = md5(uniqid(rand(), true)) . ".jpg";
        
            if( $_FILES['vendedor']['tmp_name']['imagen'] ){
                //realizar el rezise
                $photo = Image::make($_FILES['vendedor']['tmp_name']['imagen'])->fit(800,600); //imagen se declara con el name del input file. //tmp_name es el nombre temporal del archivo en el servidor
        
                $vendedor->setImagen($nombreFoto); //borrar la imagen previa y asigna la nueva al objeto
            }
            $errores = $vendedor->validar();
            // debuggear($vendedor);
            if(empty($errores)){
                if( $_FILES['vendedor']['tmp_name']['imagen'] ){ //si la imagen se cargó
                    //almacenar la imagen en el directorio
                    $photo->save(CARPETA_FOTOS . $nombreFoto);
                }
                $vendedor->guardar();
            }
        }
        $router->render('vendedores/actualizar', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }

    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $tipo = $_POST['tipo'];

            //validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id){
                $tipo = $_POST['tipo'];

                if(validarTipoContenido($tipo)){
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }
        }
    }
}