<?php 

namespace Model;

class ActiveRecord {
    
    //BASE DE DATOS

    protected static $db; //con static no se reescribe, asi si es que hay muchas consultas no consumira tantos recursos
    //este arreglo nos permite identificar los campos para despues mapear, son con los mismos nombres que en la base de datos, esto es para seguir el patron Active Record 
    protected static $columnasDB = [];

    protected static $tabla = ''; // luego para llamar las propiedades no se utiliza self:: sino static::

    //ERRORES
    protected static $errores = [];





    //Definir la conexion a la DB
    public static function setDB($database) {
        self::$db = $database; 
    }

    public function guardar(){
        if(!is_null($this->id)){
            //Actualizar
            $this->actualizar();
        } else {    
            //Crear nuevo registro
            $this->crear();
        }
    }


    public function crear(){ //metodo para guardar en la base de datos
        
        //Sanitiar Datos
        $atributos = $this->sanitizarAtributos();
        
        //utilizar metodo de array para aplanar los datos, asi en el query escribo menos
        //$string = join(', ',array_keys($atributos));//en el join primero va el separador, y luego el arreglo para recorrer
        //esto muestra algo como esto: string(91) "titulo, precio, imagen, habitaciones, descripcion, wc, estacionamiento, creado, vendedor_id"
        
        //con este cofigo nos permite crear los insert de manera mas dinamica, esta es la forma orientada a objetos
        $query = " INSERT INTO " . static::$tabla . " ( "; 
        $query .= join(', ',array_keys($atributos));// se coloca .= para seguir con la linea de abajo
        $query .= " ) VALUES(' ";
        $query .= join("', '",array_values($atributos));
        $query .= " ') ";
        
        $resultado = self::$db->query($query);
        if ($resultado){
            //redireccionar al usuario. para no meter datos duplicados, solo funciona si no hay nada de html antes de ejecutar
            header("Location: /admin?resultado=1"); //? es query string
        }
        return $resultado;
    }

    public function actualizar(){
        //Sanitiar Datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";

            
        }
       

        
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);

        if ($resultado){
            //redireccionar al usuario. para no meter datos duplicados, solo funciona si no hay nada de html antes de ejecutar
            header("Location: /admin?resultado=2"); //? es query string
        }

    }

    //Eliminar un registro
    public function eliminar() {
        
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado) {
            $this->borrarImagen();
            header('location: /admin?resultado=3');
        }
    }

    //identifica  y une los atributos de la DB (Mapea los atributos)
    public function atributos(){
        $atributos = [];
        foreach(static::$columnasDB as $columna){

            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }

        return $atributos;
    }


    public function sanitizarAtributos(){
        $atributos = $this->atributos();
        $sanitizado = [];
        
        foreach ($atributos as $key => $value){ //arreglo asociativo para obtener los valores y llaves de atributos
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
        
    }   

    //VALIDACION
    public static function getErrores(){
        
        return static::$errores;
    }

    public function validar(){
        
        static::$errores = [];
        return static::$errores;
    }

    public function setImagen($imagen){
        
        //Elimina la imagen existente
        if(!is_null($this->id)) {
            $this->borrarImagen();
        }


        // Asignar al atributo de imagen el nombre de la imagen 
        if($imagen){
            $this->imagen = $imagen; 
        }
    }

    // Eliminar Archivo
    public function borrarImagen(){
        //comprobar si existe el archivo
            $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
            if($existeArchivo){
                unlink(CARPETA_IMAGENES . $this->imagen);
            }
    }

    //Lista todos los registros

    public static function all(){
        $query = "SELECT * FROM " . static::$tabla; //con static puuedo llamar los atributos de las otras clases

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    //Obtener un numero determinado de registros
    public static function get($cantidad){
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad; //con static puuedo llamar los atributos de las otras clases

        $resultado = self::consultarSQL($query);

        return $resultado;
    }



    //Buscar registro por id

    public static function find($id){
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";
        
        $resultado = self::consultarSQL($query);

        return array_shift($resultado); //shift devuelve el primer objeto del array, como un [0]
    
    }

    public static function consultarSQL($query){
        //Consultar DB
        $resultado = self::$db->query($query);

        //Iterar Resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro); //aqui se llama crear objeto con los registros de la base de datos para que sean objetos como tal
        }

        //Liberar Memoria
        $resultado->free();

        //Retornar resultados
        return $array;
    }

    protected static function crearObjeto($registro){
        $objeto = new static;
        

        foreach($registro as $key => $value){
            if(property_exists($objeto,$key)){
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    //Sincronizar el objeto en memoria con los cambios del usuario
    public function sincronizar( $args = [] ){
        foreach($args as $key => $value){
            if(property_exists($this, $key) && !is_null($value)){
                $this->$key = $value;
            }
        }
    }
}