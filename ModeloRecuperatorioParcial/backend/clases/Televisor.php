<?php

    require_once ("IParte2.php");
    require_once ("IParte3.php");
    require_once ("AccesoDatos.php");

    class Televisor implements IParte2, IParte3{

        public $id;
        public $tipo;
        public $precio;
        public $paisOrigen;
        public $path;


        public function __construct($id = 0 ,$tipo = "",$precio = 0, $paisOrigen = "", $path = ""){

            $this->id = $id;
            $this->tipo = $tipo;
            $this->precio = $precio;
            $this->paisOrigen = $paisOrigen;
            $this->path = $path;

        }

        public function ToString(){
            return $this->id . "-" . $this->tipo . "-" . $this->precio . "-" . $this->paisOrigen . "-" . $this->path;
        }

        public static function Traer(){

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM productos");

            $consulta->execute();

            $array = $consulta->fetchAll(PDO::FETCH_OBJ);
            
            $arrayTeles = [];

            foreach ($array as $item){

                $aux = new Televisor($item->id,$item->tipo,$item->precio,$item->paisOrigen,$item->path);

                array_push($arrayTeles,$aux);
            }

            return $arrayTeles;

        }

        public function Verificar($televisor){
 
            foreach($televisor as $item){
                if($item->tipo == $this->tipo && $item->paisOrigen == $this->paisOrigen){
                    return false;
                    break;
                }
            }
            return true;
        }

        public function Agregar(){

            $retorno = false;

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO productos (tipo, precio, paisOrigen, path)"
                                                        . "VALUES(:tipo, :precio, :paisOrigen, :path)");

            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':paisOrigen', $this->paisOrigen, PDO::PARAM_STR);
            $consulta->bindValue(':path', $this->path, PDO::PARAM_STR);

            $consulta->execute();

            if($consulta->rowCount() == 1){
                $retorno = true;
            }

            return $retorno;
        }

        public function CalcularIVA(){
            return $this->precio * 1.21;
        }

        public function Modificar(){

            $retorno = false;

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE productos SET precio = :precio, 
                                                            path = :path
                                                            WHERE tipo = :tipo && paisOrigen = :paisOrigen");

            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':paisOrigen', $this->paisOrigen, PDO::PARAM_STR);
            $consulta->bindValue(':path', $this->path, PDO::PARAM_STR);

            
            $consulta->execute();
    
            if($consulta->rowCount() == 1){
                $retorno = true;
            }

            return $retorno;
        }
    }

?>