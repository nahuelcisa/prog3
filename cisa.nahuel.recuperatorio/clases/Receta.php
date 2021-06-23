<?php

    require_once ("IParte1.php");   
    require_once ("IParte2.php");   
    require_once ("IParte3.php");   
    require_once ("AccesoDatos.php");

    class Receta implements IParte1,IParte2,IParte3{

        public $id;
        public $nombre;
        public $ingredientes;
        public $tipo;
        public $pathFoto;


        public function __construct($id = 0, $nombre = "", $ingredientes = "",$tipo = "",$pathFoto = "")
        {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->ingredientes = $ingredientes;
            $this->tipo = $tipo;
            $this->pathFoto = $pathFoto;
        }

        public function ToJSON(){

            $std = new stdClass();

            $std->id = $this->id;
            $std->nombre = $this->nombre;
            $std->ingredientes = $this->ingredientes;
            $std->tipo = $this->tipo;
            $std->pathFoto = $this->pathFoto;

            return json_encode($std);
        }

        public function Agregar(){

            $retorno = false;

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO recetas (nombre, ingredientes, tipo, path_foto)"
                                                        . "VALUES(:nombre, :ingredientes, :tipo, :pathFoto)");

            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':ingredientes', $this->ingredientes, PDO::PARAM_STR);
            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
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

            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT recetas.id,recetas.nombre,
            recetas.ingredientes,recetas.tipo,recetas.path_foto AS pathFoto FROM recetas");

            $consulta->execute();

            $array = $consulta->fetchAll(PDO::FETCH_OBJ);
            
            $arrayRecetas = [];

            foreach ($array as $item){

                $aux = new Receta($item->id,$item->nombre,$item->ingredientes,$item->tipo, $item->pathFoto);

                array_push($arrayRecetas,$aux);
            }

            return $arrayRecetas;
        }

        public function Modificar()
        {
            $retorno = false;

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE recetas SET nombre = :nombre, ingredientes = :ingredientes, 
                                                            tipo = :tipo, path_foto = :pathFoto 
                                                            WHERE id = :id");

            $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':ingredientes', $this->ingredientes, PDO::PARAM_STR);
            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $consulta->bindValue(':pathFoto', $this->pathFoto, PDO::PARAM_STR);

            
            $consulta->execute();
    
            if($consulta->rowCount() == 1){
                $retorno = true;
            }

            return $retorno;
        }

        public function Existe($recetas)
        {
            foreach($recetas as $receta)
            {
                if($this->nombre == $receta->nombre && $this->tipo == $receta->tipo)
                {
                    return true;
                }
            }
            return false;
        }

        public function Eliminar()
        {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();

            $consulta = $accesoDatos->RetornarConsulta("DELETE FROM recetas WHERE nombre = :nombre AND tipo = :tipo");

            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);

            try{
                $consulta->execute();

                if($consulta->rowCount() > 0){
                    return true;
                }else{
                    return false;
                }
            }catch(PDOException $e){
                echo "Error: " . $e->getMessage();
                return false;
            }
        }

        public function GuardarEnArchivo()
        {
            $path = './archivos/recetas_borradas.txt';

            $archivo = fopen($path, "a");

            if($this->pathFoto != null){
                $extension = pathinfo($this->pathFoto, PATHINFO_EXTENSION);
                $fecha = date("Gis");
                $pathFotoBorrada = "recetasBorradas/{$this->id}.{$this->tipo}.{$fecha}.{$extension}";
                copy("{$this->pathFoto}", $pathFotoBorrada);
                unlink($this->pathFoto);
            }

            $datos = "{$this->id}-{$this->nombre}-{$this->ingredientes}-{$this->tipo}-{$pathFotoBorrada}" . PHP_EOL;

            fwrite($archivo, $datos);

            fclose($archivo);
        }

    }
?>