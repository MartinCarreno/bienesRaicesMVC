<?php 
namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;


class PropiedadController {
    public static function index(Router $router) {
        
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();

        //muestra mensaje condicional
        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'vendedores' => $vendedores,
            'resultado' => $resultado
        ]);
    }
    public static function crear(Router $router) {

        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();

        //arreglo con mensajes de errores
        $errores =Propiedad::getErrores();

        //metodo post para actualizar
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // Asignar los datos del formulario a la nueva propiedad
            $propiedad = new Propiedad($_POST['propiedad']);    

            // Generar un nombre unico
            $nombreImagen = md5( uniqid(rand(),true)) . ".jpg";
            //es mejor guardar las rutas en la base de datos que las propias imagenes

            if($_FILES['propiedad']['tmp_name']['imagen']){
                $manager = new Image(Driver::class); //la variable manager es como se define cuando utilizamos intervetion image
                $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600); //cover es para cortar y resizing combinados
                $propiedad->setImagen($nombreImagen);    
            }

            $errores = $propiedad->validar();

            if(empty($errores)){
                /**Subida de Archivos */

                if (!is_dir(CARPETA_IMAGENES)){
                    mkdir(CARPETA_IMAGENES, 0777, true);
                }   

                //Guarda la imagen en el server
                if (isset($imagen)) {
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                }

                $propiedad->guardar();   

            }
        }


        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores
            
        ]);
    }
    public static function actualizar(Router $router) {
        $id = validarORedireccionar('/admin');
        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();

        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //ASIGNAR ATRIBUTOS
            $args = $_POST['propiedad'];


            $propiedad->sincronizar($args);

            //Validación
            $errores = $propiedad->validar();

            // Generar un nombre unico
                $nombreImagen = md5( uniqid(rand(),true)) . ".jpg";
                //es mejor guardar las rutas en la base de datos que las propias imagenes

                if($_FILES['propiedad']['tmp_name']['imagen']){
                    $manager = new Image(Driver::class); //la variable manager es como se define cuando utilizamos intervetion image
                    $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600); //cover es para cortar y resizing combinados
                    $propiedad->setImagen($nombreImagen); 
                }
            // asignar files hacia una variable
            //$imagen = $_FILES['imagen'];



            if (empty($errores)) {
                //debugear($_FILES['propiedad']);
                

                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES, 0777, true);
                }
                
                // Solo guardar la imagen si se subió una nueva
                if (isset($imagen)) {
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                }
                $propiedad->guardar();
            };
        }

        $router->render('/propiedades/actualizar', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            
            //validar ID
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id){

                $tipo = $_POST['tipo'];

                if(validarTipoContenido($tipo)){
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            }
        }
    }

}