<?php
    include_once("Producto.php");
    include_once("IParte1.php");
    include_once("IParte2.php");
    include_once("IParte3.php");
    include_once("AccesoDatos.php");

    class ProductoEnvasado extends Producto implements IParte1, IParte2, IParte3
    {
        public $id;
        public $codigoBarra;
        public $precio;
        public $pathFoto;


        public function __construct($nombre, $origen, $id = 0, $codigoBarra = 0, $precio = 0, $pathFoto = null)
        {
            parent::__construct($nombre, $origen);
            $this->id = $id;
            $this->codigoBarra = $codigoBarra;
            $this->precio = $precio;
            $this->pathFoto = $pathFoto;
        }

        public function Agregar()
        {
            $accesoDatos = AccesoDatos::ObjetoAccesoDatos();

            $sql = "INSERT INTO productos (codigo_barra, nombre, origen, precio, foto) VALUES (:codigo_barra, :nombre, :origen, :precio, :foto)";

            $query = $accesoDatos->RetornarConsulta($sql);

            $query->bindValue(':codigo_barra', $this->codigoBarra, PDO::PARAM_INT);
            $query->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $query->bindValue(':precio', strval($this->precio), PDO::PARAM_STR);
            $query->bindValue(':origen', $this->origen, PDO::PARAM_STR);
            $query->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);
            
            try
            {
                $query->execute();
                if($query->rowCount() > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch(PDOException $e)
            {
                echo "Error: {$e->getMessage()}";
                return false;
            }
        }


        public static function Traer()
        {
            $objetoAccesoDatos = AccesoDatos::ObjetoAccesoDatos();

            $query = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM productos");

            try
            {
                $query->execute();
                $array = $query->fetchAll(PDO::FETCH_OBJ);
                $arrayProducto = [];
                foreach($array as $item)
                {
                    $producto = new ProductoEnvasado($item->nombre, $item->origen, $item->id, $item->codigo_barra, $item->precio, $item->foto);
                    array_push($arrayProducto, $producto);
                }
                return $arrayProducto;
            }
            catch(PDOException $e)
            {
                echo "ERROR: {$e->getMessage()}";
            }
        }

        public function ToJSON()
        {
            $obj = new stdClass();
            $obj->nombre = $this->nombre;
            $obj->origen = $this->origen;
            $obj->id = $this->id;
            $obj->codigoBarra = $this->codigoBarra;
            $obj->precio = $this->precio;
            $obj->pathFoto = $this->pathFoto;
            
            return json_encode($obj);
        }

        public static function Eliminar($id)
        {
            $accesoDatos = AccesoDatos::ObjetoAccesoDatos();

            $query = $accesoDatos->RetornarConsulta("DELETE FROM productos WHERE id = :id");

            $query->bindValue(":id", $id, PDO::PARAM_INT);
            
            try
            {
                $query->execute();
                if($query->rowCount() > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch(PDOException $e)
            {
                echo "ERROR: {$e->getMessage()}";
                return false;
            }
        }

        public function Modificar()
        {
            $accesoDatos = AccesoDatos::ObjetoAccesoDatos();

            $query = $accesoDatos->RetornarConsulta("UPDATE productos SET nombre = :nombre, origen = :origen, codigo_barra = :codigo_barra,  precio = :precio, foto = :foto WHERE id = :id");

            $query->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
            $query->bindValue(":origen", $this->origen, PDO::PARAM_STR);
            $query->bindValue(":precio", strval($this->precio), PDO::PARAM_STR);
            $query->bindValue(":id", $this->id, PDO::PARAM_INT);
            $query->bindValue(":codigo_barra", $this->codigoBarra, PDO::PARAM_INT);
            $query->bindValue(":foto", $this->pathFoto, PDO::PARAM_STR);

            try
            {
                $query->execute();
                if($query->rowCount() > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch(PDOException $e)
            {
                echo "ERROR: {$e->getMessage()}";
                return false;
            }
        }

        public function Existe($arrayProducto)
        {
            $flag = false;

            foreach($arrayProducto as $item)
            {
                if($item->nombre == $this->nombre && $item->origen == $this->origen)
                {
                    $flag = true;
                    break;
                }
            }

            return $flag;
        }

        public function GuardarEnArchivo()
        {
            $path = "./archivos/productos_envasados_borrados.txt";
            
            $archivo = fopen($path, "a");
            
            if($this->pathFoto != null)
            {
                $extension = pathinfo($this->pathFoto,PATHINFO_EXTENSION);
                $date = date("Gis");
                $pathFotoBorrada = "productosBorrados/{$this->id}.{$this->nombre}.borrado.$date.{$extension}";
                copy("{$this->pathFoto}", $pathFotoBorrada);
                unlink($this->pathFoto);
            }

            $datos = "{$this->id} - {$this->nombre} - {$this->origen} - {$this->codigoBarra} - {$this->precio} - {$pathFotoBorrada}" . PHP_EOL;

            fwrite($archivo, $datos);

            fclose($archivo);
        }

        public static function MostrarBorradosJSON()
        {
            $path = "archivos/productos_eliminados.json";
            $archivo = fopen($path,"r");

            $json = fread($archivo, filesize($path));

            return $json;
        }

        public static function MostrarModificados()
        {   
            $path = "productosModificados/";
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