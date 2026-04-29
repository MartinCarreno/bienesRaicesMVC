<?php 

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index( Router $router ){
        
        $propiedades = Propiedad::get(3);
        $inicio = true;

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }
    public static function nosotros( Router $router ){
        $router->render('paginas/nosotros');
    }
    public static function propiedades( Router $router ){

        

        $propiedades = Propiedad::all();
        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }
    
    public static function propiedad( Router $router ){

        $id = validarORedireccionar('/propiedades');
        $propiedad = Propiedad::find($id);
        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }
    public static function blog( Router $router ){
        $router->render('paginas/blog');
    }
    public static function entrada( Router $router ){
        $router->render('paginas/entrada');
    }
    public static function contacto( Router $router ){

        $mensaje = null;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $respuestas = $_POST['contacto'];


            //crear una instancia de phpmailer
            $mail = new PHPMailer();

            //configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = 'e0a287fa38443c';
            $mail->Password = '12150560802d3e';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            //Configurar el contenido del mail
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $mail->Subject = 'Tienes un Nuevo Mensaje';

            //Habilitar HTMl
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            //definir Contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . '</p>';
            $contenido .= '<p>Email: ' . $respuestas['email'] . '</p>';

            // Enviar de forma condicional algunos campos de email o telefono

            if($respuestas['contacto'] === 'telefono'){
                $contenido .= '<p>Eligio ser contactado por telefono</p>';
                $contenido .= '<p>Telefono: ' . $respuestas['telefono'] . '</p>';
                $contenido .= '<p>Fecha: ' . $respuestas['fecha'] . '</p>';
                $contenido .= '<p>Hora: ' . $respuestas['hora'] . '</p>';
            } else {
                //es email
                $contenido .= '<p>Eligio ser contactado por email</p>';
                $contenido .= '<p>Email: ' . $respuestas['email'] . '</p>';
            }

            
            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . '</p>';
            $contenido .= '<p>Vende o Compra: ' . $respuestas['tipo'] . '</p>';
            $contenido .= '<p>Precio o Presupuesto: $' . $respuestas['precio'] . '</p>';
            $contenido .= '<p>Preferencia Contacto: ' . $respuestas['contacto'] . '</p>';
            
            $contenido .= '</html>';



            $mail->Body = $contenido;
            $mail->AltBody = 'esto es texto alternativo sin HTML';


            //Enviar Email
            if($mail->send()){
                $mensaje = "Mensaje Enviado Correctamente";
            } else {
                $mensaje = "El Mensaje No Fue Enviado";
            }


        }
        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]); 
    }
    
}