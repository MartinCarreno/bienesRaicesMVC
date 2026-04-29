<?php 
namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController{
    public static function crear( Router $router ){

        $errores = Vendedor::getErrores();
        $vendedor = new Vendedor;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //crear nueva instancia
            $vendedor = new Vendedor($_POST['vendedor']);

            //validar por campos vacios
            $errores = $vendedor->validar();

            //Guardar si no hay errores
            if(empty($errores)){
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/crear', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);

    }
    public static function actualizar( Router $router ){

        $errores = Vendedor::getErrores();
        $id = validarORedireccionar('/admin');
        $vendedor = Vendedor::find($id);
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //asignar valores
            $args = $_POST['vendedor'];

            //Sincronizar el objeto en memoria con lo que el usuario escribio 
            $vendedor->sincronizar($args);

            //validacion
            $errores = $vendedor->validar();
            
            if(empty($errores)){
                $vendedor->guardar();
            }
        }

        $router->render('/vendedores/actualizar', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }
    public static function eliminar( Router $router ){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id){
                //valida el tipo a eliminar
                $tipo = $_POST['tipo'];

                if(validarTipoContenido($tipo)){
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }

            }

        }
    }
}