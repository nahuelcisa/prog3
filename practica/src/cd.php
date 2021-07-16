<?php
    require_once("AccesoDatos.php");
    use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
    use Slim\Psr7\Request;
    use Slim\Psr7\Response as ResponseMW;
    use Slim\Psr7\Response;

    class cd
    {
        public $id;
        public $titulo;
        public $interprete;
        public $anio;

        public function MostrarDatos()
        {
            return $this->id." - ".$this->titulo." - ".$this->interprete." - ".$this->anio;
        }
        
        public static function TraerTodosLosCd()
        {    
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id, titel AS titulo, interpret AS interprete, "
                                                            . "jahr AS anio FROM cds");        
            
            $consulta->execute();
            
            $consulta->setFetchMode(PDO::FETCH_OBJ);                                               

            return $consulta->fetchAll(); 
        }
        public static function TraerUnCD($id)
        {    
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id, titel AS titulo, interpret AS interprete, "
                                                            . "jahr AS anio FROM cds WHERE id = :id");        

            $consulta->bindValue(':id',$id, PDO::PARAM_INT);

            $consulta->execute();
            
            $consulta->setFetchMode(PDO::FETCH_OBJ);                                               

            return $consulta->fetchAll(); 
        }
        
        public static function InsertarElCD($titulo,$anio,$interprete)
        {

            $retorno = new stdClass();
            $retorno->ultimoID = NULL;
            $retorno->mensaje = "No se pudo agregar";

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO cds (titel, interpret, jahr)"
                                                        . "VALUES(:titulo, :cantante, :anio)");
            
            $consulta->bindValue(':titulo', $titulo, PDO::PARAM_STR);
            $consulta->bindValue(':anio', $anio, PDO::PARAM_INT);
            $consulta->bindValue(':cantante', $interprete, PDO::PARAM_STR);

            $consulta->execute();

            if($consulta->rowCount()){
                $retorno->ultimoID = $objetoAccesoDato->RetornarUltimoIdInsertado();
                $retorno->mensaje = "Se pudo agregar con exito";
            }

            return json_encode($retorno);
        }
        
        public static function ModificarCD($id, $titulo, $anio, $cantante)
        {

            $retorno = new stdClass();
            $retorno->mensaje = "No se pudo modificar";

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE cds SET titel = :titulo, interpret = :cantante, 
                                                            jahr = :anio WHERE id = :id");
            
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->bindValue(':titulo', $titulo, PDO::PARAM_STR);
            $consulta->bindValue(':anio', $anio, PDO::PARAM_INT);
            $consulta->bindValue(':cantante', $cantante, PDO::PARAM_STR);

            $consulta->execute();

            if($consulta->rowCount()){
                $retorno->mensaje = "Se pudo modificar con exito";
            }

            return json_encode($retorno);

        }

        public static function EliminarCD($id)
        {
            $retorno = new stdClass();
            $retorno->mensaje = "No se pudo eliminar";
            $retorno->cantidad = 0;

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM cds WHERE id = :id");
            
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);

            $consulta->execute();

            if($consulta->rowCount()){
                $retorno->mensaje = "Se pudo eliminar con exito";
                $retorno->cantidad = $consulta->rowCount();
            }

            return json_encode($retorno);

        }

        public function TraerTodos(Request $request, Response $response, array $args) : Response{
            $cds = self::TraerTodosLosCd();
            $newResponse = new Response();
            $newResponse->getBody()->write(json_encode($cds));
            return $newResponse;
        }

        public function TraerUno(Request $request, Response $response, array $args) : Response{

            $params = $args["id"];

            $cd = self::TraerUnCD($params);

            $newResponse = new Response();
            $newResponse->getBody()->write(json_encode($cd));
            return $newResponse;
        }

        public function Agregar(Request $request, Response $response, array $args) : Response{

            $params = $request->getParsedBody();

            $insertado = self::InsertarElCD($params["titulo"],$params["anio"],$params["interprete"]);
            $newResponse = new Response();
            $newResponse->getBody()->write($insertado);
            return $newResponse;
        }

        public function Modificar(Request $request, Response $response, array $args) : Response{
            $params = json_decode($request->getBody());
            $modificado = self::ModificarCD($params->id,$params->titulo,$params->anio,$params->interprete);
            $newResponse = new Response();
            $newResponse->getBody()->write($modificado);
            return $newResponse;
        }

        public function Eliminar(Request $request, Response $response, array $args) : Response{

            $params = json_decode($request->getBody());
            $modificado = self::EliminarCD($params->id);
            $newResponse = new Response();
            $newResponse->getBody()->write($modificado);
            return $newResponse;
        }

        
    }
?>