<?php

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Request;
use Slim\Psr7\Response as ResponseMW;
use Slim\Psr7\Response;
require_once("AccesoDatos.php");

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
    
    public static function TraerTodosCD()
    {    
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id, titel AS titulo, interpret AS interprete, "
                                                        . "jahr AS anio FROM cds");        
        
        $consulta->execute();
        
        $consulta->setFetchMode(PDO::FETCH_OBJ);                                                

        return $consulta->fetchAll(); 
    }

    public static function TraerUnoCD($id)
    {    
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id, titel AS titulo, interpret AS interprete, jahr AS anio FROM cds WHERE id = :id");        
        $consulta->bindValue(':id',$id,PDO::PARAM_INT);
        $consulta->execute();
        
        $consulta->setFetchMode(PDO::FETCH_INTO, new cd);                                                

        return $consulta->fetch(); 
    }
    
    public function AgregarCD()
    {
        $retValue = new StdClass();
        $retValue->exito = false;
        $retValue->msj = "No se pudo Agregar el cd";
        $retValue->id_agregado = null;

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO cds (id, titel, interpret, jahr)"
        . "VALUES(:id, :titulo, :cantante, :anio)");
        
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':titulo', $this->titulo, PDO::PARAM_STR);
        $consulta->bindValue(':anio', $this->anio, PDO::PARAM_INT);
        $consulta->bindValue(':cantante', $this->interprete, PDO::PARAM_STR);
        
        $consulta->execute();   

        if($consulta->rowCount() > 0){
            $retValue->exito = true;
            $retValue->msj = "Cd agregado correctamente";
            $retValue->id_agregado = $objetoAccesoDato->lastInsertId();
        }

        return json_encode($retValue);
        
    }
    
    public function ModificarCD()
    {
        $retValue = new StdClass();
        $retValue->exito = false;
        $retValue->msj = "No se pudo modificar el cd";

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE cds SET titel = :titulo, interpret = :cantante, 
                                                        jahr = :anio WHERE id = :id");
        
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':titulo', $this->titulo, PDO::PARAM_STR);
        $consulta->bindValue(':anio', $this->anio, PDO::PARAM_INT);
        $consulta->bindValue(':cantante', $this->interprete, PDO::PARAM_STR);
        $consulta->execute();

        if($consulta->rowCount() > 0){
            $retValue->exito = true;
            $retValue->msj = "Cd modificado correctamente";
        }
        
        return json_encode($retValue);
    }

    public static function EliminarCD($id)
    {
        $retValue = new StdClass();
        $retValue->exito = false;
        $retValue->msj = "No se pudo Eliminar el cd";
        $retValue->rows_afected = null;

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM cds WHERE id = :id");
        
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        if($consulta->rowCount() > 0){
            $retValue->exito = true;
            $retValue->msj = "Cd eliminado correctamente";
            $retValue->rows_afected = $consulta->rowCount();
        }

        return json_encode($retValue);
    }

    public function TraerTodos(Request $request, Response $response, array $args) : Response{
        $data = self::TraerTodosCD();
        $newResponse = new Response();
        $newResponse->getBody()->write(json_encode($data));
        return $newResponse; 
    }

    public function TraerUno(Request $request, Response $response, array $args) : Response{
        $id = $args['id'];
        $data = self::TraerUnoCD($id);
        $newResponse = new Response();
        $newResponse->getBody()->write(json_encode($data));
        return $newResponse; 
    }

    public function Agregar(Request $request, Response $response, array $args) : Response{
        $cdJson = json_decode($request->getParsedBody()['obj_json']);
        $this->titulo = $cdJson->titulo;
        $this->interprete = $cdJson->interprete;
        $this->anio = $cdJson->anio;
        $data = json_decode($this->AgregarCD());
        $newResponse = new Response();
        $newResponse->getBody()->write(json_encode($data));
        return $newResponse; 
    }

    public function Modificar(Request $request, Response $response, array $args) : Response{
        $cdJson = json_decode($request->getBody());
        $this->id = $cdJson->id;
        $this->titulo = $cdJson->titulo;
        $this->interprete = $cdJson->interprete;
        $this->anio = $cdJson->anio;
        $data = json_decode($this->ModificarCD());
        $newResponse = new Response();
        $newResponse->getBody()->write(json_encode($data));
        return $newResponse; 
    }

    public function Eliminar(Request $request, Response $response, array $args) : Response{
        $obj_json = json_decode($request->getBody());
        $data = json_decode($this->EliminarCD($obj_json->id));
        $newResponse = new Response();
        $newResponse->getBody()->write(json_encode($data));
        return $newResponse; 
    }
    
}