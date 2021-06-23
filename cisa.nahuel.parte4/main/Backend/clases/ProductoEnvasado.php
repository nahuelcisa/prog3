<?php

    require_once ("Producto.php"); 
    require_once ("IParte1.php"); 
    require_once ("IParte2.php"); 
    require_once ("IParte3.php"); 
    require_once ("AccesoDatos.php");


    class ProductoEnvasado extends Producto implements IParte1, IParte2, IParte3
    {
        public $id;
        public $codigo_barra;
        public $precio;
        public $pathFoto;

        public function __construct($id = 0,$codigo_barra = 0,$precio = 0 ,$pathFoto = "", $nombre = "", $origen = "")
        {   
            parent::__construct($nombre,$origen);

            $this->id = $id;
            $this->codigo_barra = $codigo_barra;
            $this->precio = $precio;
            $this->pathFoto = $pathFoto;
        }

        public function ToJSON()
        {
            $std = new stdClass();

            $std->nombre = $this->nombre;
            $std->origen = $this->origen;
            $std->codigo_barra = $this->codigo_barra;
            $std->precio = $this->precio;
            $std->pathFoto = $this->pathFoto;

            return json_encode($std);
        }

        public function Agregar()
        {
            $retorno = false;

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO productos (codigo_barra, nombre, origen, precio,foto)"
                                                        . "VALUES(:codigo_barra, :nombre, :origen, :precio,:pathFoto)");

            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':origen', $this->origen, PDO::PARAM_STR);
            $consulta->bindValue(':codigo_barra', $this->codigo_barra, PDO::PARAM_STR);
            $consulta->bindValue(':precio', strval($this->precio), PDO::PARAM_INT);
            $consulta->bindValue(':pathFoto', $this->pathFoto, PDO::PARAM_STR);

            $consulta->execute();

            if($consulta->rowCount() == 1){
                $retorno = true;
            }

            return $retorno;
        }

        public static function Traer()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT productos.id,productos.codigo_barra,
            productos.nombre,productos.origen,productos.precio,productos.foto AS pathFoto FROM productos");

            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_OBJ);
        }

        public static function Eliminar($id)
        {
            $retorno = false;

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM productos WHERE id = :id");

            $consulta->bindValue(':id', $id, PDO::PARAM_INT);

            $consulta->execute();

            if($consulta->rowCount() == 1){
                $retorno = true;
            }

            return $retorno;
        }

        public function Modificar()
        {
            $retorno = false;

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE productos SET nombre = :nombre, origen = :origen, 
                                                            codigo_barra = :codigo_barra, precio = :precio, foto = :pathFoto 
                                                            WHERE id = :id");


            $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':origen', $this->origen, PDO::PARAM_STR);
            $consulta->bindValue(':codigo_barra', $this->codigo_barra, PDO::PARAM_STR);
            $consulta->bindValue(':precio', strval($this->precio), PDO::PARAM_INT);
            $consulta->bindValue(':pathFoto', $this->pathFoto, PDO::PARAM_STR);

            
            $consulta->execute();
    
            if($consulta->rowCount() == 1){
                $retorno = true;
            }

            return $retorno;
        }

        public function Existe($array)
        {
            foreach($array as $producto)
            {
                if($this->nombre == $producto->nombre && $this->origen == $producto->origen)
                {
                    return true;
                }
            }
            return false;
        }

        public function GuardarEnArchivo()
        {
            $nombreArchivo = "./archivos/productos_envasados_borrados.txt";
            $destinoFoto = "./productos/productosBorrados/";
            $archivo = fopen($nombreArchivo,"a");
            $datosGuardar = $this->id . " - " . $this->nombre . " - " . $this->origen . " - " . $this->codigo_barra . " - ". $this->precio . " - " . $this->pathFoto . "\n";

            if(fwrite($archivo,$datosGuardar))
            {
                $array = explode(".",$this->pathFoto);
                $tipo = pathinfo($this->pathFoto,PATHINFO_EXTENSION);
                $hora = date("G") . date("i") . date("s");
                $nombreFoto = "{$this->id}.{$this->nombre}.borrado.{$hora}.{$tipo}";

                $destinoFoto .= $nombreFoto;

                copy($this->pathFoto,$destinoFoto);
                unlink($this->pathFoto);
            }   
        } 
        
        public static function MostrarBorradosJSON()
        {
            $archivo = fopen("./archivos/productos_eliminados.json", "r");

            return $lectura = fread($archivo, filesize("./archivos/productos_eliminados.json"));

        }

        public static function MostrarModificados()
        {   
            $path = "./productos/productosModificados/";
            $directorio = opendir($path);
         
            $retorno = array();

            while($elemento = readdir($directorio))
            {
                if($elemento != "." && $elemento != "..")
                {

                        array_push($retorno,$elemento);   
                   
                }
            }

            return $retorno;
        }
    }

?>