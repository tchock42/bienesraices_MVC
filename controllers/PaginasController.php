<?php
namespace Controllers; //agrupar con los otros controladores como Vendedores y Propiedades

use MVC\Router;
use Model\Propiedad;
use Model\Blog;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController{
    public static function index(Router $router){
        //se traen 3 propiedades del metodo get de la clase Propiedad
        $propiedades = Propiedad::get(3);
        $blogs = Blog::get(2);

        $inicio = true;
        $router->render('paginas/index', [
            'propiedades' => $propiedades, //se pasa el atributo $propidades a datos[]
            'blogs' => $blogs,
            'inicio' => $inicio
        ]);
    }

    public static function nosotros( Router $router){
        $router->render('paginas/nosotros');
    }
    public static function propiedades( Router $router){
        $propiedades=Propiedad::all();
        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }
    public static function propiedad( Router $router){
        $id = validarORedireccionar('/propiedades'); //existe un id y se accede por get
        //buscar la propiedad por id
        $propiedad = Propiedad::find($id);

        $router->render('paginas/propiedad', [
            'propiedad'=>$propiedad
        ]);
    }


    public static function contacto( Router $router){

        $mensaje = NULL;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // debuggear($_POST);
            $respuestas = $_POST['contacto'];
            // debuggear($respuestas);
            //crear una instancia de phpmailer
            $mail = new PHPMailer();

            //configurar SMTP
            $mail->isSMTP(); //protocolo smtp
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true; //requiere autenticación 
            $mail->Username = $_ENV['EMAIL_USER']; //usuario
            $mail->Password = $_ENV['EMAIL_PASS']; //password
            $mail->SMTPSecure = 'tls'; //correos no encriptados pero por via segura
            $mail->Port = $_ENV['EMAIL_PORT'];

            //configracion del contenido del email
            $mail->setFrom('admin@bienesraices.com'); //quien envia el email, evita que se envia a spam
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com'); //configura a quien le llega el correo
            $mail->Subject = 'Tienes un nuevo Mensaje'; //configura el nombre del correo

            //habilitar HTML
            $mail->isHTML(true); //metodo que habillita html
            $mail->CharSet = 'UTF-8'; //letras de lennguaje español

            // debuggear($respuestas);

            //definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>' ;
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . '</p>' ;

            //enviar de forma condicional algunos campos de email o telefono
            if($respuestas['contacto'] === 'telefono'){
                $contenido .= '<p>Eligió ser contactado por teléfono</p>' ;
                $contenido .= '<p>Teléfono: ' . $respuestas['telefono'] . ' </p>' ;
                $contenido .= '<p>Fecha Contacto: ' . $respuestas['fecha'] . ' </p>' ;
                $contenido .= '<p>Hora: ' . $respuestas['hora'] . ' </p>' ;
            }else{
                $contenido .= '<p>Eligió ser contactado por email</p>' ;
                $contenido .= '<p>Email: ' . $respuestas['email'] . ' </p>' ;
            }

            
            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . '</p>' ;
            $contenido .= '<p>Vende o compra: ' . $respuestas['tipo'] . '</p>' ;
            $contenido .= '<p>Precio o presupuesto: $' . $respuestas['precio'] . '</p>' ;          
            $contenido .= "</html>";

            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es texto alternativo sin HTML'; //contenido cuando el editor de email no sosporta html
            //Enviar el email
            if($mail->send()){ //retorna true si se envia, false si no se envía
                $mensaje = "Mensaje enviado correctamente";
            }else{
                $mensaje = "El mensaje no se pudo enviar";
            }
        }
        
        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }

}