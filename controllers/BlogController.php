<?php
namespace Controllers; //namespace declarado en composer

use MVC\Router; //
use Model\Blog; //clase Blog
use Intervention\Image\ImageManagerStatic as Image;

class BlogController{
    public static function indexblog(Router $router){
        $blogs = Blog::all();

        $resultado = $_GET['resultado'] ?? null; //obtiene el resultado de la barra de direcciones
        $router->render('blog/adminblog', [
            'resultado' => $resultado,
            'blogs' => $blogs
        ]);
    }

    public static function crearblog(Router $router){
        $errores = Blog::getErrores();
        $blog = new Blog; // objeto vacio para que aparezca vacíos los inputs

        if( $_SERVER["REQUEST_METHOD"] === 'POST'){//sI SE PRESIONA EL BOTON, EL METODO SE HACE POST PORQUE EL FORMULARIO ES POST
            // echo "<pre>";
            // var_dump($_FILES); 
            // echo "</pre>";
            // debuggear($_POST);

            //crear una nueva instancia de blog
            $blog = new Blog($_POST['blog']);
            
            //*****CODIGO DE IMAGEN ********//
            //generar el nombre del archivo
            $nombreblog = md5(uniqid(rand(), true)) . ".jpg";
            
            //realizar resize
            if($_FILES['blog']['tmp_name']['imagen']){
                //generar el archivo
                $photo = Image::make($_FILES['blog']['tmp_name']['imagen'])->fit(400,300);
                //condigura el nombre con el vendedor
                $blog->setImagen($nombreblog);
            } //si no se carga imagen, no se cumple este if
        
            //validar que no haya campos vacíos
            $errores = $blog->validar();   
            //si no hay errores
            if(empty($errores)){
                //crear la carpeta de fotos de vendedores
                if(!is_dir(IMAGENES_BLOG)){ //si no existe
                    mkdir(IMAGENES_BLOG);   //crea la carpeta
                    chmod(IMAGENES_BLOG, 0777); //otorta permisos necesarios
                }
                //guarda la imagen archivo en el servidor
                $photo->save(IMAGENES_BLOG . $nombreblog);
                // debuggear($photo);
                //guarda el objeto en memoria en la base de datos
                
                $blog->guardar();
            }
        }

        $router->render('blog/crearblog',[
            'errores' => $errores,
            'blog' => $blog
        ]);
    }


    public static function blog(Router $router){
        $blogs = Blog::all();

        $router->render('paginas/blog', [    
            'blogs' => $blogs
        ]);
    }
    public static function entrada(Router $router){
        $id = validarORedireccionar('/blog');
        //buscar la entrada de blog por id
        $blog = Blog::find($id);

        $router->render('paginas/entrada', [
            'blog' => $blog
        ]);
    }
    public static function actualizarblog(Router $router){
        $id = validarORedireccionar('/adminblog');
        $blog = Blog::find($id);
        $errores = Blog::getErrores();

        if( $_SERVER["REQUEST_METHOD"] === 'POST'){//sI SE PRESIONA EL BOTON, EL METODO SE HACE POST PORQUE EL FORMULARIO ES POST
            // debuggear($_FILES['vendedor']['tmp_name']['imagen']);
            //asignar los valores
            $args = $_POST['blog'];
            //sincronizar objeto en memoria con lo que el usario escribe
            $blog->sincronizar($args);
            
            // debuggear($errores);
            //  Generar el nombre del archivo
            $nombreblog = md5(uniqid(rand(), true)) . ".jpg";
        
            if( $_FILES['blog']['tmp_name']['imagen'] ){
                //realizar el rezise
                $photo = Image::make($_FILES['blog']['tmp_name']['imagen'])->fit(800,600); //imagen se declara con el name del input file. //tmp_name es el nombre temporal del archivo en el servidor
        
                $blog->setImagen($nombreblog); //borrar la imagen previa y asigna la nueva al objeto
            }
            $errores = $blog->validar();
            
            if(empty($errores)){
                if( $_FILES['blog']['tmp_name']['imagen'] ){ //si la imagen se cargó
                    //almacenar la imagen en el directorio
                    $photo->save(IMAGENES_BLOG . $nombreblog);
                }
                $blog->guardar();
            }
        }
        $router->render('/blog/actualizarblog', [
            'blog' => $blog,
            'errores' => $errores,
        
        ]);
    }
    public static function eliminarblog(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){ //si se da clic al boton hidden con metodo post
            //debuggear($_POST); //imprime id => '1' tipo => blog
            $id = $_POST['id']; //id extraído de la global post del boton hidden
            
            $id = filter_var($id, FILTER_VALIDATE_INT); //valida que la entrada sea exactamente entero
            
            if($id){
    
                $tipo = $_POST['tipo'];
                // debuggear($tipo);    
                if(validarTipoContenido($tipo)){ //si es blog es true
                    $blog = Blog::find($id);
                    
                    $blog->eliminar();
                }           
            }
        }
    }
}