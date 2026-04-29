<?php

namespace Model;

//se esta implementando el patron de active record
//ACTIVE RECORD no permite ARRAY, si OBJETOS
class Propiedad extends ActiveRecord {
    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'habitaciones', 'descripcion', 'wc', 'estacionamiento', 'creado', 'vendedor_id'];

    
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $habitaciones;
    public $descripcion;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedor_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedor_id = $args['vendedor_id'] ?? '';
    }

    public function validar(){
        if(!$this->titulo){
            self::$errores[] = "Debes añadir un titulo";
        }

        if(!$this->precio){
            self::$errores[] = "Precio es obligatorio";
        }

        if(strlen($this->descripcion)<50){
            self::$errores[] = "La descripcion es obligatoria y debe tener al menos 50 caracteres";
        }
        if(!$this->habitaciones){
            self::$errores[] = "El numero de habitaciones es obligatorio";
        }
        if(!$this->wc){
            self::$errores[] = "El numero de baños es obligatorio";
        }
        if(!$this->estacionamiento){
            self::$errores[] = "El numero de estacionamientos es obligatorio";
        }
        if(!$this->vendedor_id){
            self::$errores[] = "Elige un vendedor";
        }
      
        if(!$this->imagen){
            self::$errores[] = "La imagen es obligatoria";
        }

        //validar por tamaño (1mb maximo)
        //$medida = 1000 * 1000; //1000kb


        //if($this->imagen["size"] > $medida){
        //    self::$errores[] = "La imagen es muy pesada";
        //}

        return self::$errores;
    }

}
